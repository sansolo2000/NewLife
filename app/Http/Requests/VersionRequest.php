<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Traits\ConvertBoolean;

class VersionRequest extends FormRequest
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
        'vers_nombre.required'              =>  'La :attribute es obligatorio.',
        'vers_nombre.min'                   =>  'La :attribute debe tener más 5 caracteres',
        'vers_nombre.max'                   =>  'La :attribute debe tener máximo 200 caracteres',

        'tiji.min'                          =>  'La :attribute es obligatorio.',
        'tiji.required'                          =>  'La :attribute es obligatorio.'
        ];
    }

    public function rules()
    {
        
        $previa = [
            'vers_nombre'               =>  'required|max:200|min:5',
            'tiji'                      =>  'required|min:1'
        ];

        //print_f($previa);
        return $previa;
    }

    
    public function attributes()
    {
        return [
            'vers_nombre'               =>  'nombre de la versión',
            'tiji'                      =>  'tipo de jira'
        ];
    }
}
