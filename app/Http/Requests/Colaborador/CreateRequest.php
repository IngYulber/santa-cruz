<?php

namespace App\Http\Requests\Colaborador;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'nombre' => 'required|regex:/^[\pL\s\-]+$/u|min:3',
            'apellido' => 'required|regex:/^[\pL\s\-]+$/u|min:5',
            'dni' => 'required|unique:colaborador,dni|numeric|min:9999999|max:99999999999999999999|numeric',
            'estado' => 'regex:/^[\pL\s\-]+$/u',
        ];
    }


    public function messages()
    {
        return [
            'nombre.required' => 'Ingrese el nombre',
            'nombre.regex' => 'El nombre solo debe tener letras',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'apellido.required' => 'Ingrese el apellido',
            'apellido.regex' => 'El apellido solo debe tener letras',
            'apellido.min' => 'El apellido debe tener al menos 5 caracteres',
            'dni.required' => 'Ingrese el documento de identidad',
            'dni.unique' => 'El documento ingresado ya fue registrado',
            'dni.min' => 'El documento debe tener al menos 8 caracteres',
            'dni.max' => 'El documento debe tener como máximo 20 caracteres',
            'dni.numeric' => 'El documento debe contener solo numeros',
            'estado.regex' => 'El estado debe contener solo letras',
        ];
    }
}
