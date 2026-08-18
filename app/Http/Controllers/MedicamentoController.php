<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Http\Requests\StoreMedicamentoRequest;
use App\Http\Requests\UpdateMedicamentoRequest;
use App\Http\Repositories\MedicamentoRepository;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    protected $medicamentoRepository;

    public function __construct(MedicamentoRepository $medicamentoRepository) {
        $this->medicamentoRepository = $medicamentoRepository;
    }

    public function index() {
        try {
            $medicamentos = $this->medicamentoRepository->obtenerMedicamentos();
            return response()->json($medicamentos,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function store(StoreMedicamentoRequest $request) {
        try {
            $medicamento = $this->medicamentoRepository->registrarMedicamento($request->validated());
            return response()->json($medicamento,201);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function show(Medicamento $medicamento) {
        try {
            return response()->json($medicamento,200);
        } 
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e->getMessage()],404);
        }
    }

    public function update(UpdateMedicamentoRequest $request, Medicamento $medicamento) {
        try {
            $medicamento = $this->medicamentoRepository->actualizarMedicamento($medicamento, $request->validated());
            return response()->json($medicamento,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function destroy(Medicamento $medicamento) {
        try {
            $this->medicamentoRepository->eliminarMedicamento($medicamento);
            return response()->json(["mensaje" => "Medicamento dado de baja"],200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function readOne(Request $request) {
    try {
        $request->validate([
            'nombre' => 'required|string'
        ]);

        $nombre = $request->input('nombre');
        $resultado = $this->medicamentoRepository->obtenerUnMedicamento($nombre);

        return response()->json($resultado, $resultado['data'] ? 200 : 404);
    }
    catch (\Exception $e) {
        return response()->json(["mensaje" => $e -> getMessage()], 404);
    }
}

public function reactivar(Medicamento $medicamento) {
    try {
        $resultado = $this->medicamentoRepository->reactivarMedicamento($medicamento);
        return response()->json($resultado, 200);
    }
    catch (\Exception $e) {
        return response()->json(["mensaje" => $e -> getMessage()], 500);
    }
}

}
