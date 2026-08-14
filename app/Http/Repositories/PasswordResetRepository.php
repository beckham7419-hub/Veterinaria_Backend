<?php

namespace App\Http\Repositories;

use App\Models\PasswordReset;
use App\Models\Usuario;
use App\Models\Dueno;
use App\Mail\RecuperarContrasenaMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetRepository
{
    public function solicitarRecuperacion(string $correo, string $tipo) {
        try {
            $modelo = $tipo === "usuario" ? Usuario::class : Dueno::class;
            $cuenta = $modelo::where("correo", $correo)->first();

            if ($cuenta) {
                PasswordReset::where("correo", $correo)->where("tipo", $tipo)->delete();

                $tokenCrudo = Str::random(64);

                PasswordReset::create([
                    "correo" => $correo,
                    "tipo" => $tipo,
                    "token" => Hash::make($tokenCrudo),
                    "expira_en" => now()->addMinutes(60),
                ]);

                $enlace = config("app.url") . "/restablecer-contrasena?correo=" . urlencode($correo) . "&token=" . $tokenCrudo . "&tipo=" . $tipo;

                Mail::to($correo)->send(new RecuperarContrasenaMail($enlace));
            }

            return ["mensaje" => "Si el correo esta registrado, se envio un enlace de recuperacion."];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo procesar la solicitud: " . $e -> getMessage(), 0, $e);
        }
    }

    public function restablecerContrasena(string $correo, string $token, string $contrasenaNueva, string $tipo) {
        $registro = PasswordReset::where("correo", $correo)->where("tipo", $tipo)->first();

        if (!$registro || now()->greaterThan($registro->expira_en) || !Hash::check($token, $registro->token)) {
            throw new \Exception("El enlace de recuperacion es invalido o ha expirado.");
        }

        try {
            $modelo = $tipo === "usuario" ? Usuario::class : Dueno::class;
            $cuenta = $modelo::where("correo", $correo)->firstOrFail();

            $cuenta->contrasena = $contrasenaNueva;
            $cuenta->tokens_validos_desde = now();
            $cuenta->save();

            $registro->delete();

            return ["mensaje" => "Contrasena restablecida correctamente. Ya puedes iniciar sesion."];
        }
        catch (\Exception $e) {
            throw new \Exception("No se pudo restablecer la contrasena: " . $e -> getMessage(), 0, $e);
        }
    }
}