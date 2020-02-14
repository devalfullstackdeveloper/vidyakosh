<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Helpers\Auth\Auth;
use Illuminate\Http\Request;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Helpers\Frontend\Auth\Socialite;
use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserLoggedOut;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Repositories\Frontend\Auth\UserSessionRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use App\Models\Departments;
use App\Rules\Captcha;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Adldap\Laravel\Facades\Adldap;



/**
 * Class LoginController.
 */
class LoginController extends Controller
{
	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @return string
	 */
	public function redirectPath()
	{
		return route(home_route());
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showLoginForm()
	{
		if(request()->ajax()){
			return ['socialLinks' => (new Socialite)->getSocialLinks()];
		}
		  $department_id = session('department_id');
		  $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
		 if(isset($departmentdata)){
		  $logo = $departmentdata->logo;
		  }
		else
		{
			$logo = 'govt.png';
		}
		return redirect('/')->with('show_login','logo', true);
	}

	/**
	 * Get the login username to be used by the controller.
	 *
	 * @return string
	 */
	public function username()
	{
		return config('access.users.username');
	}



	public function login(Request $request)
	{
		$validator = Validator::make(Input::all(), [
			'email' => 'required|email|max:255',
			'password' => 'required|min:6',
			'g-captcha-response' => new Captcha(),
		]);

		if($validator->passes()){

			$credentials = $request->only($this->username(), 'password');
                        $credentials['password'] = base64_decode($credentials['password']);
                        
			$authSuccess = \Illuminate\Support\Facades\Auth::attempt($credentials, $request->has('remember'));

			if($authSuccess) {

				$request->session()->regenerate();
				if(auth()->user()->active > 0){
					if(auth()->user()->isAdmin()){
						$redirect = 'dashboard';
					}else{
						// $redirect = 'back';
						$redirect = '/user/mycourse';
					}
					return response(['success' => true,'redirect' => $redirect], Response::HTTP_OK);
				
				}else{

					return
						response([
							'success' => false,
							'message' => 'Login failed. Account is not active'
						], Response::HTTP_FORBIDDEN);
				}
			} else {

				$SearchUser = User::where('email', '=', $request->input('email'))->first();

				if ($SearchUser) {
					return
						response([
							'success' => false,
							'message' => 'Login failed. Password Do Not match'
						], Response::HTTP_FORBIDDEN);
				}


				$password = $request->password;
				$user = Adldap::search()->where('email', '=', $request->email )->first();

				if ($user) {

					if (Hash::check($password, $user->password)) {

						//Now Create user
						$userData = new User();
						$userData->first_name = $user->first_name;
						$userData->last_name = $user->last_name;
						$userData->email = $user->email;
						$userData->password = $request->password;
						$userData->save();

						Auth::login($user);
						//$request->session()->regenerate();
						if(auth()->user()->active > 0){
							if(auth()->user()->isAdmin()){
								$redirect = 'dashboard';
							}else{
								// $redirect = 'back';
								$redirect = '/user/mycourse';
							}
							return response(['success' => true,'redirect' => $redirect], Response::HTTP_OK);
						}
					} else {
						return
							response([
								'success' => false,
								'message' => 'Login failed. Account not found'
							], Response::HTTP_FORBIDDEN);
					}
				} else {
					return
						response([
							'success' => false,
							'message' => 'Login failed. Account not found'
						], Response::HTTP_FORBIDDEN);
				}
				// return
				// 	response([
				// 		'success' => false,
				// 		'message' => 'Login failed. Account not found'
				// 	], Response::HTTP_FORBIDDEN);
			}

		}

		return response(['success'=>false,'errors' => $validator->errors()]);

	}


	/**
	* The user has been authenticated.
	*
	* @param Request $request
	* @param         $user
	*
	* @return \Illuminate\Http\RedirectResponse
	* @throws GeneralException
	*/
	protected function authenticated(Request $request, $user)
	{
		/*
		 * Check to see if the users account is confirmed and active
		 */
		if (! $user->isConfirmed()) {
			auth()->logout();

			// If the user is pending (account approval is on)
			if ($user->isPending()) {
				throw new GeneralException(__('exceptions.frontend.auth.confirmation.pending'));
			}

			// Otherwise see if they want to resent the confirmation e-mail

			throw new GeneralException(__('exceptions.frontend.auth.confirmation.resend', ['url' => route('frontend.auth.account.confirm.resend', $user->{$user->getUuidName()})]));
		} elseif (! $user->isActive()) {
			auth()->logout();
			throw new GeneralException(__('exceptions.frontend.auth.deactivated'));
		}

		event(new UserLoggedIn($user));

		// If only allowed one session at a time
		if (config('access.users.single_login')) {
			resolve(UserSessionRepository::class)->clearSessionExceptCurrent($user);
		}

		return redirect()->intended($this->redirectPath());
	}

	/**
	 * Log the user out of the application.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{
		/*
		 * Remove the socialite session variable if exists
		 */
		if (app('session')->has(config('access.socialite_session_name'))) {
			app('session')->forget(config('access.socialite_session_name'));
		}

		/*
		 * Remove any session data from backend
		 */
		app()->make(Auth::class)->flushTempSession();

		/*
		 * Fire event, Log out user, Redirect
		 */
		event(new UserLoggedOut($request->user()));

		/*
		 * Laravel specific logic
		 */
		$this->guard()->logout();
		$request->session()->invalidate();

		//return redirect()->route('frontend.index');
		return redirect('/');
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function logoutAs()
	{
		// If for some reason route is getting hit without someone already logged in
		if (! auth()->user()) {
			return redirect()->route('frontend.auth.login');
		}

		// If admin id is set, relogin
		if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
			// Save admin id
			$admin_id = session()->get('admin_user_id');

			app()->make(Auth::class)->flushTempSession();

			// Re-login admin
			auth()->loginUsingId((int) $admin_id);

			// Redirect to backend user page
			return redirect()->route('admin.auth.user.index');
		} else {
			app()->make(Auth::class)->flushTempSession();

			// Otherwise logout and redirect to login
			auth()->logout();

			return redirect()->route('frontend.auth.login');
		}
	}
}
