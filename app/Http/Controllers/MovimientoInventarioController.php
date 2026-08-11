<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Http\Requests\StoreMovimientoInventarioRequest;
use App\Http\Repositories\MovimientoInventarioRepository;
use Illuminate\Support\Facades\Auth;

class MovimientoInventarioController extends Controller
{
    protected $movimientoRepository;

    public function __construct(MovimientoInventarioRepository $movimientoRepository) {
        $this->movimientoRepository = $movimientoRepository;
    }

    public function entrada(StoreMovimientoInventarioRequest $request, Medicamento $medicamento) {
        try {
            $usuario = Auth::guard("usuarios")->user();
            $resultado = $this->movimientoRepository->registrarEntrada($medicamento, $request->validated(), $usuario->id);
            return response()->json($resultado,201);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],422);
        }
    }

    public function salida(StoreMovimientoInventarioRequest $request, Medicamento $medicamento) {
        try {
            $usuario = Auth::guard("usuarios")->user();
            $resultado = $this->movimientoRepository->registrarSalida($medicamento, $request->validated(), $usuario->id);
            return response()->json($resultado,201);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],422);
        }
    }

    public function historial(Medicamento $medicamento) {
        try {
            $resultado = $this->movimientoRepository->obtenerHistorial($medicamento);
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }
}