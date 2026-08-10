<?php

namespace App\Http\Repositories;

use App\Models\Medicamento;

class MedicamentoRepository
{
    public function obtenerMedicamentos() {
        try {
            $medicamentos = Medicamento::where("activo", true)->get()->map(function ($medicamento) {
                $medicamento->stock_bajo = $medicamento->cantidad_actual < $medicamento->cantidad_minima_alerta;
                return $medicamento;
            });

            return ["mensaje" => "Medicamentos obtenidos", "data" => $medicamentos];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudieron obtener los medicamentos: " . $e -> getMessage(), 0, $e);
        }
    }

    public function registrarMedicamento(array $data) {
        try {
            $medicamento = Medicamento::create($data);
            return ["mensaje" => "Medicamento registrado", "medicamento" => $medicamento];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo registrar el medicamento: " . $e -> getMessage(), 0, $e);
        }
    }

    public function actualizarMedicamento(Medicamento $medicamento, array $data) {
        try {
            $medicamento->update($data);
            return ["mensaje" => "Medicamento actualizado", "medicamento" => $medicamento];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo actualizar el medicamento: " . $e -> getMessage(), 0, $e);
        }
    }

    public function eliminarMedicamento(Medicamento $medicamento) {
        try {
            $medicamento->activo = false;
            $medicamento->save();
            return ["mensaje" => "Medicamento eliminado", "medicamento" => $medicamento];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo dar de baja al medicamento: " . $e -> getMessage(), 0, $e);
        }
    }
}