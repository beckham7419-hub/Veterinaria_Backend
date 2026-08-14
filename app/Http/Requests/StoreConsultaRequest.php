<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreConsultaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'diagnostico' => 'nullable|string',
            'tratamiento' => 'nullable|string',
            'medicamentos_recetados' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'peso' => 'nullable|numeric|min:0|max:200',
            'temperatura' => 'nullable|numeric|min:30|max:50'
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
