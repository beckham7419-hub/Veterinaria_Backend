<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUsuarioRequest;
use App\Http\Repositories\AuthUsuarioRepository;
use Illuminate\Support\Facades\Auth;

class AuthUsuarioController extends Controller
{
    protected $authUsuarioRepository;

    public function __construct(AuthUsuarioRepository $authUsuarioRepository) {
        $this->authUsuarioRepository = $authUsuarioRepository;
    }

    public function login(LoginUsuarioRequest $request) {
        try {
            $resultado = $this->authUsuarioRepository->login($request->validated());
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],401);
        }
    }

    public function logout() {
        try {
            $usuario = Auth::guard("usuarios")->user();
            $resultado = $this->authUsuarioRepository->logout($usuario);
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }
}
