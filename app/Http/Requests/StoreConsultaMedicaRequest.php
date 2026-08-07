<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsultaMedicaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cita_id' => 'required|exists:citas,id',

            'diagnostico' => 'required|string|max:1000',

            'tratamiento' => 'nullable|string|max:1000',

            'medicamentos' => 'nullable|string|max:1000',

            'observaciones' => 'nullable|string|max:2000',

            'peso' => 'nullable|numeric|min:0|max:200',

            'temperatura' => 'nullable|numeric|min:30|max:50',
        ];
    }
}