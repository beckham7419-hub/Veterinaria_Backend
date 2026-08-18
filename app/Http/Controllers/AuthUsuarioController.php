<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUsuarioRequest;
use App\Http\Repositories\AuthUsuarioRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SolicitarRecuperacionRequest;
use App\Http\Requests\RestablecerContrasenaRequest;
use App\Http\Repositories\PasswordResetRepository;

class AuthUsuarioController extends Controller
{
    protected $authUsuarioRepository;
    protected $passwordResetRepository;

    public function __construct(AuthUsuarioRepository $authUsuarioRepository, PasswordResetRepository $passwordResetRepository) {
        $this->authUsuarioRepository = $authUsuarioRepository;
        $this->passwordResetRepository = $passwordResetRepository;
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

    public function olvideContrasena(SolicitarRecuperacionRequest $request) {
        try {
            $resultado = $this->passwordResetRepository->solicitarRecuperacion($request->validated()["correo"], "usuario");
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function restablecerContrasena(RestablecerContrasenaRequest $request) {
        try {
            $datos = $request->validated();
            $resultado = $this->passwordResetRepository->restablecerContrasena($datos["correo"], $datos["token"], $datos["contrasena_nueva"], "usuario");
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],422);
        }
    }
    
}
