<?php

namespace App\Http\Repositories;

use App\Models\Dueno;
use App\Models\Mascota;
use App\Models\Consulta;
use Illuminate\Support\Facades\Hash;

class PerfilDuenoRepository
{
    public function verPerfil(Dueno $dueno) {
        $totalMascotas = Mascota::where("dueno_id", $dueno->id)->where("activo", true)->count();

        $totalConsultas = Consulta::join("citas", "consultas.cita_id", "=", "citas.id")
            ->join("mascotas", "citas.mascota_id", "=", "mascotas.id")
            ->where("mascotas.dueno_id", $dueno->id)
            ->where("citas.estado", "completada")
            ->whereNotNull("consultas.diagnostico")
            ->count();

        return [
            "dueno" => $dueno,
            "resumen_actividad" => [
                "total_mascotas" => $totalMascotas,
                "total_consultas" => $totalConsultas
            ]
        ];
    }

    public function actualizarPerfil(Dueno $dueno, array $data) {
        $dueno->update($data);
        return $dueno;
    }

    public function cambiarContrasena(Dueno $dueno, array $data) {
        if (!Hash::check($data["contrasena_actual"], $dueno->contrasena)) {
            throw new \Exception("La contrasena actual no es correcta");
        }

        $dueno->contrasena = $data["contrasena_nueva"];
        $dueno->tokens_validos_desde = now();
        $dueno->save();

        return ["mensaje" => "Contrasena actualizada. Inicia sesion de nuevo."];
    }
}