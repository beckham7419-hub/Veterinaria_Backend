<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateDuenoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_completo' => ['sometimes', 'required', 'string', 'min:5', 'max:150', 'regex:/^[\p{L}\'-]{2,50}(\s[\p{L}\'-]{2,50}){1,}$/u'],
            'telefono' => 'sometimes|required|digits:10',
            'correo' => ['sometimes', 'required', 'string', 'email', 'max:150',
                Rule::unique('duenos', 'correo')->ignore($this->route('dueno')),
            ],
            'contrasena' => 'nullable|string|min:8',
            'direccion' => ['sometimes', 'required', 'string', 'min:10', 'max:255', function ($attribute, $value, $fail) {
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
            'nombre_completo.regex' => 'El nombre completo debe incluir al menos un nombre y un apellido, separados por un espacio.',
            'telefono.digits' => 'El telefono debe tener exactamente 10 digitos.',
            'correo.email' => 'El correo debe tener un formato valido.',
            'correo.unique' => 'Ya existe otro dueno registrado con ese correo.',
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
