<?php

namespace App\Http\Repositories;

use App\Models\Dueno;

class DuenoRepository
{
    public function obtenerDuenos(?string $buscar = null) {
        try {
            $query = Dueno::where('activo', true);

            if ($buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('nombre_completo', 'like', "%{$buscar}%")
                        ->orWhere('correo', 'like', "%{$buscar}%")
                        ->orWhere('telefono', 'like', "%{$buscar}%");
                });
            }

            $duenos = $query->get();

            return [
                'mensaje' => 'Duenos obtenidos',
                'data' => $duenos,
            ];
        }
        catch (\Exception $e) {
            throw new \Exception('No se pudieron obtener los duenos: '.$e->getMessage(), 0, $e);
        }
    }

    public function registrarDueno(array $data) {
        try {
            $dueno = Dueno::create($data);

            return [
                'mensaje' => 'Dueno registrado',
                'dueno' => $dueno,
            ];
        }
        catch (\Exception $e) {
            throw new \Exception('No se pudo registrar el dueno: '.$e->getMessage(), 0, $e);
        }
    }

    public function actualizarDueno(Dueno $dueno, array $data) {
        try {
            $dueno->update($data);

            return [
                'mensaje' => 'Dueno actualizado',
                'dueno' => $dueno,
            ];
        }
        catch (\Exception $e) {
            throw new \Exception('No se pudo actualizar el dueno: '.$e->getMessage(), 0, $e);
        }
    }

    public function eliminarDueno(Dueno $dueno) {
        $tieneCitasPendientes = \App\Models\Cita::whereHas('mascota', function ($q) use ($dueno) {
            $q->where('dueno_id', $dueno->id);
        })->whereIn('estado', ['agendada', 'confirmada', 'en_consulta'])->exists();

        if ($tieneCitasPendientes) {
            throw new \Exception('No se puede dar de baja al dueno: una o mas de sus mascotas tienen citas activas pendientes.');
        }

        try {
            $dueno->activo = false;
            $dueno->save();

            $dueno->mascotas()->where('activo', true)->update([
                'activo' => false,
                'baja_por_dueno' => true,
            ]);

            return [
                'mensaje' => 'Dueno dado de baja junto con sus mascotas activas. El historial clinico se conserva.',
                'dueno' => $dueno,
            ];
        }
        catch (\Exception $e) {
            throw new \Exception('No se pudo dar de baja al dueno: '.$e->getMessage(), 0, $e);
        }
    }

    public function reactivarDueno(int $id) {
        try {
            $dueno = Dueno::findOrFail($id);
            $dueno->activo = true;
            $dueno->save();

            $dueno->mascotas()->where('baja_por_dueno', true)->update([
                'activo' => true,
                'baja_por_dueno' => false,
            ]);

            return ['mensaje' => 'Dueno reactivado junto con las mascotas que se dieron de baja junto con el', 'dueno' => $dueno];
        }
        catch (\Exception $e) {
            throw new \Exception('No se pudo reactivar al dueno: '.$e->getMessage(), 0, $e);
        }
    }

    public function buscarPorCorreo(string $correo) {
        try {
            $dueno = Dueno::where('correo', $correo)->first();

            return $dueno;
        }
        catch (\Exception $e) {
            throw new \Exception('No se pudo buscar el dueno: '.$e->getMessage(), 0, $e);
        }
    }
}
