<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
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
            'training_id' => 'required',
            'topic' => 'required',
            'faculties' => 'required',
            'prospective' => 'required',
            'faculties' => 'required',
            'structure' => 'required',
            'prospective' => 'required',
            'interaction' => 'required',
            'venue' => 'required',
            'arrangement' => 'required',
            'location_rate' => 'required',
            'coordination' => 'required',
            'activities' => 'required',
            'capability' => 'required',
            'utilizing' => 'required',
            'suggestions' => 'required',
     
        ];
    }
}
