<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Http\Requests\StoreMiMascotaRequest;
use App\Http\Requests\UpdateMiMascotaRequest;
use App\Http\Repositories\MascotaRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            $datos = $request->validated();
            unset($datos["foto"]);
            $datos["dueno_id"] = $dueno->id;

            if ($request->hasFile("foto")) {
                $datos["foto_url"] = Storage::disk("public")->url(
                    $request->file("foto")->store("mascotas", "public")
                );
            }

            $mascota = $this->mascotaRepository->registrarMascota($datos);
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

        try {
            $resultado = $this->mascotaRepository->obtenerPerfilCompleto($mascota);
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function historial(Mascota $mascota) {
        $dueno = Auth::guard("duenos")->user();

        if ((int) $mascota->dueno_id !== (int) $dueno->id) {
            return response()->json(["mensaje" => "No tienes permiso para ver esta mascota"],403);
        }

        try {
            $resultado = $this->mascotaRepository->obtenerHistorialCompleto($mascota);
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function update(UpdateMiMascotaRequest $request, Mascota $mascota) {
        $dueno = Auth::guard("duenos")->user();

        if ((int) $mascota->dueno_id !== (int) $dueno->id) {
            return response()->json(["mensaje" => "No tienes permiso para editar esta mascota"],403);
        }

        try {
            $datos = $request->validated();
            unset($datos["foto"]);

            if ($request->hasFile("foto")) {
                if ($mascota->foto_url) {
                    Storage::disk("public")->delete(Str::after($mascota->foto_url, "/storage/"));
                }

                $datos["foto_url"] = Storage::disk("public")->url(
                    $request->file("foto")->store("mascotas", "public")
                );
            }

            $mascota = $this->mascotaRepository->actualizarMascota($mascota, $datos);
            return response()->json($mascota,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }
}
