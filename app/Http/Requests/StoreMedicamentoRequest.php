<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreMedicamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proveedor_id' => 'nullable|integer|exists:proveedores,id',
            'nombre' => 'required|string|max:150',
            'tipo' => 'required|string|max:100',
            'unidad_medida' => 'required|string|max:50',
            'cantidad_actual' => 'required|numeric|min:0',
            'cantidad_minima_alerta' => 'required|numeric|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'proveedor_id.exists' => 'El proveedor especificado no existe.',
            'nombre.required' => 'El nombre del medicamento es obligatorio.',
            'tipo.required' => 'El tipo es obligatorio.',
            'unidad_medida.required' => 'La unidad de medida es obligatoria.',
            'cantidad_actual.required' => 'La cantidad actual es obligatoria.',
            'cantidad_minima_alerta.required' => 'La cantidad minima de alerta es obligatoria.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'mensaje' => 'Validacion fallida',
            'errores' => $validator->errors()
        ], 422));
    }
}
