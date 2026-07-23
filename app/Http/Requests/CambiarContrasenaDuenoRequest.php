<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CambiarContrasenaDuenoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contrasena_actual' => 'required|string',
            'contrasena_nueva' => 'required|string|min:8'
        ];
    }

    public function messages(): array
    {
        return [
            'contrasena_actual.required' => 'Debes ingresar tu contrasena actual.',
            'contrasena_nueva.required' => 'La nueva contrasena es obligatoria.',
            'contrasena_nueva.min' => 'La nueva contrasena debe tener al menos 8 caracteres.'
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
