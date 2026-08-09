<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMedicamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'proveedor_id' => 'nullable|integer|exists:proveedores,id',
            'nombre' => 'sometimes|required|string|max:150',
            'tipo' => 'sometimes|required|string|max:100',
            'unidad_medida' => 'sometimes|required|string|max:50',
            'cantidad_minima_alerta' => 'sometimes|required|numeric|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'proveedor_id.exists' => 'El proveedor especificado no existe.'
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
