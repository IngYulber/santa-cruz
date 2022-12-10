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
            'description' => 'required|min:5',
            'fecha_programada' => 'required|date_format:Y-m-d H:i|after:2020/01/01',
            'asuntos' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Ingrese la descripción',
            'description.min' => 'La descripción debe tener al menos 5 caracteres',
            'fecha_programada.required' => 'ingrese la fecha',
            'fecha_programada.date_format' => 'ingrese la hora',
            'fecha_programada.after' => 'La fecha debe ser a partir del  2022',
            'asuntos.required' => 'Ingrese los asuntos'
        ];
    }
}
