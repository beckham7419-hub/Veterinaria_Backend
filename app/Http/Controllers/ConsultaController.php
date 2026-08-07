<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Consulta;
use App\Http\Requests\StoreConsultaRequest;
use App\Http\Requests\UpdateConsultaRequest;
use App\Http\Repositories\ConsultaRepository;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    protected $consultaRepository;

    public function __construct(ConsultaRepository $consultaRepository) {
        $this->consultaRepository = $consultaRepository;
    }

    public function store(StoreConsultaRequest $request, Cita $cita) {
        try {
            $veterinario = Auth::guard("usuarios")->user();
            $resultado = $this->consultaRepository->registrarConsulta($cita, $request->validated(), $veterinario->id);
            return response()->json($resultado, 201);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()], 422);
        }
    }

    public function show(Cita $cita) {
        $consulta = $cita->consulta;

        if (!$consulta) {
            return response()->json(["mensaje" => "Esta cita no tiene consulta registrada"], 404);
        }

        return response()->json($consulta, 200);
    }

    public function update(UpdateConsultaRequest $request, Consulta $consulta) {
        try {
            $veterinario = Auth::guard("usuarios")->user();
            $resultado = $this->consultaRepository->actualizarConsulta($consulta, $request->validated(), $veterinario->id);
            return response()->json($resultado, 200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()], 422);
        }
    }
}
