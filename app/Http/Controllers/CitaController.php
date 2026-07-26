<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Http\Requests\StoreCitaRequest;
use App\Http\Requests\UpdateCitaRequest;
use App\Http\Requests\CancelarCitaRequest;
use App\Http\Repositories\CitaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    protected $citaRepository;

    public function __construct(CitaRepository $citaRepository) {
        $this->citaRepository = $citaRepository;
    }

    public function index(Request $request) {
        try {
            $citas = $this->citaRepository->obtenerCitas(
                $request->query("estado"),
                $request->query("mascota_id")
            );
            return response()->json($citas,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function store(StoreCitaRequest $request) {
        try {
            $cita = $this->citaRepository->agendarCita($request->validated());
            return response()->json($cita,201);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],422);
        }
    }

    public function show(Cita $cita) {
        try {
            return response()->json($cita,200);
        }
        catch(\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],404);
        }
        
    }

    public function update(UpdateCitaRequest $request, Cita $cita) {
        try {
            $cita = $this->citaRepository->actualizarCita($cita, $request->validated());
            return response()->json($cita,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],422);
        }
    }

    public function cancelar(CancelarCitaRequest $request, Cita $cita) {
        try {
            $usuario = Auth::guard("usuarios")->user();
            $resultado = $this->citaRepository->cancelarCita(
                $cita,
                $request->validated()["motivo_cancelacion"],
                $usuario->id
            );
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],422);
        }
    }

    public function registrarLlegada(Cita $cita) {
        try {
            $resultado = $this->citaRepository->registrarLlegada($cita);
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],422);
        }
    }
}
