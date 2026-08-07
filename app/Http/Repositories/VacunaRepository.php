<?php

namespace App\Http\Repositories;

use App\Models\Consulta;
use App\Models\Mascota;
use App\Models\Vacuna;

class VacunaRepository
{
    public function registrarVacuna(Mascota $mascota, array $data, int $veterinarioId) {
        if (!empty($data["consulta_id"])) {
            $consulta = Consulta::find($data["consulta_id"]);
            if ($consulta && (int) $consulta->cita->mascota_id !== (int) $mascota->id) {
                throw new \Exception("La consulta especificada no pertenece a esta mascota.");
            }
        }

        try {
            $data["mascota_id"] = $mascota->id;

            $vacuna = new Vacuna($data);
            $vacuna->aplicada_por_usuario_id = $veterinarioId;
            $vacuna->save();

            return ["mensaje" => "Vacuna registrada", "vacuna" => $vacuna];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo registrar la vacuna: " . $e -> getMessage(), 0, $e);
        }
    }

    public function obtenerVacunasDeMascota(Mascota $mascota) {
        try {
            $vacunas = Vacuna::where("mascota_id", $mascota->id)->orderBy("fecha_aplicacion", "desc")->get();

            return ["mensaje" => "Vacunas obtenidas", "data" => $vacunas];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudieron obtener las vacunas: " . $e -> getMessage(), 0, $e);
        }
    }
}