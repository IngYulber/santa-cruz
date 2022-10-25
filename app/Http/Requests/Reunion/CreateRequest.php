<?php

namespace App\Http\Requests\Reunion;

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
            'description' => 'required',
            'fecha_programada' => 'required',
            'asuntos' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Ingrese la descripción',
            'fecha_programada.required' => 'ingrese la fecha',
            'asuntos.required' => 'Ingrese los asuntos'
        ];
    }
}
