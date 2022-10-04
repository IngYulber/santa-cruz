<?php

namespace App\Http\Requests\User;

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
            'nombre' => 'required|regex:/^[\pL\s\-]+$/u',
            'apellido' => 'required|regex:/^[\pL\s\-]+$/u',
            'dni' => 'required|unique:users,dni|min:8|numeric',
            'estado' => 'regex:/^[\pL\s\-]+$/u',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
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
            'dni.unique' => 'El dni ingresado ya fue registrado',
            'dni.min' => 'El dni debe tener al menos 8 caracteres',
            'dni.numeric' => 'El dni debe contener solo numeros',
            'estado.regex' => 'El estado debe contener solo letras',
            'password.required' => 'Ingrese una contraseña',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password_confirmation.required' => 'Ingrese la confirmación de contraseña',
            'password_confirmation.same' => 'Las contraseñas no coinciden',
        ];
    }
}
