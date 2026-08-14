<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginDuenoRequest;
use App\Http\Repositories\AuthDuenoRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SolicitarRecuperacionRequest;
use App\Http\Requests\RestablecerContrasenaRequest;
use App\Http\Repositories\PasswordResetRepository;

class AuthDuenoController extends Controller
{
    protected $authDuenoRepository;
    protected $passwordResetRepository;

    public function __construct(AuthDuenoRepository $authDuenoRepository, PasswordResetRepository $passwordResetRepository) {
        $this->authDuenoRepository = $authDuenoRepository;
        $this->passwordResetRepository = $passwordResetRepository;
    }

    public function login(LoginDuenoRequest $request) {
        try {
            $resultado = $this->authDuenoRepository->login($request->validated());
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],401);
        }
    }

    public function logout() {
        try {
            $dueno = Auth::guard("duenos")->user();
            $resultado = $this->authDuenoRepository->logout($dueno);
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function olvideContrasena(SolicitarRecuperacionRequest $request) {
        try {
            $resultado = $this->passwordResetRepository->solicitarRecuperacion($request->validated()["correo"], "dueno");
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function restablecerContrasena(RestablecerContrasenaRequest $request) {
        try {
            $datos = $request->validated();
            $resultado = $this->passwordResetRepository->restablecerContrasena($datos["correo"], $datos["token"], $datos["contrasena_nueva"], "dueno");
            return response()->json($resultado,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],422);
        }
    }
}
