<?php

namespace App\Http\Repositories;

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthUsuarioRepository
{
    private const MAX_INTENTOS = 5;
    private const MINUTOS_BLOQUEO = 1;

    public function login(array $credenciales) {
        $usuario = Usuario::where("correo", $credenciales["correo"])->first();

        if (!$usuario) {
            throw new \Exception("Credenciales invalidas");
        }

        if ($usuario->bloqueado_hasta) {
            if ($usuario->bloqueado_hasta->isFuture()) {
                throw new \Exception("Cuenta bloqueada temporalmente. Intenta mas tarde.");
            }

            $usuario->intentos_fallidos = 0;
            $usuario->bloqueado_hasta = null;
        }

        if (!Hash::check($credenciales["contrasena"], $usuario->contrasena)) {
            $usuario->intentos_fallidos += 1;

            if ($usuario->intentos_fallidos >= self::MAX_INTENTOS) {
                $usuario->bloqueado_hasta = now()->addMinutes(self::MINUTOS_BLOQUEO);
            }

            $usuario->save();
            throw new \Exception("Credenciales invalidas");
        }

        $usuario->intentos_fallidos = 0;
        $usuario->bloqueado_hasta = null;
        $usuario->save();

        $token = Auth::guard("usuarios")->login($usuario);

        return [
            "mensaje" => "Login exitoso",
            "usuario" => $usuario,
            "token" => $token
        ];
    }

    public function logout(Usuario $usuario) {
        try {
            $usuario->tokens_validos_desde = now();
            $usuario->save();

            Auth::guard("usuarios")->logout();

            return [
                "mensaje" => "Sesion cerrada correctamente"
            ];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo cerrar la sesion: " . $e -> getMessage(), 0, $e);
        }
    }
}