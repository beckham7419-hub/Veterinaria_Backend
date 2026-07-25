<?php

namespace App\Http\Repositories;

use App\Models\Dueno;

class DuenoRepository
{
    public function obtenerDuenos() {
        try {
            $duenos = Dueno::where("activo", true)->get();
            return [
                "mensaje" => "Duenos obtenidos",
                "data" => $duenos
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudieron obtener los duenos: " . $e -> getMessage(), 0, $e);
        }
    }

    public function registrarDueno(array $data) {
        try {
            $dueno = Dueno::create($data);
            return [
                "mensaje" => "Dueno registrado",
                "dueno" => $dueno
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo registrar el dueno: " . $e -> getMessage(), 0, $e);
        }
    }

    public function actualizarDueno(Dueno $dueno, array $data) {
        try {
            $dueno->update($data);
            return [
                "mensaje" => "Dueno actualizado",
                "dueno" => $dueno
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo actualizar el dueno: " . $e -> getMessage(), 0, $e);
        }
    }

    public function eliminarDueno(Dueno $dueno) {
        try {
            $dueno->activo = false;
            $dueno->save();
            return [
                "mensaje" => "Dueno eliminado",
                "dueno" => $dueno
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo dar de baja al dueno: " . $e -> getMessage(), 0, $e);
        }
    }
}