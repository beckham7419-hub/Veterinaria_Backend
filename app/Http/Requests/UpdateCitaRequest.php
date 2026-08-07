<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateCitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'veterinario_id' => ['sometimes', 'required', 'integer',
            Rule::exists('usuarios', 'id')->where('rol', 'veterinario')],
            'motivo' => 'sometimes|required|string|max:255',
            'fecha' => 'sometimes|required|date|after_or_equal:today',
            'hora' => 'sometimes|required|date_format:H:i'
        ];
    }

    public function messages(): array
    {
        return [
            'veterinario_id.exists' => 'Debes seleccionar un usuario con rol de veterinario.',
            'fecha.after_or_equal' => 'No se pueden reprogramar citas a una fecha pasada.',
            'hora.date_format' => 'La hora debe tener el formato HH:MM.'
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
