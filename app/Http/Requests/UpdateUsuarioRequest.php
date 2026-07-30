<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $usuarioParam = $this->route('usuario');
    $usuarioId = is_object($usuarioParam) ? $usuarioParam->id : $usuarioParam;
        return [
            'nombre_completo' => 'sometimes|required|string|max:150',
            'correo' => ['sometimes', 'required', 'string', 'email', 'max:150',
                Rule::unique('usuarios', 'correo')
                ->where(fn ($query) => $query->where('activo', true)) 
                ->ignore($usuarioId)
            ],
            'contrasena' => 'nullable|string|min:8',
            'rol' => 'sometimes|required|string|in:administrador,veterinario,recepcionista'
        ];
    }

    public function messages(): array
    {
        return [
            'correo.email' => 'El correo debe tener un formato valido.',
            'correo.unique' => 'Ya existe otro usuario registrado con ese correo.',
            'contrasena.min' => 'La contrasena debe tener al menos 8 caracteres.',
            'rol.in' => 'El rol debe ser administrador, veterinario o recepcionista.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
        throw new HttpResponseException(response()->json([
            'mensaje' => 'Validacion fallida',
            'errores' => $validator->errors()
        ], 422));
        }
        parent::failedValidation($validator);
    }
}
