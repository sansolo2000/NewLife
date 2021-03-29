<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateJiraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

     
    public function authorize()
    {
        return Auth::check();

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function messages()
    {
    return [

        'jira_asunto.required'                  => 'El :attribute es obligatorio.',
        'jira_asunto.min'                       => 'El :attribute debe tener más 5 caracteres',
        'jira_asunto.max'                       => 'El :attribute debe tener máximo 200 caracteres',

        'tire_id.required'                      => 'El :attribute es obligatorio.',

        'tipr_id.required'                      => 'El :attribute es obligatorio.',

        'tiji_id.required'                      => 'El :attribute es obligatorio.',

        'jira_fecha.required'                   => 'El :attribute es obligatorio.',
        'jira_fecha.date'                       => 'El :attribute debe ser fecha.',

        ];
    }

    public function rules()
    {
        $previa = [
            'jira_asunto'                   => 'required|max:200|min:5',
            'tire_id'                       => 'required',

            'tipr_id'                       => 'required',
            'tiji_id'                       => 'required',
            'jira_fecha'                    => 'required|date'
        ];
        return $previa;
    }

    
    public function attributes()
    {
        return [
            'jira_asunto'                   => 'asunto del jira',
            'tire_id'                       => 'tipo de responsable',
            'tipr_id'                       => 'tipo de prioridad',
            'tiji_id'                       => 'tipo de jira',
            'jira_fecha'                    => 'fecha del jira',
        ];
    }

}
