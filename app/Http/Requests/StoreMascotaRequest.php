<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreMascotaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dueno_id' => 'required|integer|exists:duenos,id',
            'nombre' => 'required|string|min:2|max:100',
            'especie' => ['required', 'string', Rule::in(array_keys(config('mascotas.especies')))],
            'raza' => ['required', 'string', function ($attribute, $value, $fail) {
                $razasValidas = config('mascotas.razas.'.$this->input('especie'), []);

                if (! \in_array($value, $razasValidas, true)) {
                    $fail('La raza seleccionada no corresponde a la especie indicada.');
                }
            }],
            'sexo' => 'required|string|in:macho,hembra',
            'fecha_nacimiento' => [
                'nullable',
                'date',
                'before:today',
                'after_or_equal:'.now()->subYears(30)->toDateString(),
            ],
            'color' => 'required|string|max:50',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'dueno_id.required' => 'El dueno es obligatorio.',
            'dueno_id.exists' => 'El dueno especificado no existe.',
            'nombre.required' => 'El nombre de la mascota es obligatorio.',
            'nombre.min' => 'El nombre de la mascota debe tener al menos 2 caracteres.',
            'especie.required' => 'La especie es obligatoria.',
            'especie.in' => 'La especie seleccionada no es valida.',
            'raza.required' => 'La raza es obligatoria.',
            'sexo.required' => 'El sexo es obligatorio.',
            'sexo.in' => 'El sexo debe ser macho o hembra.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento no puede ser hoy ni una fecha futura.',
            'fecha_nacimiento.after_or_equal' => 'La fecha de nacimiento no puede ser de hace mas de 30 anios.',
            'color.required' => 'El color es obligatorio.',
            'foto.mimes' => 'La foto debe ser una imagen jpg, jpeg o png.',
            'foto.max' => 'La foto no debe pesar mas de 5MB.',
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
