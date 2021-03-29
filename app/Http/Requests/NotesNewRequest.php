<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class NotesNewRequest extends FormRequest
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
        'noji_asunto.required'             => 'La :attribute es obligatorio.',
        'noji_asunto.min'                  => 'La :attribute debe tener más 5 caracteres',
        'noji_asunto.max'                  => 'La :attribute debe tener máximo 50 caracteres',

        'noji_descripcion.required'             => 'La :attribute es obligatorio.',
        'noji_descripcion.min'                  => 'La :attribute debe tener más 5 caracteres',
        'noji_descripcion.max'                  => 'La :attribute debe tener máximo 5000 caracteres',

        ];
    }

    public function rules()
    {
        $previa = [
            'noji_asunto'              => 'required|max:50|min:5',
            'noji_descripcion'         => 'required|max:5000|min:5',
        ];
        return $previa;
    }

    
    public function attributes()
    {
        return [
            'noji_asunto'              => 'asunto del comentario',
            'noji_descripcion'              => 'descripción del comentario',
        ];
    }
}
