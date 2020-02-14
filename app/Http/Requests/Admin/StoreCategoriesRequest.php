<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriesRequest extends FormRequest
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
            'name' => 'required',
			//'ministry_id' => 'required',
			'department_id' => 'required',
			//'office_id' => 'required',
			'tracks' => 'required',
//			'moodle_cat_ref_id'=>'required|numeric',
        ];
    }
}
