<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Http\Requests\StoreMiMascotaRequest;
use App\Http\Requests\UpdateMiMascotaRequest;
use App\Http\Repositories\MascotaRepository;
use Illuminate\Support\Facades\Auth;

class MisMascotasController extends Controller
{
    protected $mascotaRepository;

    public function __construct(MascotaRepository $mascotaRepository) {
        $this->mascotaRepository = $mascotaRepository;
    }

    public function index() {
        try {
            $dueno = Auth::guard("duenos")->user();
            $mascotas = $this->mascotaRepository->obtenerMascotasDeDueno($dueno->id);
            return response()->json($mascotas,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function store(StoreMiMascotaRequest $request) {
        try {
            $dueno = Auth::guard("duenos")->user();
            $data = $request->validated();
            $data['dueno_id'] = $dueno->id;

            $mascota = $this->mascotaRepository->registrarMascota($data);
            return response()->json($mascota,201);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function show(Mascota $mascota) {
        $dueno = Auth::guard("duenos")->user();

        if ((int) $mascota->dueno_id !== (int) $dueno->id) {
            return response()->json(["mensaje" => "No tienes permiso para ver esta mascota"],403);
        }

        return response()->json($mascota,200);
    }

    public function update(UpdateMiMascotaRequest $request, Mascota $mascota) {
        $dueno = Auth::guard("duenos")->user();

        if ((int) $mascota->dueno_id !== (int) $dueno->id) {
            return response()->json(["mensaje" => "No tienes permiso para editar esta mascota"],403);
        }

        try {
            $mascota = $this->mascotaRepository->actualizarMascota($mascota, $request->validated());
            return response()->json($mascota,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }
}
