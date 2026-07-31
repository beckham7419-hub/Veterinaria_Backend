<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_completo' => 'required|string|max:150',
            'correo' => 'required|string|email|max:150|unique:usuarios,correo',
            'contrasena' => 'required|string|min:8',
            'rol' => 'required|string|in:administrador,veterinario,recepcionista'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe tener un formato valido.',
            'correo.unique' => 'Ya existe un usuario registrado con ese correo.',
            'contrasena.required' => 'La contrasena es obligatoria.',
            'contrasena.min' => 'La contrasena debe tener al menos 8 caracteres.',
            'rol.required' => 'El rol es obligatorio.',
            'rol.in' => 'El rol debe ser administrador, veterinario o recepcionista.'
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
