<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreVacunaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'consulta_id' => 'nullable|integer|exists:consultas,id',
            'nombre_vacuna' => 'required|string|max:150',
            'fecha_aplicacion' => 'required|date',
            'fecha_proxima_dosis' => 'nullable|date|after:fecha_aplicacion'
        ];
    }

    public function messages(): array
    {
        return [
            'consulta_id.exists' => 'La consulta especificada no existe.',
            'nombre_vacuna.required' => 'El nombre de la vacuna es obligatorio.',
            'fecha_aplicacion.required' => 'La fecha de aplicacion es obligatoria.',
            'fecha_proxima_dosis.after' => 'La proxima dosis debe ser posterior a la fecha de aplicacion.'
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