<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
            'diagnostico' => 'sometimes|string',

            'tratamiento' => 'sometimes|nullable|string',

            'medicamentos' => 'sometimes|nullable|string',

            'observaciones' => 'sometimes|nullable|string',

            'peso' => 'sometimes|nullable|numeric|min:0',

            'temperatura' => 'sometimes|nullable|numeric|min:0',
        ];
    }
}