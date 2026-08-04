<?php

namespace App\Http\Repositories;

use App\Models\ConsultaMedica;
use App\Models\Cita;

class ConsultaMedicaRepository
{
    public function crearConsulta(array $data)
    {
        try {

            $cita = Cita::findOrFail($data['cita_id']);

            if ($cita->estado !== 'en_consulta') {
                throw new \Exception('La cita debe estar en consulta.');
            }

            $consulta = ConsultaMedica::create($data);

            return [
                'mensaje' => 'Consulta medica registrada',
                'consulta' => $consulta,
            ];

        } catch (\Exception $e) {
            throw new \Exception(
                'No se pudo registrar la consulta medica: ' . $e->getMessage(),
                0,
                $e
            );
        }
    }

    public function obtenerConsulta(ConsultaMedica $consulta)
    {
        return [
            'mensaje' => 'Consulta medica obtenida',
            'consulta' => $consulta->load('cita'),
        ];
    }
}