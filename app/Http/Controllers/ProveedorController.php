<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Http\Requests\StoreProveedorRequest;
use App\Http\Requests\UpdateProveedorRequest;
use App\Http\Repositories\ProveedorRepository;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    protected $proveedorRepository;

    public function __construct(ProveedorRepository $proveedorRepository) {
        $this->proveedorRepository = $proveedorRepository;
    }

    public function index() {
        try {
            $proveedores = $this->proveedorRepository->obtenerProveedores();
            return response()->json($proveedores,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function store(StoreProveedorRequest $request) {
        try {
            $proveedor = $this->proveedorRepository->registrarProveedor($request->validated());
            return response()->json($proveedor,201);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function show(Proveedor $proveedor) {
        try {
            return response()->json($proveedor,200);
        } 
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e->getMessage()],404);
        }
    }

    public function update(UpdateProveedorRequest $request, Proveedor $proveedor) {
        try {
            $proveedor = $this->proveedorRepository->actualizarProveedor($proveedor, $request->validated());
            return response()->json($proveedor,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function destroy(Proveedor $proveedor) {
        try {
            $this->proveedorRepository->eliminarProveedor($proveedor);
            return response()->json(["mensaje" => "Proveedor dado de baja"],200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    
    public function reactivar($id)
{
    try {
        $resultado = $this->proveedorRepository->reactivarProveedor($id);
        return response()->json($resultado, 200);
    } catch (\Exception $e) {
        return response()->json(['mensaje' => $e->getMessage()], 500);
    }
}

 public function readOne(Request $request) {
    try {
        $request->validate([
            'correo' => 'required|email'
        ]);

        $correo = $request->input('correo');
        $resultado = $this->proveedorRepository->obtenerUnProveedor($correo);

        return response()->json($resultado, $resultado['data'] ? 200 : 404);
    }
    catch (\Exception $e) {
        return response()->json(["mensaje" => $e->getMessage()], 404);
    }
}

}
