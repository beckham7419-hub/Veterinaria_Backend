<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVacunaRequest extends FormRequest
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
        'nombre' => 'sometimes|string|max:255',

        'fecha_aplicacion' => 'sometimes|date',

        'proxima_dosis' => 'sometimes|nullable|date',
    ];
}
}
