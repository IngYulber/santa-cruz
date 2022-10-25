<?php

namespace App\Http\Requests\Sancion;

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
            'motivo' => 'required|min:5',
            'id_usuario' => 'required|exists:users,id',
            'dias_sancion' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'motivo.required' => 'Ingrese el motivo de la sanción',
            'motivo.min' => 'La sanción debe ser más descriptiva',
            'id_usuario.required' => 'Seleccione un colaborador',
            'id_usuario.exists' => 'El colaborador seleccionado no existe',
            'dias_sancion.required' => 'Ingrese los días de suspención',
            'dias_sancion.numeric' => 'Los días de suspencion deben ser numericos',
        ];
    }
}
