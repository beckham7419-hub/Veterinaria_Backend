<?php

namespace App\Http\Repositories;

use App\Models\Cita;
use App\Models\Mascota;
use App\Models\Consulta;
use App\Models\Vacuna;

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

    public function obtenerPerfilCompleto(Mascota $mascota) {
        try {
            $consultaReciente = Consulta::join("citas", "consultas.cita_id", "=", "citas.id")
                ->where("citas.mascota_id", $mascota->id)
                ->whereNotNull("consultas.peso")
                ->orderBy("citas.fecha", "desc")
                ->select("consultas.*")
                ->first();

            $proximaVacuna = Vacuna::where("mascota_id", $mascota->id)
                ->whereNotNull("fecha_proxima_dosis")
                ->where("fecha_proxima_dosis", ">=", now()->toDateString())
                ->orderBy("fecha_proxima_dosis", "asc")
                ->first();

            return [
                "mascota" => $mascota,
                "peso_reciente" => $consultaReciente->peso ?? null,
                "proxima_vacuna" => $proximaVacuna
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo obtener el perfil de la mascota: " . $e -> getMessage(), 0, $e);
        }
    }

    public function obtenerHistorialCompleto(Mascota $mascota) {
        try {
            $consultas = Consulta::join("citas", "consultas.cita_id", "=", "citas.id")
                ->join("usuarios", "citas.veterinario_id", "=", "usuarios.id")
                ->where("citas.mascota_id", $mascota->id)
                ->where("citas.estado", "completada")
                ->whereNotNull("consultas.diagnostico")
                ->orderBy("citas.fecha", "desc")
                ->select(
                    "consultas.*",
                    "citas.fecha as fecha_cita",
                    "citas.motivo",
                    "usuarios.nombre_completo as veterinario_nombre"
                )
                ->with("archivos")
                ->get();

            $hoy = now()->startOfDay();

            $vacunas = Vacuna::where("mascota_id", $mascota->id)
                ->orderBy("fecha_aplicacion", "desc")
                ->get()
                ->map(function ($vacuna) use ($hoy) {
                    $vacuna->proxima_a_vencer = false;
                    if ($vacuna->fecha_proxima_dosis) {
                        $dias = ($vacuna->fecha_proxima_dosis->startOfDay()->timestamp - $hoy->timestamp) / 86400;
                        $vacuna->proxima_a_vencer = $dias >= 0 && $dias <= 30;
                    }
                    return $vacuna;
                });

            return [
                "mensaje" => "Historial obtenido",
                "consultas" => $consultas,
                "vacunas" => $vacunas
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo obtener el historial: " . $e -> getMessage(), 0, $e);
        }
    }
}
