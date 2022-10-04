<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'dni' => 'required',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'dni.required' => 'Ingrese el dni',
            'password.required' => 'Ingrese la contraseña'
        ];
    }

    public function getCredentials(){
        $username = $this->get('dni');
        $password = $this->get('password');

        return [
            'dni' => $username,
            'password' => $password
        ];
    }
}
