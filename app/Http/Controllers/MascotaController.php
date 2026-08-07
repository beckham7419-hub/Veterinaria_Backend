<?php

namespace App\Http\Controllers;

use App\Http\Repositories\MascotaRepository;
use App\Http\Requests\StoreMascotaRequest;
use App\Http\Requests\UpdateMascotaRequest;
use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    protected $mascotaRepository;

    public function __construct(MascotaRepository $mascotaRepository)
    {
        $this->mascotaRepository = $mascotaRepository;
    }

    public function index(Request $request)
    {
        try {
            $mascotas = $this->mascotaRepository->obtenerMascotas($request->query('buscar'), $request->query('dueno_id'));

            return response()->json($mascotas, 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function store(StoreMascotaRequest $request)
    {
        try {
            $mascota = $this->mascotaRepository->registrarMascota($request->validated());

            return response()->json($mascota, 201);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function show(Mascota $mascota)
    {
        try {
            return response()->json($mascota, 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 404);
        }
    }

    public function update(UpdateMascotaRequest $request, Mascota $mascota)
    {
        try {
            $mascota = $this->mascotaRepository->actualizarMascota($mascota, $request->validated());

            return response()->json($mascota, 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 404);
        }
    }

    public function destroy(Mascota $mascota)
    {
        try {
            $this->mascotaRepository->eliminarMascota($mascota);

            return response()->json(['mensaje' => 'Mascota dada de baja'], 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }
}
