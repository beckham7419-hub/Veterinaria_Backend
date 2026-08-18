<?php

namespace App\Http\Repositories;

use App\Models\Medicamento;

class MedicamentoRepository
{
    public function obtenerMedicamentos() {
        try {
            $medicamentos = Medicamento::with('proveedor')->where("activo", true)->get()->map(function ($medicamento) {
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
             unset($data['tipo']); 
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

    public function obtenerUnMedicamento(string $nombre) {
        try {
            $medicamento = Medicamento::with('proveedor')->where('nombre', 'like', "%{$nombre}%")->first();
            return [
                "mensaje" => $medicamento?"Medicamento encontrado":"Medicamento no encontrado",
                "data" => $medicamento
            ];
        } 
        catch (\Exception $e) {
            throw new \Exception("No se pudo encontrar el medicamento: " . $e -> getMessage(), 0, $e);
        }
    }

    public function reactivarMedicamento(Medicamento $medicamento) {
    try {
        $medicamento->activo = true;
        $medicamento->save();
        return ["mensaje" => "Medicamento reactivado", "medicamento" => $medicamento];
    }
    catch (\Exception $e) {
        throw new \Exception("No se pudo reactivar el medicamento: " . $e -> getMessage(), 0, $e);
    }
}

}