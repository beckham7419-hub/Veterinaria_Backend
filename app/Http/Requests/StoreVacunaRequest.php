<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVacunaRequest extends FormRequest
{
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

            'proxima_dosis' => 'nullable|date|after:fecha_aplicacion',
        ];
    }
}