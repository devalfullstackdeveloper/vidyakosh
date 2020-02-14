<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCrtRequest extends FormRequest
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
            'department_id' => 'required',
            'track_id' => 'required',
            'category_id' => 'required',
            'year_id' => 'required',
            'track_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'venue_id' => 'required',
            'designation_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'cooInternal[]' => 'distinct',
//            'corempcode' => 'required',
//            'corinst_id' => 'required',
//            'resourceempcode' => 'required',
//            'resourceinst_id' => 'required',
            'timing' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'lastnominne' => 'required',
            'feedback' => 'required',
            'status' => 'required',
        ];
    }
}
