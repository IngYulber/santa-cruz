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
            'username' => 'required',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Ingrese el usuario',
            'password.required' => 'Ingrese la contraseña'
        ];
    }

    public function getCredentials(){
        $username = $this->get('username');
        $password = $this->get('password');

        return [
            'username' => $username,
            'password' => $password
        ];
    }
}
