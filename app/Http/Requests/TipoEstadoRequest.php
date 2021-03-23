<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TipoEstadoRequest extends FormRequest
{
    //protected $redirectRoute = 'tipoestado.create';
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
        'ties_nombre.required' => 'El :attribute es obligatorio.',
        'ties_nombre.min' => 'El :attribute debe tener más 5 caracteres',
        'ties_nombre.max' => 'El :attribute debe tener máximo 50 caracteres',

        'ties_indice.required' => 'El :attribute es obligatorio.',
        'ties_indice.integer' => 'El :attribute debe ser entero.',

        'ties_activo.required' => 'El :attribute es obligatorio.'
        ];
    }


    public function rules()
    {
        return [
            'ties_nombre' => 'required|max:50|min:5',
            'ties_indice' => 'required|integer',
            'ties_activo' => 'required'
        ];
    }

    
    public function attributes()
    {
        return [
            'ties_nombre' => 'nombre',
            'ties_indice' => 'número de orden',
            'ties_activo' => 'activo'
        ];
    }
}
