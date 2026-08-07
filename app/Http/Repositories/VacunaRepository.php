<?php

namespace App\Http\Repositories;

use App\Models\Vacuna;
use App\Models\ConsultaMedica;

class VacunaRepository
{
    public function crearVacuna(array $data)
    {
        try {

            $consulta = ConsultaMedica::with('cita')
                ->findOrFail($data['consulta_medica_id']);

            if ($consulta->cita->mascota_id != $data['mascota_id']) {
                throw new \Exception(
                    'La consulta médica no pertenece a la mascota indicada.'
                );
            }

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
                'consultaMedica',
                'consultaMedica.cita'
            ]),
        ];
    }
}