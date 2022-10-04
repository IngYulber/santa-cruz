<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|regex:/^[\pL\s\-]+$/u',
            'apellido' => 'required|regex:/^[\pL\s\-]+$/u',
            'dni' => 'required|min:8|numeric',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Ingrese el nombre',
            'nombre.regex' => 'El nombre solo debe tener letras',
            'apellido.required' => 'Ingrese el apellido',
            'apellido.regex' => 'El apellido solo debe tener letras',
            'dni.required' => 'Ingrese el dni',
            'dni.min' => 'El dni debe tener al menos 8 caracteres',
            'dni.numeric' => 'El dni debe contener solo numeros',
        ];
    }
}
