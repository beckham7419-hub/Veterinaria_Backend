<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Http\Requests\StoreArchivoConsultaRequest;
use App\Http\Repositories\ArchivoConsultaRepository;
use Illuminate\Support\Facades\Auth;

class ArchivoConsultaController extends Controller
{
    protected $archivoConsultaRepository;

    public function __construct(ArchivoConsultaRepository $archivoConsultaRepository) {
        $this->archivoConsultaRepository = $archivoConsultaRepository;
    }

    public function store(StoreArchivoConsultaRequest $request, Consulta $consulta) {
        try {
            $veterinario = Auth::guard("usuarios")->user();
            $resultado = $this->archivoConsultaRepository->subirArchivo($consulta, $request->file("archivo"), $veterinario->id);
            return response()->json($resultado, 201);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()], 422);
        }
    }

    public function index(Consulta $consulta) {
        try {
            $resultado = $this->archivoConsultaRepository->obtenerArchivos($consulta);
            return response()->json($resultado, 200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()], 500);
        }
    }
}