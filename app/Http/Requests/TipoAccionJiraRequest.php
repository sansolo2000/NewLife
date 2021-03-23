<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TipoAccionJiraRequest extends FormRequest
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
        'tiaj_nombre.required'                  => 'El :attribute es obligatorio.',
        'tiaj_nombre.min'                       => 'El :attribute debe tener más 5 caracteres',
        'tiaj_nombre.max'                       => 'El :attribute debe tener máximo 50 caracteres',

        'ties_nombre.required'                  => 'El :attribute es obligatorio.',

        'tiaj_indice.required'                  => 'El :attribute es obligatorio.',
        'tiaj_indice.integer'                   => 'El :attribute debe ser entero.',
        'tiaj_indice.unique'                    => 'El :attribute debe ser unico.',

        'tiaj_responsable_actual.required'      => 'El :attribute es obligatorio.',

        'tiaj_responsable_siguiente.required'   => 'El :attribute es obligatorio.',

        'tiaj_tipo.required'                    => 'El :attribute es obligatorio.',

        'tiaj_activo.required'                  => 'El :attribute es obligatorio.',

        'tiaj_estado.required'                  => 'El :attribute es obligatorio.',

        'tiaj_codigo.unique'                    => 'El :attribute debe ser unico.',
        ];
    }


    public function rules()
    {
        return [
            'tiaj_nombre'                   => 'required|max:50|min:5',
            'ties_nombre'                   => 'required',
            'tiaj_indice'                   => ["required", "integer", rule::unique('tipo_acciones_jiras')->ignore($this->id, 'tiaj_id')],
            'tiaj_responsable_actual'       => 'required',
            'tiaj_responsable_siguiente'    => 'required',
            'tiaj_tipo'                     => 'required',
            'tiaj_tipo'                     => 'required',
            'tiaj_codigo'                   => [rule::unique('tipo_acciones_jiras')->ignore($this->id, 'tiaj_id')],
            'tiaj_estado'                   => 'required'
        ];
    }

    
    public function attributes()
    {
        return [
            'tiaj_nombre'                   => 'nombre de acción',
            'ties_nombre'                   => 'estado del jira',
            'tiaj_indice'                   => 'orden',
            'tiaj_responsable_actual'       => 'responsable actual',
            'tiaj_responsable_siguiente'    => 'responsable siguiente',
            'tiaj_tipo'                     => 'tipo de jira',
            'tiaj_codigo'                   => 'Código de operación del jira',
            'tiaj_activo'                   => 'activo',
            'tiaj_estado'                   => 'estado del jira'
        ];
    }

}
