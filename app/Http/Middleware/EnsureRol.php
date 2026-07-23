<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRol
{
    public function handle(Request $request, Closure $next, ...$rolesPermitidos)
    {
        $usuario = Auth::guard("usuarios")->user();

        if (!$usuario || !in_array($usuario->rol, $rolesPermitidos)) {
            return response()->json(["mensaje" => "No tienes permiso para esta accion"], 403);
        }

        return $next($request);
    }
}
