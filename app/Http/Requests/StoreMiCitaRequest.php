<?php

namespace App\Http\Requests;

use App\Models\Mascota;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreMiCitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mascota_id' => ['required', 'integer', 'exists:mascotas,id', function ($attribute, $value, $fail) {
                $mascota = Mascota::with('dueno')->find($value);

                if (! $mascota || ! $mascota->activo) {
                    $fail('No se puede agendar una cita para una mascota dada de baja.');

                    return;
                }

                if (! $mascota->dueno || ! $mascota->dueno->activo) {
                    $fail('No se puede agendar una cita: la mascota debe tener un dueño activo.');
                }
            }],
            'veterinario_id' => ['required', 'integer',
                Rule::exists('usuarios', 'id')->where('rol', 'veterinario')
                ->where('activo', true)],
            'motivo' => 'required|string|max:255',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
        ];
    }

    public function messages(): array
    {
        return [
            'mascota_id.required' => 'Debes seleccionar una mascota.',
            'mascota_id.exists' => 'La mascota especificada no existe.',
            'veterinario_id.required' => 'Debes seleccionar un veterinario.',
            'veterinario_id.exists' => 'Debes seleccionar un usuario con rol de veterinario.',
            'motivo.required' => 'El motivo de consulta es obligatorio.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.after_or_equal' => 'No se pueden agendar citas en una fecha pasada.',
            'hora.required' => 'La hora es obligatoria.',
            'hora.date_format' => 'La hora debe tener el formato HH:MM.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'mensaje' => 'Validacion fallida',
            'errores' => $validator->errors(),
        ], 422));
    }
}
