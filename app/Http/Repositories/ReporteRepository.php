<?php

namespace App\Http\Repositories;

use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Medicamento;
use App\Models\Vacuna;
use Illuminate\Support\Facades\DB;

class ReporteRepository
{
    public function consultasPorPeriodo(?string $fechaInicio, ?string $fechaFin, ?int $veterinarioId, ?string $especie) {
        try {
            $query = Consulta::join("citas", "consultas.cita_id", "=", "citas.id")
                ->join("mascotas", "citas.mascota_id", "=", "mascotas.id")
                ->join("usuarios", "citas.veterinario_id", "=", "usuarios.id")
                ->where("citas.estado", "completada")
                ->whereNotNull("consultas.diagnostico");

            if ($fechaInicio) {
                $query->whereDate("citas.fecha", ">=", $fechaInicio);
            }
            if ($fechaFin) {
                $query->whereDate("citas.fecha", "<=", $fechaFin);
            }
            if ($veterinarioId) {
                $query->where("citas.veterinario_id", $veterinarioId);
            }
            if ($especie) {
                $query->where("mascotas.especie", $especie);
            }

            $porVeterinario = (clone $query)
                ->select("usuarios.id", "usuarios.nombre_completo as veterinario", DB::raw("count(*) as total"))
                ->groupBy("usuarios.id", "usuarios.nombre_completo")
                ->get();

            $porEspecie = (clone $query)
                ->select("mascotas.especie", DB::raw("count(*) as total"))
                ->groupBy("mascotas.especie")
                ->get();

            return [
                "mensaje" => "Reporte generado",
                "por_veterinario" => $porVeterinario,
                "por_especie" => $porEspecie
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo generar el reporte: " . $e -> getMessage(), 0, $e);
        }
    }

    public function motivosFrecuentes(?string $fechaInicio, ?string $fechaFin, ?int $veterinarioId) {
        try {
            $query = Cita::where("estado", "completada");

            if ($fechaInicio) {
                $query->whereDate("fecha", ">=", $fechaInicio);
            }
            if ($fechaFin) {
                $query->whereDate("fecha", "<=", $fechaFin);
            }
            if ($veterinarioId) {
                $query->where("veterinario_id", $veterinarioId);
            }

            $motivos = $query->select("motivo", DB::raw("count(*) as total"))
                ->groupBy("motivo")
                ->orderBy("total", "desc")
                ->get();

            return ["mensaje" => "Reporte generado", "data" => $motivos];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo generar el reporte: " . $e -> getMessage(), 0, $e);
        }
    }

    public function vacunasPorVencer(?string $especie) {
        try {
            $hoy = now()->startOfDay()->toDateString();
            $en30dias = now()->addDays(30)->startOfDay()->toDateString();

            $query = Vacuna::whereNotNull("fecha_proxima_dosis")
                ->whereDate("fecha_proxima_dosis", ">=", $hoy)
                ->whereDate("fecha_proxima_dosis", "<=", $en30dias)
                ->with("mascota:id,nombre,especie");

            if ($especie) {
                $query->whereHas("mascota", function ($q) use ($especie) {
                    $q->where("especie", $especie);
                });
            }

            $vacunas = $query->orderBy("fecha_proxima_dosis", "asc")->get();

            return ["mensaje" => "Reporte generado", "data" => $vacunas];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo generar el reporte: " . $e -> getMessage(), 0, $e);
        }
    }

    public function medicamentosStockBajo() {
        try {
            $medicamentos = Medicamento::where("activo", true)
                ->whereColumn("cantidad_actual", "<", "cantidad_minima_alerta")
                ->get();

            return ["mensaje" => "Reporte generado", "data" => $medicamentos];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo generar el reporte: " . $e -> getMessage(), 0, $e);
        }
    }

    public function resumenDelDia(?string $fecha) {
        try {
            $fecha = $fecha ?? now()->toDateString();

            $resumen = [
                "agendadas" => Cita::whereDate("fecha", $fecha)->where("estado", "agendada")->count(),
                "confirmadas" => Cita::whereDate("fecha", $fecha)->where("estado", "confirmada")->count(),
                "en_consulta" => Cita::whereDate("fecha", $fecha)->where("estado", "en_consulta")->count(),
                "completadas" => Cita::whereDate("fecha", $fecha)->where("estado", "completada")->count(),
                "canceladas" => Cita::whereDate("fecha", $fecha)->where("estado", "cancelada")->count()
            ];

            return ["mensaje" => "Resumen generado", "fecha" => $fecha, "data" => $resumen];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo generar el resumen: " . $e -> getMessage(), 0, $e);
        }
    }
}