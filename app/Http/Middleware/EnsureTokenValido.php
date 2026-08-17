<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EnsureTokenValido
{
    public function handle(Request $request, Closure $next, string $guard)
    {
        $usuario = Auth::guard($guard)->user();

        if (!$usuario) {
            return response()->json(["mensaje" => "No autenticado"], 401);
        }

         if (!$usuario->activo) {
            return response()->json(["mensaje" => "Cuenta deshabilitada. Contacta al administrador."], 401);
        }

        if ($usuario->tokens_validos_desde) {
            $iat = Carbon::createFromTimestampUTC(Auth::guard($guard)->payload()["iat"]);

            if ($iat->lessThan($usuario->tokens_validos_desde)) {
                return response()->json(["mensaje" => "Token invalido, inicia sesion de nuevo"], 401);
            }
        }

        return $next($request);
    }
}
