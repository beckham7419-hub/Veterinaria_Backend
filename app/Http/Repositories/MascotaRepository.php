<?php

namespace App\Http\Repositories;

use App\Models\Mascota;

class MascotaRepository
{
    public function obtenerMascotas() {
        try {
            $mascotas = Mascota::where("activo", true)->get();
            return [
                "mensaje" => "Mascotas obtenidas",
                "data" => $mascotas
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudieron obtener las mascotas: " . $e -> getMessage(), 0, $e);
        }
    }

    public function registrarMascota(array $data) {
        try {
            $mascota = new Mascota($data);
            $mascota->numero_expediente = "TEMP-" . uniqid();
            $mascota->save();

            $mascota->numero_expediente = "EXP-" . str_pad($mascota->id, 5, "0", STR_PAD_LEFT);
            $mascota->save();
            return [
                "mensaje" => "Mascota registrada",
                "mascota" => $mascota
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo registrar la mascota: " . $e -> getMessage(), 0, $e);
        }
    }

    public function actualizarMascota(Mascota $mascota, array $data) {
        try {
            $mascota->update($data);
            return [
                "mensaje" => "Mascota actualizada",
                "mascota" => $mascota
            ];
        } 
        catch (\Exception $e) {
            throw new \Exception("No se pudo actualizar la mascota: " . $e -> getMessage(), 0, $e);
        }
    }

    public function eliminarMascota(Mascota $mascota) {
        try {
            $mascota->activo = false;
            $mascota->save();
            return [
                "mensaje" => "Mascota eliminada",
                "mascota" => $mascota
            ];
        } 
        catch (\Exception $e) {
            throw new \Exception("No se pudo dar de baja la mascota: " . $e -> getMessage(), 0, $e);
        }
    }

    public function obtenerMascotasDeDueno(int $duenoId) {
        try {
            $mascotas = Mascota::where("dueno_id", $duenoId)->where("activo", true)->get();
            return [
                "mensaje" => "Mascotas obtenidas",
                "data" => $mascotas
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudieron obtener las mascotas: " . $e -> getMessage(), 0, $e);
        }
    }
}