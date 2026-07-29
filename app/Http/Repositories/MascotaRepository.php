<?php

namespace App\Http\Repositories;

use App\Models\Cita;
use App\Models\Mascota;

class MascotaRepository
{
    public function obtenerMascotas(?string $buscar = null, $duenoId = null)
    {
        try {
            $query = Mascota::where('activo', true);

            if ($buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('especie', 'like', "%{$buscar}%")
                        ->orWhere('numero_expediente', 'like', "%{$buscar}%");
                });
            }

            if ($duenoId) {
                $query->where('dueno_id', $duenoId);
            }

            $mascotas = $query->get();

            return [
                'mensaje' => 'Mascotas obtenidas',
                'data' => $mascotas,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudieron obtener las mascotas: '.$e->getMessage(), 0, $e);
        }
    }

    public function registrarMascota(array $data)
    {
        try {
            $mascota = new Mascota($data);
            $mascota->numero_expediente = 'TEMP-'.uniqid();
            $mascota->save();

            $mascota->numero_expediente = 'EXP-'.str_pad($mascota->id, 5, '0', STR_PAD_LEFT);
            $mascota->save();

            return [
                'mensaje' => 'Mascota registrada',
                'mascota' => $mascota,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo registrar la mascota: '.$e->getMessage(), 0, $e);
        }
    }

    public function actualizarMascota(Mascota $mascota, array $data)
    {
        try {
            $mascota->update($data);

            return [
                'mensaje' => 'Mascota actualizada',
                'mascota' => $mascota,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo actualizar la mascota: '.$e->getMessage(), 0, $e);
        }
    }

    public function eliminarMascota(Mascota $mascota)
    {
        $tieneCitasPendientes = Cita::where('mascota_id', $mascota->id)
            ->whereIn('estado', ['agendada', 'confirmada', 'en_consulta'])
            ->exists();

        if ($tieneCitasPendientes) {
            throw new \Exception('No se puede dar de baja a la mascota porque tiene citas activas pendientes.');
        }

        try {
            $mascota->activo = false;
            $mascota->save();

            return [
                'mensaje' => 'Mascota eliminada',
                'mascota' => $mascota,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo dar de baja la mascota: '.$e->getMessage(), 0, $e);
        }
    }

    public function obtenerMascotasDeDueno(int $duenoId)
    {
        try {
            $mascotas = Mascota::where('dueno_id', $duenoId)->where('activo', true)->get();

            return [
                'mensaje' => 'Mascotas obtenidas',
                'data' => $mascotas,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudieron obtener las mascotas: '.$e->getMessage(), 0, $e);
        }
    }
}
