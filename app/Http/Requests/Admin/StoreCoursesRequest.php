<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoursesRequest extends FormRequest
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
            'teachers.*' => 'exists:users,id',
            'title' => 'required',
			'short_name' =>'required',
            'category_id' => 'required',
            'sub_cat_id' => 'required',
            'ministry_id' => 'required',
            'department_id' => 'required',
            'difficulty_id' => 'required',
            'course_type_id' => 'required',
            'moodle_course_ref_id' => 'required',
            'start_date' => 'date_format:'.config('app.date_format'),
        ];
    }
}
