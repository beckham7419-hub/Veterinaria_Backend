<?php

namespace App\Http\Repositories;

use App\Models\Dueno;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthDuenoRepository
{
    public function login(array $credenciales) {
        $dueno = Dueno::where("correo", $credenciales["correo"])->first();

        if (!$dueno) {
            throw new \Exception("Credenciales invalidas");
        }

        if (!Hash::check($credenciales["contrasena"], $dueno->contrasena)) {
            throw new \Exception("Credenciales invalidas");
        }

        $token = Auth::guard("duenos")->login($dueno);

        return [
            "mensaje" => "Login exitoso",
            "dueno" => $dueno,
            "token" => $token
        ];
    }

    public function logout(Dueno $dueno) {
        try {
            $dueno->tokens_validos_desde = now();
            $dueno->save();

            Auth::guard("duenos")->logout();

            return [
                "mensaje" => "Sesion cerrada correctamente"
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo cerrar la sesion: " . $e -> getMessage(), 0, $e);
        }
    }
}