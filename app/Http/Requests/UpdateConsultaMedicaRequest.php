<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConsultaMedicaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'diagnostico' => 'sometimes|string|max:1000',

            'tratamiento' => 'sometimes|nullable|string|max:1000',

            'medicamentos' => 'sometimes|nullable|string|max:1000',

            'observaciones' => 'sometimes|nullable|string|max:2000',

            'peso' => 'sometimes|nullable|numeric|min:0|max:200',

            'temperatura' => 'sometimes|nullable|numeric|min:30|max:50',
        ];
    }
}