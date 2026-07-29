<?php

namespace App\Http\Controllers;

use App\Http\Repositories\DuenoRepository;
use App\Http\Requests\StoreDuenoRequest;
use App\Http\Requests\UpdateDuenoRequest;
use App\Models\Dueno;
use Illuminate\Http\Request;

class DuenoController extends Controller
{
    protected $duenoRepository;

    public function __construct(DuenoRepository $duenoRepository)
    {
        $this->duenoRepository = $duenoRepository;
    }

    public function index(Request $request)
    {
        try {
            $duenos = $this->duenoRepository->obtenerDuenos($request->query('buscar'));

            return response()->json($duenos, 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function store(StoreDuenoRequest $request)
    {
        try {
            $dueno = $this->duenoRepository->registrarDueno($request->validated());

            return response()->json($dueno, 201);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function show(Dueno $dueno)
    {
        try {
            return response()->json($dueno, 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 404);
        }
    }

    public function update(UpdateDuenoRequest $request, Dueno $dueno)
    {
        try {
            $dueno = $this->duenoRepository->actualizarDueno($dueno, $request->validated());

            return response()->json($dueno, 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 404);
        }
    }

    public function destroy(Dueno $dueno)
    {
        try {
            $this->duenoRepository->eliminarDueno($dueno);

            return response()->json(['mensaje' => 'Dueno dado de baja'], 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 404);
        }
    }
}
