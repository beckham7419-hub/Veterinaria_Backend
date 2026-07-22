<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
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
            'nombre_completo' => 'sometimes|required|string|max:150',
            'telefono' => 'sometimes|required|digits:10',
            'correo' => ['sometimes', 'required', 'string', 'email', 'max:150',
                Rule::unique('duenos', 'correo')->ignore($this->route('dueno')),
            ],
            'contrasena' => 'nullable|string|min:8',
            'direccion' => 'nullable|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'telefono.digits' => 'El telefono debe tener exactamente 10 digitos.',
            'correo.email' => 'El correo debe tener un formato valido.',
            'correo.unique' => 'Ya existe otro dueno registrado con ese correo.',
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
