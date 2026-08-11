<?php

namespace App\Http\Repositories;

use App\Models\Proveedor;

class ProveedorRepository
{
    public function obtenerProveedores() {
        try {
            $proveedores = Proveedor::where("activo", true)->get();
            return ["mensaje" => "Proveedores obtenidos", "data" => $proveedores];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudieron obtener los proveedores: " . $e -> getMessage(), 0, $e);
        }
    }

    public function registrarProveedor(array $data) {
        try {
            $proveedor = Proveedor::create($data);
            return ["mensaje" => "Proveedor registrado", "proveedor" => $proveedor];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo registrar el proveedor: " . $e -> getMessage(), 0, $e);
        }
    }

    public function actualizarProveedor(Proveedor $proveedor, array $data) {
        try {
            $proveedor->update($data);
            return ["mensaje" => "Proveedor actualizado", "proveedor" => $proveedor];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo actualizar el proveedor: " . $e -> getMessage(), 0, $e);
        }
    }

    public function eliminarProveedor(Proveedor $proveedor) {
        try {
            $proveedor->activo = false;
            $proveedor->save();
            return ["mensaje" => "Proveedor eliminado", "proveedor" => $proveedor];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo dar de baja al proveedor: " . $e -> getMessage(), 0, $e);
        }
    }
}