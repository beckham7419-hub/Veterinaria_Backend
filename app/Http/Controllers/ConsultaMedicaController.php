<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ConsultaMedicaRepository;
use App\Http\Requests\StoreConsultaMedicaRequest;
use App\Http\Requests\UpdateConsultaMedicaRequest;
use App\Models\ConsultaMedica;

class ConsultaMedicaController extends Controller
{
    protected $consultaMedicaRepository;

    public function __construct(ConsultaMedicaRepository $consultaMedicaRepository)
    {
        $this->consultaMedicaRepository = $consultaMedicaRepository;
    }

    public function store(StoreConsultaMedicaRequest $request)
    {
        try {

            $consulta = $this->consultaMedicaRepository
                ->crearConsulta($request->validated());

            return response()->json($consulta, 201);

        } catch (\Exception $e) {

            return response()->json([
                'mensaje' => $e->getMessage()
            ], 422);

        }
    }

    public function index()
    {
    return response()->json(
        ConsultaMedica::with([
            'cita',
            'vacunas'
        ])->get()
    );
}



    public function show(ConsultaMedica $consultaMedica)
    {
        try {

            $consulta = $this->consultaMedicaRepository
                ->obtenerConsulta($consultaMedica);

            return response()->json($consulta, 200);

        } catch (\Exception $e) {

            return response()->json([
                'mensaje' => $e->getMessage()
            ], 404);

        }
    }
    public function update(UpdateConsultaMedicaRequest $request, ConsultaMedica $consultaMedica)
{
    try {

        $consultaMedica->update($request->validated());

        return response()->json([
            'mensaje' => 'Consulta medica actualizada',
            'consulta' => $consultaMedica
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            'mensaje' => $e->getMessage()
        ], 422);

    }
}
}