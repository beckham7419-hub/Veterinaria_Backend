<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePerfilDuenoRequest;
use App\Http\Requests\CambiarContrasenaDuenoRequest;
use App\Http\Repositories\PerfilDuenoRepository;
use Illuminate\Support\Facades\Auth;

class PerfilDuenoController extends Controller
{
    protected $perfilDuenoRepository;

    public function __construct(PerfilDuenoRepository $perfilDuenoRepository) {
        $this->perfilDuenoRepository = $perfilDuenoRepository;
    }

    public function show() {
        $dueno = Auth::guard("duenos")->user();
        $perfil = $this->perfilDuenoRepository->verPerfil($dueno);
        return response()->json($perfil,200);
    }

    public function update(UpdatePerfilDuenoRequest $request) {
        try {
            $dueno = Auth::guard("duenos")->user();
            $perfil = $this->perfilDuenoRepository->actualizarPerfil($dueno, $request->validated());
            return response()->json($perfil,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function cambiarContrasena(CambiarContrasenaDuenoRequest $request) {
        try {
            $dueno = Auth::guard("duenos")->user();
            $resultado = $this->perfilDuenoRepository->cambiarContrasena($dueno, $request->validated());
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],401);
        }
    }
}
