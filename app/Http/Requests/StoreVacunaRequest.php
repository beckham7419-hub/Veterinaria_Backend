<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreVacunaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
{
    return true;
}

public function rules(): array
{
    return [
        'mascota_id' => 'required|exists:mascotas,id',

        'consulta_medica_id' => 'required|exists:consultas_medicas,id',

        'nombre' => 'required|string|max:255',

        'fecha_aplicacion' => 'required|date',

        'proxima_dosis' => 'nullable|date',
    ];
}
}
