<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProveedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|required|string|max:150',
            'telefono' => 'sometimes|required|digits:10',
             'correo' => [
                'sometimes', 'required', 'string', 'email', 'max:150',
                Rule::unique('proveedores', 'correo')->ignore($this->route('proveedor')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'telefono.digits' => 'El telefono debe tener exactamente 10 digitos.',
            'correo.email' => 'El correo debe tener un formato valido.'
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
