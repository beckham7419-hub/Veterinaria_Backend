<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginDuenoRequest;
use App\Http\Repositories\AuthDuenoRepository;
use Illuminate\Support\Facades\Auth;

class AuthDuenoController extends Controller
{
    protected $authDuenoRepository;

    public function __construct(AuthDuenoRepository $authDuenoRepository) {
        $this->authDuenoRepository = $authDuenoRepository;
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
}
