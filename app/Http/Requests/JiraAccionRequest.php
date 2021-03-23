<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class JiraAccionRequest extends FormRequest
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
        'tiaj_id.required'                  => 'El :attribute es obligatorio.',

        'jiac_descripcion.required'             => 'La :attribute es obligatorio.',
        'jiac_descripcion.min'                  => 'La :attribute debe tener más 5 caracteres',
        'jiac_descripcion.max'                  => 'La :attribute debe tener máximo 200 caracteres',

        'jiac_fecha.required'                   => 'La :attribute es obligatorio.',
        'jiac_fecha.date'                       => 'La :attribute debe ser fecha.',

        ];
    }

    public function rules()
    {
        $previa = [
            'tiaj_id'                   => 'required',

            'jiac_descripcion'              => 'required|max:200|min:5',

            'jiac_fecha'                    => 'required|date'
        ];
        return $previa;
    }

    
    public function attributes()
    {
        return [
            'tiaj_id'                   => 'tipo de acción',
            'jiac_descripcion'              => 'descripción de la acción',
            'jiac_fecha'                    => 'fecha de la acción',
        ];
    }
}
