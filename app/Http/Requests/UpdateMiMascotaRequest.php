<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMiMascotaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|required|string|max:100',
            'especie' => 'sometimes|required|string|max:50',
            'raza' => 'nullable|string|max:50',
            'sexo' => 'sometimes|required|string|in:macho,hembra',
            'fecha_nacimiento' => 'nullable|date|before_or_equal:today',
            'color' => 'nullable|string|max:50',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:5120'
        ];
    }

    public function messages(): array
    {
        return [
            'sexo.in' => 'El sexo debe ser macho o hembra.',
            'fecha_nacimiento.before_or_equal' => 'La fecha de nacimiento no puede ser una fecha futura.',
            'foto.mimes' => 'La foto debe ser una imagen jpg, jpeg o png.',
            'foto.max' => 'La foto no debe pesar mas de 5MB.'
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
