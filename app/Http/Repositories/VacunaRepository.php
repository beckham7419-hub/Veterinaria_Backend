<?php

namespace App\Http\Repositories;

use App\Models\Vacuna;

class VacunaRepository
{
    public function crearVacuna(array $data)
    {
        try {

            $vacuna = Vacuna::create($data);

            return [
                'mensaje' => 'Vacuna registrada',
                'vacuna' => $vacuna,
            ];

        } catch (\Exception $e) {

            throw new \Exception(
                'No se pudo registrar la vacuna: ' . $e->getMessage(),
                0,
                $e
            );

        }
    }

    public function obtenerVacuna(Vacuna $vacuna)
    {
        return [
            'mensaje' => 'Vacuna obtenida',
            'vacuna' => $vacuna->load([
                'mascota',
                'consultaMedica'
            ]),
        ];
    }
}