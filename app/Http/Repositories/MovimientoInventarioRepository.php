<?php

namespace App\Http\Repositories;

use App\Models\Medicamento;
use App\Models\MovimientoInventario;

class MovimientoInventarioRepository
{
    public function registrarEntrada(Medicamento $medicamento, array $data, int $usuarioId) {
        try {
            $medicamento->cantidad_actual = $medicamento->cantidad_actual + $data["cantidad"];
            $medicamento->save();

            $movimiento = new MovimientoInventario($data);
            $movimiento->medicamento_id = $medicamento->id;
            $movimiento->usuario_id = $usuarioId;
            $movimiento->tipo = "entrada";
            $movimiento->save();

            return ["mensaje" => "Entrada registrada", "medicamento" => $medicamento, "movimiento" => $movimiento];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo registrar la entrada: " . $e -> getMessage(), 0, $e);
        }
    }

    public function registrarSalida(Medicamento $medicamento, array $data, int $usuarioId) {
        if ($data["cantidad"] > $medicamento->cantidad_actual) {
            throw new \Exception("No hay suficiente stock disponible. Cantidad actual: " . $medicamento->cantidad_actual);
        }

        try {
            $medicamento->cantidad_actual = $medicamento->cantidad_actual - $data["cantidad"];
            $medicamento->save();

            $movimiento = new MovimientoInventario($data);
            $movimiento->medicamento_id = $medicamento->id;
            $movimiento->usuario_id = $usuarioId;
            $movimiento->tipo = "salida";
            $movimiento->save();

            return ["mensaje" => "Salida registrada", "medicamento" => $medicamento, "movimiento" => $movimiento];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo registrar la salida: " . $e -> getMessage(), 0, $e);
        }
    }

    public function obtenerHistorial(Medicamento $medicamento) {
        try {
            $movimientos = MovimientoInventario::where("medicamento_id", $medicamento->id)
                ->with("usuario:id,nombre_completo")
                ->orderBy("fecha", "desc")
                ->get();

            return ["mensaje" => "Historial obtenido", "data" => $movimientos];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo obtener el historial: " . $e -> getMessage(), 0, $e);
        }
    }
}