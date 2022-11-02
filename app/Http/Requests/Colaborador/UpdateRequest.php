<?php

namespace App\Http\Requests\Colaborador;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'nombre' => 'required|regex:/^[\pL\s\-]+$/u',
            'apellido' => 'required|regex:/^[\pL\s\-]+$/u',
            'dni' => 'required|min:9999999|max:99999999999999999999|numeric',
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
            'dni.max' => 'El dni debe tener como maximo 20 caracteres',
            'dni.numeric' => 'El dni debe contener solo numeros',
        ];
    }
}
