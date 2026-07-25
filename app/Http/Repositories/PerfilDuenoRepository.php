<?php

namespace App\Http\Repositories;

use App\Models\Dueno;
use App\Models\Mascota;
use Illuminate\Support\Facades\Hash;

class PerfilDuenoRepository
{
    public function verPerfil(Dueno $dueno) {
        $totalMascotas = Mascota::where("dueno_id", $dueno->id)->where("activo", true)->count();

        return [
            "dueno" => $dueno,
            "resumen_actividad" => ["total_mascotas" => $totalMascotas]
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