<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassword extends FormRequest
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
            'password' => 'required|min:8',
            'password2' => 'required|same:password',

        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Ingrese la contraseña',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password2.required' => 'Ingrese la confirmación de contraseña',
            'password2.same' => 'Las contraseñas deben ser iguales',
        ];
    }
}
