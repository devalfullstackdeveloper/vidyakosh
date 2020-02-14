<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
		    'office_name' => 'required|unique:locations,office_name',
            //'ministry_id' => 'required',
			'department_id' => 'required',
			'parent_office_id' => 'required',
			'state_id' => 'required',
			'city_id' => 'required',
            'contact' => 'required|min:10|numeric',
            'email' => 'required|email|unique:locations',
			
        ];
    }
}
