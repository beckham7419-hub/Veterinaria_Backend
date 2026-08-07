<?php

namespace App\Http\Repositories;

use App\Models\ArchivoConsulta;
use App\Models\Consulta;
use Illuminate\Http\UploadedFile;

class ArchivoConsultaRepository
{
    public function subirArchivo(Consulta $consulta, UploadedFile $archivo, int $veterinarioId) {
        if ((int) $consulta->cita->veterinario_id !== (int) $veterinarioId) {
            throw new \Exception("No tienes permiso para adjuntar archivos a esta consulta.");
        }

        if ($consulta->cita->estado === "completada") {
            throw new \Exception("No se pueden adjuntar archivos a una consulta de una cita ya completada.");
        }

        try {
            $extension = strtolower($archivo->getClientOriginalExtension());
            $tipo = $extension === "jpeg" ? "jpg" : $extension;

            $ruta = $archivo->store("consultas", "public");

            $archivoConsulta = ArchivoConsulta::create([
                "consulta_id" => $consulta->id,
                "nombre_archivo" => $archivo->getClientOriginalName(),
                "ruta_archivo" => $ruta,
                "tipo" => $tipo,
            ]);

            return ["mensaje" => "Archivo adjuntado", "archivo" => $archivoConsulta];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo adjuntar el archivo: " . $e -> getMessage(), 0, $e);
        }
    }

    public function obtenerArchivos(Consulta $consulta) {
        try {
            $archivos = $consulta->archivos;
            return ["mensaje" => "Archivos obtenidos", "data" => $archivos];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudieron obtener los archivos: " . $e -> getMessage(), 0, $e);
        }
    }
}