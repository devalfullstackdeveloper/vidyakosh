<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgendaRequest extends FormRequest
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
            'agenda_date' => 'required',
            'session_duration_from' => 'required',
            'session_duration_to' => 'required',
            'type' => 'required',
            'title' => 'required',
            'speaker' => 'required',
            'resource_person' => 'required',
            
        ];
    }
}