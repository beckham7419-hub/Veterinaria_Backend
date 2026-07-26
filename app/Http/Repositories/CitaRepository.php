<?php

namespace App\Http\Repositories;

use App\Models\Cita;
use App\Models\Mascota;

class CitaRepository
{
    public function obtenerCitas(?string $estado = null, $mascotaId = null) {
        try {
            $query = Cita::query();

            if ($estado) {
                $query->where("estado", $estado);
            }

            if ($mascotaId) {
                $query->where("mascota_id", $mascotaId);
            }

            $citas = $query->orderBy("fecha")->orderBy("hora")->get();

            return [
                "mensaje" => "Citas obtenidas",
                "data" => $citas
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudieron obtener las citas: " . $e -> getMessage(), 0, $e);
        }
    }

    public function agendarCita(array $data) {
        $existeVeterinario = Cita::where("veterinario_id", $data["veterinario_id"])
            ->where("fecha", $data["fecha"])
            ->where("hora", $data["hora"])
            ->where("estado", "!=", "cancelada")
            ->exists();

        if ($existeVeterinario) {
            throw new \Exception("El veterinario ya tiene una cita agendada en ese horario.");
        }

        $existeMascota = Cita::where("mascota_id", $data["mascota_id"])
            ->where("fecha", $data["fecha"])
            ->where("estado", "!=", "cancelada")
            ->exists();

        if ($existeMascota) {
            throw new \Exception("Esta mascota ya tiene una cita activa programada para este dia.");
        }

        try {
            $mascota = Mascota::findOrFail($data["mascota_id"]);

            $cita = new Cita($data);
            $cita->dueno_id = $mascota->dueno_id;
            $cita->numero_folio = "TEMP-" . uniqid();
            $cita->save();

            $cita->numero_folio = "FOLIO-" . str_pad($cita->id, 5, "0", STR_PAD_LEFT);
            $cita->save();

            return [
                "mensaje" => "Cita agendada",
                "cita" => $cita
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo agendar la cita: " . $e -> getMessage(), 0, $e);
        }
    }

    public function actualizarCita(Cita $cita, array $data) {
        if (isset($data["fecha"]) || isset($data["hora"]) || isset($data["veterinario_id"])) {
            $veterinarioId = $data["veterinario_id"] ?? $cita->veterinario_id;
            $fecha = $data["fecha"] ?? $cita->fecha->format("Y-m-d");
            $hora = $data["hora"] ?? $cita->hora;

            $existeVeterinario = Cita::where("veterinario_id", $veterinarioId)
                ->where("fecha", $fecha)
                ->where("hora", $hora)
                ->where("estado", "!=", "cancelada")
                ->where("id", "!=", $cita->id)
                ->exists();

            if ($existeVeterinario) {
                throw new \Exception("El veterinario ya tiene una cita agendada en ese horario.");
            }
        }

        try {
            $cita->update($data);
            return [
                "mensaje" => "Cita actualizada",
                "cita" => $cita
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo actualizar la cita: " . $e -> getMessage(), 0, $e);
        }
    }
}