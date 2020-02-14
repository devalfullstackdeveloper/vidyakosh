<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer; 
use Cart; 
use Auth; 
use App\Models\Departments;
use App\Models\Ministry;
use DB;
use App\Models\SettingManage;
use App\Models\Auth\User;
use App\Models\Crttraining;
use App\Models\Track;
use App\Models\Designations;
use App\Models\UserFeedback;
use Mail;




class CoursesController extends Controller
{

    private $path;

    public function __construct()
    {
        $path = 'frontend';
        if(session()->has('display_type')){
            if(session('display_type') == 'rtl'){
                $path = 'frontend-rtl';
            }else{
                $path = 'frontend';
            }
        }else if(config('app.display_type') == 'rtl'){
            $path = 'frontend-rtl';
        }
        $this->path = $path;
    }

    public function all()
    { 
        $department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
		
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            //$request->session()->put('department_id', $department_id);
            session(['department_id' => $department_id]);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
			
        }
		
   
        if (request('type') == 'popular') {
            $courses = Course::withoutGlobalScope('filter')
           ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)
            ->where('published', 1)->where('popular', '=', 1) 
            ->orderBy('courses.title')->paginate(10);
			
			 $coursescountt = Course::withoutGlobalScope('filter')
           ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)
            ->where('published', 1)->where('popular', '=', 1) 
            ->orderBy('courses.title')->count();
		

        } else if (request('type') == 'trending') {
            $courses = Course::withoutGlobalScope('filter')
            ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)
           ->where('published', 1)->where('trending', '=', 1)->orderBy('courses.title')->paginate(9);
			
			$coursescountt = Course::withoutGlobalScope('filter')
            ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)
           ->where('published', 1)->where('trending', '=', 1)->orderBy('courses.title')->count();

        } else if (request('type') == 'featured') {
            $courses = Course::withoutGlobalScope('filter')				
            ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)
           ->where('published', 1)->where('featured', '=', 1)->orderBy('courses.title')->paginate(9);
			$coursescountt = Course::withoutGlobalScope('filter')				
            ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)
           ->where('published', 1)->where('featured', '=', 1)->orderBy('courses.title')->count();

        } 

        else if (request('type') == 'good') {
                $courses = Course::withoutGlobalScope('filter')		
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
                ->join('reviews', 'courses.id', '=', 'reviews.reviewable_id')
                ->where('course_department.department_id',$department_id)->where('reviews.rating','=',1)->where('published', 1)->orderBy('courses.title')->paginate(9);
			
				$coursescountt = Course::withoutGlobalScope('filter')		
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
                ->join('reviews', 'courses.id', '=', 'reviews.reviewable_id')
                ->where('course_department.department_id',$department_id)->where('reviews.rating','=',1)->where('published', 1)->orderBy('courses.title')->count();
            }
               else if (request('type') == 'average') {
                $courses = Course::withoutGlobalScope('filter')			
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
                ->join('reviews', 'courses.id', '=', 'reviews.reviewable_id')
                ->where('course_department.department_id',$department_id)->where('reviews.rating','=',2)->where('published', 1)->orderBy('courses.title')->paginate(9);
				  $coursescountt =  Course::withoutGlobalScope('filter')			
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
                ->join('reviews', 'courses.id', '=', 'reviews.reviewable_id')
                ->where('course_department.department_id',$department_id)->where('reviews.rating','=',2)->where('published', 1)->orderBy('courses.title')->count();
            }
            else if (request('type') == 'classic') {
                $courses = Course::withoutGlobalScope('filter')
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
                ->join('reviews', 'courses.id', '=', 'reviews.reviewable_id')
                ->where('course_department.department_id',$department_id)->where('reviews.rating','=',3)->where('published', 1)->orderBy('courses.title')->paginate(9);
				$coursescountt = Course::withoutGlobalScope('filter')
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
                ->join('reviews', 'courses.id', '=', 'reviews.reviewable_id')
                ->where('course_department.department_id',$department_id)->where('reviews.rating','=',3)->where('published', 1)->orderBy('courses.title')->count();
            }
               else if (request('type') == 'best') {
                $courses = Course::withoutGlobalScope('filter')
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
                ->join('reviews', 'courses.id', '=', 'reviews.reviewable_id')
                ->where('course_department.department_id',$department_id)->where('reviews.rating','=',4)->where('published', 1)->orderBy('courses.title')->paginate(9);
				   
				  $coursescountt = Course::withoutGlobalScope('filter')
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
                ->join('reviews', 'courses.id', '=', 'reviews.reviewable_id')
                ->where('course_department.department_id',$department_id)->where('reviews.rating','=',4)->where('published', 1)->orderBy('courses.title')->count();
				   
            }
             else if (request('type') == 'perfect') {
               $courses = Course::withoutGlobalScope('filter')
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
                ->join('reviews', 'courses.id', '=', 'reviews.reviewable_id')
                ->where('course_department.department_id',$department_id)->where('reviews.rating','=',5)->where('published', 1)->orderBy('courses.title')->paginate(9);
				 
				 $coursescountt = Course::withoutGlobalScope('filter')
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
                ->join('reviews', 'courses.id', '=', 'reviews.reviewable_id')
                ->where('course_department.department_id',$department_id)->where('reviews.rating','=',5)->where('published', 1)->orderBy('courses.title')->count();
            }
        else {


            $courses = Course::withoutGlobalScope('filter')
            ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)->where('published', 1)->orderBy('courses.title')->paginate(10);
			
			 $coursescountt = Course::withoutGlobalScope('filter')
            ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)->where('published', 1)->orderBy('courses.title')->count();
			
        }
        $purchased_courses = NULL;
        $purchased_bundles = NULL;
        //$categories = Category::
         //join('department_categories', 'categories.id', '=', 'department_categories.cat_id')
           //->where('department_categories.department_id',$department_id)
      //->get();
		$categories = Category::where('status','=',1)->get();
        if (\Auth::check()) {
            $purchased_courses = Course::withoutGlobalScope('filter')->whereHas('students', function ($query) {
                $query->where('id', \Auth::id());
            })
                ->with('lessons')
                ->orderBy('id', 'desc')
                ->get();
        }
        $featured_courses = Course::withoutGlobalScope('filter')
        ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)->where('published', '=', 1)
            ->where('featured', '=', 1)->take(8)->get();

        $coursescount = Course::count();
        $usercount = User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();
        $crttrainingcount = Crttraining::count();
        $crtcurrentcount = Crttraining::whereYear('created_at','=', now()->year)->count();
        $executivebrifing = Crttraining::where('training_type','=', 2)->count();
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
		$tracks = DB::table('tracks')->where('department_id','=',$department_id)->where('status','=',1)->get();
		$designation = Designations::where('status',1)->where('department_id','=',$department_id)->get();
		$coursetype = DB::table('course_type')->where('status','=',1)->get();
		
		$rating = DB::table('reviews')
               ->select('reviewable_id', DB::raw('AVG(rating) as rating'))
                ->groupBy('reviewable_id')->get();
		$level = DB::table('course_difficulty')
               ->select('id','name')
                ->get();
		$usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->first();
		$visitor = DB::table('visitor_count')->count();
		//return $currentcoursecount = count($courses);
        return view( $this->path.'.courses.index', compact('courses', 'purchased_courses', 'recent_news','featured_courses','categories','ministry','departments','allministry','alldepartments','logo','coursescount','usercount','crttrainingcount','crtcurrentcount','executivebrifing','tracks','rating','designation','coursetype','level','coursescountt','lastupdateddate','visitor'));
    }

    public function show($course_slug)
    { 
        $department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();  
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            $request->session()->put('department_id', $department_id);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
        }


        $continue_course=NULL;
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $course = Course::withoutGlobalScope('filter')
        // ->join('course_department', 'courses.id', '=', 'course_department.course_id')
        //    ->where('course_department.department_id',$department_id)
        ->where('slug', $course_slug)->with('publishedLessons')->first();
    	
         $subcourseid =  $course->sub_cat_id;
		 $dif =$course->difficulty_id;
		 $diffname= DB::table('course_difficulty')->where('id',$dif)->first();
         $subcourse = DB::table('courses')
                     ->join('categories','courses.category_id','=','categories.id')
                     ->join('sub_categories','courses.sub_cat_id','=','sub_categories.id')
                     ->select('courses.id','courses.title','courses.description','courses.course_image','categories.name','sub_categories.name as subname')
                     ->where('courses.sub_cat_id', $subcourseid)
                     ->get();


         $purchased_course = \Auth::check() && $course->students()->where('user_id', \Auth::id())->count() > 0;
        if(($course->published == 0) && ($purchased_course == false)){
            abort(404);
        }
        $course_rating = 0;
        $total_ratings = 0;
        $completed_lessons = "";
        $is_reviewed = false;
        if(auth()->check() && $course->reviews()->where('user_id','=',auth()->user()->id)->first()){
            $is_reviewed = true;
        }
        if ($course->reviews->count() > 0) {
            $course_rating = $course->reviews->avg('rating');
            $total_ratings = $course->reviews()->where('rating', '!=', "")->get()->count();
        }
        $lessons = $course->courseTimeline()->orderby('sequence','asc')->get();

        if (\Auth::check()) {

            $completed_lessons = \Auth::user()->chapters()->where('course_id', $course->id)->get()->pluck('model_id')->toArray();
            $continue_course  = $course->courseTimeline()->orderby('sequence','asc')->whereNotIn('model_id',$completed_lessons)->first();
            if($continue_course == null){
                $continue_course = $course->courseTimeline()->orderby('sequence','asc')->first();
            }

        }

        $rating = DB::table('reviews')
               ->select('reviewable_id', DB::raw('AVG(rating) as rating'))
                ->groupBy('reviewable_id')->get();
                $coursescount = Course::count();
		$usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->first();
		$visitor = DB::table('visitor_count')->count();
        return view( $this->path.'.courses.course', compact('course', 'purchased_course', 'recent_news', 'course_rating', 'completed_lessons','total_ratings','is_reviewed','lessons','continue_course','ministry','departments','allministry','alldepartments','logo','subcourse','rating','coursescount','diffname','lastupdateddate','visitor'));
    }


    public function rating($course_id, Request $request)
    {
        $course = Course::
     join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)->findOrFail($course_id);
        $course->students()->updateExistingPivot(\Auth::id(), ['rating' => $request->get('rating')]);

        return redirect()->back()->with('success', 'Thank you for rating.');
    }

    public function getByCategory(Request $request)
    {
        $department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();  
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            $request->session()->put('department_id', $department_id);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
        }

        $category = Category::where('slug', '=', $request->category)
            ->where('status','=',1)
            ->first();
        $categories = Category::where('status','=',1)->get();

        if ($category != "") {
            $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
            $featured_courses = Course::where('published', '=', 1)
                ->where('featured', '=', 1)->take(8)->get();

            if (request('type') == 'popular') {
                $courses = $category->courses()->withoutGlobalScope('filter')
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)->where('published', 1)->where('popular', '=', 1)->orderBy('courses.id', 'desc')->paginate(9);
				
				$coursescountt = $category->courses()->withoutGlobalScope('filter')
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)->where('published', 1)->where('popular', '=', 1)->orderBy('courses.id', 'desc')->count(9);
				

            } else if (request('type') == 'trending') {
                $courses = $category->courses()->withoutGlobalScope('filter')
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)->where('published', 1)->where('trending', '=', 1)->orderBy('courses.id', 'desc')->paginate(9);
				
				$coursescountt = $category->courses()->withoutGlobalScope('filter')
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)->where('published', 1)->where('trending', '=', 1)->orderBy('courses.id', 'desc')->count();

            } else if (request('type') == 'featured') {
                $courses = $category->courses()->withoutGlobalScope('filter')
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)->where('published', 1)->where('featured', '=', 1)->orderBy('courses.id', 'desc')->paginate(9);
	
				$coursescountt = $category->courses()->withoutGlobalScope('filter')
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)->where('published', 1)->where('featured', '=', 1)->orderBy('courses.id', 'desc')->count();
	
            } 

            
            else {
                $courses = $category->courses()->withoutGlobalScope('filter')
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)->where('published', 1)->orderBy('courses.id', 'desc')->paginate(9);
				
				$coursescountt = $category->courses()->withoutGlobalScope('filter')
                ->join('course_department', 'courses.id', '=', 'course_department.course_id')
           ->where('course_department.department_id',$department_id)->where('published', 1)->orderBy('courses.id', 'desc')->count();
            }
			$coursescount = Course::count();
			
        $usercount =  User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();
        $crttrainingcount = Crttraining::count();
        $crtcurrentcount = Crttraining::whereYear('created_at','=', now()->year)->count();
        $executivebrifing = Crttraining::where('training_type','=', 2)->count();
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
		$tracks = DB::table('tracks')->where('department_id','=',$department_id)->where('status','=',1)->get();
		
		  $rating = DB::table('reviews')
               ->select('reviewable_id', DB::raw('AVG(rating) as rating'))
                ->groupBy('reviewable_id')->get();
			$designation = Designations::where('status',1)->where('department_id','=',$department_id)->get();
		$usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->get();
			
		$visitor = DB::table('visitor_count')->count();


            return view( $this->path.'.courses.index', compact('courses', 'category', 'recent_news','featured_courses','categories','ministry','departments','allministry','alldepartments','logo','coursescount','usercount','crttrainingcount','crtcurrentcount','executivebrifing','recent_news','tracks','rating','designation','coursescount','coursescountt','lastupdateddate','visitor'));
        }
        return abort(404);
    }

    public function addReview(Request $request)
    {
        $department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();  
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            $request->session()->put('department_id', $department_id);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
        }
        $this->validate($request, [
            'review' => 'required'
        ]);
        $course = Course::findORFail($request->id);
        $review = new Review();
        $review->user_id = auth()->user()->id;
        $review->reviewable_id = $course->id;
        $review->reviewable_type = Course::class;
        $review->rating = $request->rating;
        $review->content = $request->review;
        $review->save();

        return back();
    }

    public function editReview(Request $request)
    {
        $department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();  
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            $request->session()->put('department_id', $department_id);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
        }
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $course = $review->reviewable;

            $subcourseid =  $course->sub_cat_id;

            $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
            $purchased_course = \Auth::check() && $course->students()->where('user_id', \Auth::id())->count() > 0;
            $course_rating = 0;
            $total_ratings = 0;
            $lessons = $course->courseTimeline()->orderby('sequence','asc')->get();

            if ($course->reviews->count() > 0) {
                $course_rating = $course->reviews->avg('rating');
                $total_ratings = $course->reviews()->where('rating', '!=', "")->get()->count();
            }
            if (\Auth::check()) {

                $completed_lessons = \Auth::user()->chapters()->where('course_id', $course->id)->get()->pluck('model_id')->toArray();
                $continue_course  = $course->courseTimeline()->orderby('sequence','asc')->whereNotIn('model_id',$completed_lessons)->first();
                if($continue_course == ""){
                    $continue_course = $course->courseTimeline()->orderby('sequence','asc')->first();
                    
                }
               
                       $subcourse = DB::table('courses')
                      ->join('categories','courses.category_id','=','categories.id')
                     ->join('sub_categories','courses.sub_cat_id','=','sub_categories.id')
                      ->select('courses.id','courses.title','courses.description','courses.course_image','categories.name','sub_categories.name as subname')
                      ->where('courses.sub_cat_id', $subcourseid)
                      ->get();

                    $rating = DB::table('reviews')
                           ->select('reviewable_id', DB::raw('AVG(rating) as rating'))
                            ->groupBy('reviewable_id')->get();

            }
			
			
            return view( $this->path.'.courses.course', compact('course', 'purchased_course', 'recent_news','completed_lessons','continue_course', 'course_rating', 'total_ratings','lessons', 'review' ,'ministry','departments','allministry','alldepartments','logo','subcourse','rating'));
        }
        return abort(404);

    }


    public function updateReview(Request $request)
    {
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $review->rating = $request->rating;
            $review->content = $request->review;
            $review->save();

            return redirect()->route('courses.show', ['slug' => $review->reviewable->slug]);
        }
        return abort(404);

    }

    public function deleteReview(Request $request)
    {
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $slug = $review->reviewable->slug;
            $review->delete();
            return redirect()->route('courses.show', ['slug' => $slug]);
        }
        return abort(404);
    }

        public function searchCoursebycat($id)
    {
      $department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            session('department_id');
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();  
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            $request->session()->put('department_id', $department_id);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
        }
            $courses = Course::
              join('course_department', 'courses.id', '=', 'course_department.course_id')
             ->where('courses.category_id',$id)
             ->where('course_department.department_id',$department_id)
             ->where('published', '=', 1)
                ->paginate(12);
        $categories = Category::where('status', '=', 1)->get();
        $coursescount = Course::count();
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $usercount = User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();
        $crttrainingcount = Crttraining::count();
        $crtcurrentcount = Crttraining::whereYear('created_at','=', now()->year)->count();
		$executivebrifing = Crttraining::where('training_type','=', 2)->count();
            return view($this->path . '.courses.searchCoursebycat', compact('categories','ministry','departments','allministry','alldepartments','category','course','logo','usercount','crttrainingcount','crtcurrentcount','courses','coursescount','executivebrifing'));
    }

    public function searchCoursebylevel($id)
    {
         $department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            session('department_id');
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();  
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            $request->session()->put('department_id', $department_id);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
        }
            $courses = Course::
              join('course_department', 'courses.id', '=', 'course_department.course_id')
              ->join('course_difficulty', 'courses.difficulty_id', '=', 'course_difficulty.id')
             ->where('courses.difficulty_id',$id)
             ->where('course_department.department_id',$department_id)
             ->where('published', '=', 1)
                ->paginate(12);
        $categories = Category::where('status', '=', 1)->get();
        $coursescount = Course::count();
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $usercount = User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();;
        $crttrainingcount = Crttraining::count();
        $crtcurrentcount = Crttraining::whereYear('created_at','=', now()->year)->count();
		$executivebrifing = Crttraining::where('training_type','=', 2)->count();
            return view($this->path . '.courses.searchcoursebylevel', compact('categories','ministry','departments','allministry','alldepartments','category','course','logo','usercount','crttrainingcount','crtcurrentcount','courses','coursescount','executivebrifing'));
    }

    public function searchCoursebyrate($id)
    {
        $department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            session('department_id');
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();  
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            $request->session()->put('department_id', $department_id);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
        }
            $courses = Course::
              join('course_department', 'courses.id', '=', 'course_department.course_id')
              ->join('reviews', 'courses.id', '=', 'reviews.reviewable_id')
             ->where('reviews.rating',$id)
             ->where('course_department.department_id',$department_id)
             ->where('published', '=', 1)
                ->paginate(12);
        $categories = Category::where('status', '=', 1)->get();
        $coursescount = Course::count();
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $usercount = User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();
        $crttrainingcount = Crttraining::count();
        $crtcurrentcount = Crttraining::whereYear('created_at','=', now()->year)->count();
		$executivebrifing = Crttraining::where('training_type','=', 2)->count();
        return view($this->path . '.courses.searchcoursebyrate', compact('categories','ministry','departments','allministry','alldepartments','category','course','logo','usercount','crttrainingcount','crtcurrentcount','courses','coursescount','executivebrifing'));
    }
	
	
	 public function searchcategory($id)
    {
        $categories = DB::table("categories")
                    ->where("track_id",$id)
					->where("status",1)
                    ->select("name","id")
                    ->pluck('name','id');
                return json_encode($categories);
    }
	public function searchsubcategory($id)
	{
	$subcategories = DB::table("sub_categories")
                    ->where("cat_id",$id)
					->where("status",1)
                    ->select("name","id")
                    ->pluck('name','id');
                return json_encode($subcategories);
	}
	public function aboutus()
	{
		$department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
		
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            //$request->session()->put('department_id', $department_id);
            session(['department_id' => $department_id]);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
			
        }
		$categories = Category::where('status', '=', 1)->get();
        $coursescount = Course::count();
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $usercount = User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();
        $crttrainingcount = Crttraining::count();
        $crtcurrentcount = Crttraining::whereYear('created_at','=', now()->year)->count();
		$executivebrifing = Crttraining::where('training_type','=', 2)->count();
		$usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->first();
		$visitor = DB::table('visitor_count')->count();
		
	return view($this->path . '.quicklinks.aboutus', compact('categories','ministry','departments','allministry','alldepartments','category','course','logo','usercount','crttrainingcount','crtcurrentcount','courses','coursescount','executivebrifing','lastupdateddate','visitor'));
	}
	
	public function contactus()
	{
$department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
		
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            //$request->session()->put('department_id', $department_id);
            session(['department_id' => $department_id]);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
			
        }
		$categories = Category::where('status', '=', 1)->get();
        $coursescount = Course::count();
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $usercount = User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();
        $crttrainingcount = Crttraining::count();
        $crtcurrentcount = Crttraining::whereYear('created_at','=', now()->year)->count();
		$executivebrifing = Crttraining::where('training_type','=', 2)->count();
		$usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->first();
		$visitor = DB::table('visitor_count')->count();
		
	return view($this->path . '.quicklinks.contactus', compact('categories','ministry','departments','allministry','alldepartments','category','course','logo','usercount','crttrainingcount','crtcurrentcount','courses','coursescount','executivebrifing','lastupdateddate','visitor'));
	}
	
	public function support()
	{
		$department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
            $departments = Departments::where('id',$department_id)->where('status',1)->first();
            $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
		
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            //$request->session()->put('department_id', $department_id);
            session(['department_id' => $department_id]);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
			
        }
		$categories = Category::where('status', '=', 1)->get();
        $coursescount = Course::count();
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $usercount = User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();
        $crttrainingcount = Crttraining::count();
        $crtcurrentcount = Crttraining::whereYear('created_at','=', now()->year)->count();
		$executivebrifing = Crttraining::where('training_type','=', 2)->count();
		$usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->first();
		$visitor = DB::table('visitor_count')->count();
		
	return view($this->path . '.quicklinks.support', compact('categories','ministry','departments','allministry','alldepartments','category','course','logo','usercount','crttrainingcount','crtcurrentcount','courses','coursescount','executivebrifing','lastupdateddate','visitor'));
	}
	
	public function privacypolicy()
	{
			$department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
		
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            //$request->session()->put('department_id', $department_id);
            session(['department_id' => $department_id]);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
			
        }
		$categories = Category::where('status', '=', 1)->get();
        $coursescount = Course::count();
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $usercount = User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();
        $crttrainingcount = Crttraining::count();
        $crtcurrentcount = Crttraining::whereYear('created_at','=', now()->year)->count();
		$executivebrifing = Crttraining::where('training_type','=', 2)->count();
		$usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->first();
		$visitor = DB::table('visitor_count')->count();
		
	return view($this->path . '.implinks.privacy', compact('categories','ministry','departments','allministry','alldepartments','category','course','logo','usercount','crttrainingcount','crtcurrentcount','courses','coursescount','executivebrifing','lastupdateddate','visitor'));
	}
		public function terms()
	{
			$department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
		
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            //$request->session()->put('department_id', $department_id);
            session(['department_id' => $department_id]);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
			
        }
		$categories = Category::where('status', '=', 1)->get();
        $coursescount = Course::count();
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $usercount = User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();
        $crttrainingcount = Crttraining::count();
        $crtcurrentcount = Crttraining::whereYear('created_at','=', now()->year)->count();
		$executivebrifing = Crttraining::where('training_type','=', 2)->count();
		$usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->first();
		$visitor = DB::table('visitor_count')->count();
		
	return view($this->path . '.implinks.terms', compact('categories','ministry','departments','allministry','alldepartments','category','course','logo','usercount','crttrainingcount','crtcurrentcount','courses','coursescount','executivebrifing','lastupdateddate','visitor'));
	}
		public function feedback()
	{
			$department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
		
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            //$request->session()->put('department_id', $department_id);
            session(['department_id' => $department_id]);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
			
        }
		$categories = Category::where('status', '=', 1)->get();
        $coursescount = Course::count();
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $usercount = User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();
        $crttrainingcount = Crttraining::count();
        $crtcurrentcount = Crttraining::whereYear('created_at','=', now()->year)->count();
		$executivebrifing = Crttraining::where('training_type','=', 2)->count();
		$usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->first();
		$visitor = DB::table('visitor_count')->count();
		
	return view($this->path . '.implinks.feedback', compact('categories','ministry','departments','allministry','alldepartments','category','course','logo','usercount','crttrainingcount','crtcurrentcount','courses','coursescount','executivebrifing','lastupdateddate','visitor'));
	}
	public function sitemap()
	{
			$department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
		
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            //$request->session()->put('department_id', $department_id);
            session(['department_id' => $department_id]);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
			
        }
		$categories = Category::where('status', '=', 1)->get();
        $coursescount = Course::count();
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $usercount = User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();
        $crttrainingcount = Crttraining::count();
        $crtcurrentcount = Crttraining::whereYear('created_at','=', now()->year)->count();
		$executivebrifing = Crttraining::where('training_type','=', 2)->count();
		$coursescount = Course::count();
		$usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->first();
		$visitor = DB::table('visitor_count')->count();
		
		
	return view($this->path . '.implinks.sitemap', compact('categories','ministry','departments','allministry','alldepartments','category','course','logo','usercount','crttrainingcount','crtcurrentcount','courses','coursescount','executivebrifing','coursescount','lastupdateddate','visitor'));
	}
	
	
	public function disclaimer()
	{
			$department_id = '0';
        if(Auth::check())
        {
            $id = Auth::user()->id;
              $user_details = DB::table('user_details')
                ->select('user_details.department_id')
                ->where('user_details.user_id', $id)
                ->latest('created_at')
                ->first();

            if($user_details){
                $department_id = $user_details->department_id;          
            }
        }

        if($department_id == 0){
            $department_id = session('department_id');
        }
        if(isset($department_id))
        {
            $departmentdata  = Departments::where('id',$department_id)->where('status',1)->first();
            $ministry_id = $departmentdata->ministry_id;
            $department_id = $departmentdata->id;
            $logo = $departmentdata->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get(); 
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
		
        }
        else
        {
            $setting = SettingManage::latest()->first();
            $ministry_id = $setting->ministry_id;
            $department_id = $setting->department_id;
            $logo = $setting->logo;
            $ministry = Ministry::where('id',$ministry_id)->where('status',1)->first();
            $allministry = Ministry::where('status',1)->get();
            //$request->session()->put('department_id', $department_id);
            session(['department_id' => $department_id]);
             $departments = Departments::where('id',$department_id)->where('status',1)->first();
             $alldepartments = Departments::where('ministry_id',$ministry_id)->where('status',1)->get();
			
        }
		$categories = Category::where('status', '=', 1)->where('department_id',$department_id)->get();
        $coursescount = Course::count();
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $usercount = User::join('user_details','users.id','=','user_details.user_id')->where('user_details.department_id',$department_id)->count();
        $crttrainingcount = Crttraining::count();
        $crtcurrentcount = Crttraining::whereYear('created_at','=', now()->year)->count();
		$executivebrifing = Crttraining::where('training_type','=', 2)->count();
		$usercreated = DB::table('user_details')->select('created_at')->latest('created_at');
		$lastupdateddate = DB::table('courses')->select('created_at')->latest('created_at')->union($usercreated)->first();
		$visitor = DB::table('visitor_count')->count();
		
	return view($this->path . '.implinks.disclaimer', compact('categories','ministry','departments','allministry','alldepartments','category','course','logo','usercount','crttrainingcount','crtcurrentcount','courses','coursescount','executivebrifing','lastupdateddate','visitor'));
	}
	
	
//------------------------------------------------userfeedback save-------------------------------------//	
  public function UserFeedbacksave(Request $request)
  {
	  $validatedData = $request->validate([
        'name' => 'required|unique:UserFeedbacks|max:25',
        'email' => 'required',
		'subject' => 'required',
        'feedback' => 'required',
		'agree' => 'required',
    ]);
	  $UserFeedback = new UserFeedback;
	  $UserFeedback->name = $request->name;
	  $UserFeedback->email = $request->email;
	  $UserFeedback->subject = $request->subject;
	  $UserFeedback->feedback = $request->feedback;
	   $UserFeedback->agree = $request->agree;
	  $UserFeedback->save();
	  $subject = "Nic Feedback";
	  $to = "vidya.kosh@nic.in";
	  $message =  $request->feedback; 
	  $headers = 'From: <$UserFeedback->email>' . "\r\n";
	  mail($to,$subject,$message,$headers);
	
	  return redirect('/')->with('message', 'Feedback Saved Successfully');
	 
  }

	

}
