<?php

namespace App\Http\Controllers;

use App\Http\Repositories\MascotaRepository;
use App\Http\Requests\StoreMascotaRequest;
use App\Http\Requests\UpdateMascotaRequest;
use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            $datos = $request->validated();
            unset($datos['foto']);

            if ($request->hasFile('foto')) {
                $datos['foto_url'] = Storage::disk('public')->url(
                    $request->file('foto')->store('mascotas', 'public')
                );
            }

            $mascota = $this->mascotaRepository->registrarMascota($datos);

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
            $datos = $request->validated();
            unset($datos['foto'], $datos['dueno_id'], $datos['especie'], $datos['raza']);

            if ($request->hasFile('foto')) {
                if ($mascota->foto_url) {
                    Storage::disk('public')->delete(Str::after($mascota->foto_url, '/storage/'));
                }

                $datos['foto_url'] = Storage::disk('public')->url(
                    $request->file('foto')->store('mascotas', 'public')
                );
            }

            $mascota = $this->mascotaRepository->actualizarMascota($mascota, $datos);

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

    public function historial(Mascota $mascota)
{
    try {
        $resultado = $this->mascotaRepository->obtenerHistorialCompleto($mascota);
        return response()->json($resultado, 200);
    } catch (\Exception $e) {
        return response()->json(['mensaje' => $e->getMessage()], 500);
    }
}
}
