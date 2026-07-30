<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMascotaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dueno_id' => 'sometimes|required|integer|exists:duenos,id',
            'nombre' => 'sometimes|required|string|max:100',
            'especie' => 'sometimes|required|string|max:50',
            'raza' => 'nullable|string|max:50',
            'sexo' => 'sometimes|required|string|in:macho,hembra',
            'fecha_nacimiento' => 'nullable|date',
            'color' => 'nullable|string|max:50',
            'foto_url' => 'nullable|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'dueno_id.exists' => 'El dueno especificado no existe.',
            'sexo.in' => 'El sexo debe ser macho o hembra.'
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
