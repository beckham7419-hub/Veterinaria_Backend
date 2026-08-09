<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
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
            'nombre_completo' => ['required', 'string', 'regex:/^\p{L}{3,50}(\s\p{L}{3,50}){2,}$/u'],
            'telefono' => 'required|digits:10',
            'correo' => 'required|string|email|max:150|unique:duenos,correo',
            'contrasena' => 'required|string|min:8',
            'direccion' => ['required', 'string', 'min:10', 'max:255', function ($attribute, $value, $fail) {
                $partes = array_filter(array_map('trim', explode(',', $value)), fn ($parte) => $parte !== '');

                if (\count($partes) < 4) {
                    $fail('La direccion debe incluir ciudad, colonia, calle y numero de casa, separados por comas (ej: Tijuana, Centro, Av. Insurgentes, 123).');
                }

                if (preg_match('/^[\d\s,.-]+$/', $value)) {
                    $fail('La direccion no puede contener unicamente numeros.');
                }
            }],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'nombre_completo.regex' => 'El nombre completo debe incluir nombre, apellido paterno y apellido materno, cada uno con entre 3 y 50 letras.',
            'telefono.required' => 'El telefono es obligatorio.',
            'telefono.digits' => 'El telefono debe tener exactamente 10 digitos.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe tener un formato valido.',
            'correo.unique' => 'Ya existe un dueno registrado con ese correo.',
            'contrasena.required' => 'La contrasena es obligatoria.',
            'contrasena.min' => 'La contrasena debe tener al menos 8 caracteres.',
            'direccion.required' => 'La direccion es obligatoria.',
            'direccion.min' => 'La direccion es demasiado corta.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'mensaje' => 'Validacion fallida',
            'errores' => $validator->errors(),
        ], 422));
    }
}
