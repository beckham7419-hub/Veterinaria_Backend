<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreConsultaMedicaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'cita_id' => 'required|exists:citas,id',

        'diagnostico' => 'required|string',

        'tratamiento' => 'nullable|string',

        'medicamentos' => 'nullable|string',

        'observaciones' => 'nullable|string',

        'peso' => 'nullable|numeric|min:0',

        'temperatura' => 'nullable|numeric|min:0',
    ];
}
}
