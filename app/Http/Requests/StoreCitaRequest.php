<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Rules\ValidarHoraVeterinaria;

class StoreCitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mascota_id' => 'required|integer|exists:mascotas,id',
            'veterinario_id' => ['required', 'integer', 
            Rule::exists('usuarios', 'id')->where('rol', 'veterinario')],
            'motivo' => 'required|string|max:255',
            'fecha' => 'required|date|after_or_equal:today',
              'hora' => ['required', 'date_format:H:i', new ValidarHoraVeterinaria(7, 22)]
        ];
    }

    public function messages(): array
    {
        return [
            'mascota_id.required' => 'La mascota es obligatoria.',
            'mascota_id.exists' => 'La mascota especificada no existe.',
            'veterinario_id.required' => 'El veterinario es obligatorio.',
            'veterinario_id.exists' => 'Debes seleccionar un usuario con rol de veterinario.',
            'motivo.required' => 'El motivo de consulta es obligatorio.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.after_or_equal' => 'No se pueden agendar citas en una fecha pasada.',
            'hora.required' => 'La hora es obligatoria.',
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
