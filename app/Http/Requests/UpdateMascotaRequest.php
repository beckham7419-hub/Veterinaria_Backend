<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
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
            'dueno_id' => 'prohibited',
            'especie' => 'prohibited',
            'raza' => 'prohibited',
            'nombre' => 'sometimes|required|string|min:2|max:100',
            'sexo' => 'sometimes|required|string|in:macho,hembra',
            'fecha_nacimiento' => [
                'sometimes',
                'required',
                'date',
                'before:today',
                'after_or_equal:'.now()->subYears(30)->toDateString(),
            ],
            'color' => 'sometimes|required|string|max:50',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'dueno_id.prohibited' => 'No se puede cambiar el dueno de una mascota existente.',
            'especie.prohibited' => 'No se puede cambiar la especie de una mascota existente.',
            'raza.prohibited' => 'No se puede cambiar la raza de una mascota existente.',
            'nombre.min' => 'El nombre de la mascota debe tener al menos 2 caracteres.',
            'sexo.in' => 'El sexo debe ser macho o hembra.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento no puede ser hoy ni una fecha futura.',
            'fecha_nacimiento.after_or_equal' => 'La fecha de nacimiento no puede ser de hace mas de 30 anios.',
            'foto.mimes' => 'La foto debe ser una imagen jpg, jpeg o png.',
            'foto.max' => 'La foto no debe pesar mas de 5MB.',
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
