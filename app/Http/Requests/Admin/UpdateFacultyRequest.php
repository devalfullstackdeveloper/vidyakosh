<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFacultyRequest extends FormRequest
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
        'institute_industry_id' => 'required',
        'name' => 'required',
        'designation' => 'required',
        'mobile' => 'required|min:10|numeric',
        'email' => 'required|email',
        'address' => 'required',
        ];
    }
}
