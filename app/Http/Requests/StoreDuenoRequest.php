<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreDuenoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_completo' => 'required|string|max:150',
            'telefono' => 'required|digits:10',
            'correo' => 'required|string|email|max:150|unique:duenos,correo',
            'contrasena' => 'required|string|min:8',
            'direccion' => 'nullable|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'telefono.required' => 'El telefono es obligatorio.',
            'telefono.digits' => 'El telefono debe tener exactamente 10 digitos.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe tener un formato valido.',
            'correo.unique' => 'Ya existe un dueno registrado con ese correo.',
            'contrasena.required' => 'La contrasena es obligatoria.',
            'contrasena.min' => 'La contrasena debe tener al menos 8 caracteres.'
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
