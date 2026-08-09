<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Mascota;
use App\Http\Requests\StoreMiCitaRequest;
use App\Http\Repositories\CitaRepository;
use App\Mail\CitaConfirmadaMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class MisCitasController extends Controller
{
    protected $citaRepository;

    public function __construct(CitaRepository $citaRepository) {
        $this->citaRepository = $citaRepository;
    }

    public function index() {
        try {
            $dueno = Auth::guard("duenos")->user();
            $citas = $this->citaRepository->obtenerCitasDeDueno($dueno->id);
            return response()->json($citas,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function store(StoreMiCitaRequest $request) {
        try {
            $dueno = Auth::guard("duenos")->user();
            $data = $request->validated();

            $mascota = Mascota::find($data["mascota_id"]);
            if (!$mascota || (int) $mascota->dueno_id !== (int) $dueno->id) {
                return response()->json(["mensaje" => "Esta mascota no te pertenece"],403);
            }

            $resultado = $this->citaRepository->agendarCita($data);

            Mail::to($dueno->correo)->send(new CitaConfirmadaMail($resultado["cita"]));

            return response()->json($resultado,201);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],422);
        }
    }

    public function cancelar(Cita $cita) {
        try {
            $dueno = Auth::guard("duenos")->user();
            $resultado = $this->citaRepository->cancelarCitaDueno($cita, $dueno->id);
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],422);
        }
    }

    public function horariosDisponibles(Request $request) {
        try {
            $veterinarioId = $request->query("veterinario_id");
            $fecha = $request->query("fecha");

            if (!$veterinarioId || !$fecha) {
                return response()->json(["mensaje" => "Debes indicar veterinario_id y fecha"],422);
            }

            $horarios = $this->citaRepository->obtenerHorariosOcupados($veterinarioId, $fecha);
            return response()->json($horarios,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function confirmar(Cita $cita)
{
    if (Carbon::parse("{$cita->fecha} {$cita->hora}")->isPast()) {
        return response()->json(['mensaje' => 'No se puede confirmar una cita que ya venció'], 422);
    }
    $cita->update(['estado' => 'confirmada']);
    return response()->json(['data' => $cita]);
}

}
