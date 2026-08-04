<?php

namespace App\Http\Controllers;

use App\Http\Repositories\VacunaRepository;
use App\Http\Requests\StoreVacunaRequest;
use App\Http\Requests\UpdateVacunaRequest;
use App\Models\Vacuna;

class VacunaController extends Controller
{
    protected $vacunaRepository;

    public function __construct(VacunaRepository $vacunaRepository)
    {
        $this->vacunaRepository = $vacunaRepository;
    }

    public function store(StoreVacunaRequest $request)
    {
        try {

            $vacuna = $this->vacunaRepository
                ->crearVacuna($request->validated());

            return response()->json($vacuna, 201);

        } catch (\Exception $e) {

            return response()->json([
                'mensaje' => $e->getMessage()
            ], 422);

        }
    }

    public function show(Vacuna $vacuna)
    {
        try {

            $resultado = $this->vacunaRepository
                ->obtenerVacuna($vacuna);

            return response()->json($resultado, 200);

        } catch (\Exception $e) {

            return response()->json([
                'mensaje' => $e->getMessage()
            ], 404);

        }
    }

    public function update(UpdateVacunaRequest $request, Vacuna $vacuna)
    {
        try {

            $vacuna->update($request->validated());

            return response()->json([
                'mensaje' => 'Vacuna actualizada',
                'vacuna' => $vacuna
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'mensaje' => $e->getMessage()
            ], 422);

        }
    }
}