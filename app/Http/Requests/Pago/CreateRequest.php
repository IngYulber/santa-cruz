<?php

namespace App\Http\Requests\Pago;

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
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'monto' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'fecha_inicio.required' => 'Ingrese la fecha de inicio del pago',
            'fecha_inicio.date' => 'La fecha debe ser un dia del año',
            'fecha_fin.required' => 'Ingrese la fecha de fin del pago',
            'fecha_fin.date' => 'La fecha debe ser un dia del año',
            'fecha_fin.after' => 'La fecha de fin debe ser despues de la fecha de inicio',
            'monto.required' => 'Ingrese un monto a cobrar',
            'monto.numeric' => 'El monto debe ser un numero'
        ];
    }
}
