<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Http\Requests\StoreVacunaRequest;
use App\Http\Repositories\VacunaRepository;
use Illuminate\Support\Facades\Auth;

class VacunaController extends Controller
{
    protected $vacunaRepository;

    public function __construct(VacunaRepository $vacunaRepository) {
        $this->vacunaRepository = $vacunaRepository;
    }

    public function store(StoreVacunaRequest $request, Mascota $mascota) {
        try {
            $veterinario = Auth::guard("usuarios")->user();
            $resultado = $this->vacunaRepository->registrarVacuna($mascota, $request->validated(), $veterinario->id);
            return response()->json($resultado, 201);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()], 422);
        }
    }

    public function index(Mascota $mascota) {
        try {
            $resultado = $this->vacunaRepository->obtenerVacunasDeMascota($mascota);
            return response()->json($resultado, 200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()], 500);
        }
    }
}