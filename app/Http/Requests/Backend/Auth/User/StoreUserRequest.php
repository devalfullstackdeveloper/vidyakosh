<?php

namespace App\Http\Requests\Backend\Auth\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreUserRequest.
 */
class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->user()->is_admin == 1){
            return $this->user()->is_admin;
        }else{
            return $this->user()->isAdmin();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'     => ['required', 'max:191'],
            'last_name'  => ['required', 'max:191'],
            'email'    => ['required', 'email', 'max:191', Rule::unique('users')],
            'password' => ['required', 'min:6', 'confirmed'],
            'is_admin' => 'required',
			'ministry_id' => 'required',
			'department_id' => 'required',
			'office_id' => 'required',
			'designation_id' => 'required',
            'roles' => ['required', 'array'],
        ];
    }
}
