<?php

namespace App\Http\Repositories;

use App\Models\Dueno;

class DuenoRepository
{
    public function obtenerDuenos(?string $buscar = null)
    {
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
        } catch (\Exception $e) {
            throw new \Exception('No se pudieron obtener los duenos: '.$e->getMessage(), 0, $e);
        }
    }

    public function registrarDueno(array $data)
    {
        try {
            $dueno = Dueno::create($data);

            return [
                'mensaje' => 'Dueno registrado',
                'dueno' => $dueno,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo registrar el dueno: '.$e->getMessage(), 0, $e);
        }
    }

    public function actualizarDueno(Dueno $dueno, array $data)
    {
        try {
            $dueno->update($data);

            return [
                'mensaje' => 'Dueno actualizado',
                'dueno' => $dueno,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo actualizar el dueno: '.$e->getMessage(), 0, $e);
        }
    }

    public function eliminarDueno(Dueno $dueno)
    {
        try {
            $dueno->activo = false;
            $dueno->save();

            // El historial clinico (citas, consultas, vacunas) de las mascotas se conserva intacto;
            // solo se marcan como inactivas para que dejen de operarse (agendar citas, etc).
            $dueno->mascotas()->update(['activo' => false]);

            return [
                'mensaje' => 'Dueno dado de baja junto con sus mascotas. El historial clinico se conserva.',
                'dueno' => $dueno,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo dar de baja al dueno: '.$e->getMessage(), 0, $e);
        }
    }

    public function reactivarDueno(int $id)
    {
        try {
            $dueno = Dueno::findOrFail($id);
            $dueno->activo = true;
            $dueno->save();

            $dueno->mascotas()->update(['activo' => true]);

            return ['mensaje' => 'Dueno reactivado junto con sus mascotas', 'dueno' => $dueno];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo reactivar al dueno: '.$e->getMessage(), 0, $e);
        }
    }

    public function buscarPorCorreo(string $correo)
    {
        try {
            $dueno = Dueno::where('correo', $correo)->first();

            return $dueno;
        } catch (\Exception $e) {
            throw new \Exception('No se pudo buscar el dueno: '.$e->getMessage(), 0, $e);
        }
    }
}
