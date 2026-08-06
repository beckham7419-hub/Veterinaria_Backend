<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateConsultaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'diagnostico' => 'sometimes|nullable|string',
            'tratamiento' => 'sometimes|nullable|string',
            'observaciones' => 'sometimes|nullable|string',
            'peso' => 'sometimes|nullable|numeric|min:0|max:999.99',
            'temperatura' => 'sometimes|nullable|numeric|min:0|max:999.9'
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
