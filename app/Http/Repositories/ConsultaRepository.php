<?php

namespace App\Http\Repositories;

use App\Models\Cita;
use App\Models\Consulta;

class ConsultaRepository
{
    public function registrarConsulta(Cita $cita, array $data, int $veterinarioId) {
        if ((int) $cita->veterinario_id !== (int) $veterinarioId) {
            throw new \Exception("No tienes permiso para registrar la consulta de esta cita.");
        }

        if ($cita->estado !== "en_consulta") {
            throw new \Exception("La cita debe estar en consulta para registrar el diagnostico.");
        }

        if ($cita->consulta) {
            throw new \Exception("Esta cita ya tiene una consulta registrada.");
        }

        try {
            $data["cita_id"] = $cita->id;
            $consulta = Consulta::create($data);

            return ["mensaje" => "Consulta registrada", "consulta" => $consulta];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo registrar la consulta: " . $e -> getMessage(), 0, $e);
        }
    }

    public function actualizarConsulta(Consulta $consulta, array $data, int $veterinarioId) {
        if ((int) $consulta->cita->veterinario_id !== (int) $veterinarioId) {
            throw new \Exception("No tienes permiso para editar esta consulta.");
        }

        if ($consulta->cita->estado === "completada") {
            throw new \Exception("No se puede editar una consulta de una cita ya completada.");
        }

        try {
            $consulta->update($data);
            return ["mensaje" => "Consulta actualizada", "consulta" => $consulta];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo actualizar la consulta: " . $e -> getMessage(), 0, $e);
        }
    }
}