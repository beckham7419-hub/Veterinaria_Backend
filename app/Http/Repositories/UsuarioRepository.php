<?php

namespace App\Http\Repositories;

use App\Models\Usuario;

class UsuarioRepository
{
    public function obtenerUsuarios()
    {
        try {
            $usuarios = Usuario::where('activo', true)->get();

            return [
                'mensaje' => 'Usuarios obtenidos',
                'data' => $usuarios,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudieron obtener los usuarios: '.$e->getMessage(), 0, $e);
        }
    }

    public function obtenerUnUsuario(string $correo) {
        try {
            $usuario = Usuario::where('correo',$correo)->first();
            return [
                "mensaje" => $usuario?"Usuario encontrado":"Usuario no encontrado",
                "data" => $usuario
            ];
        } 
        catch (\Exception $e) {
            throw new \Exception("No se pudo encontrar el usuario: " . $e -> getMessage(), 0, $e);
        }
    }
    public function obtenerVeterinarios()
    {
        try {
            $veterinarios = Usuario::where('activo', true)
                ->where('rol', 'veterinario')
                ->get(['id', 'nombre_completo', 'correo']);

            return [
                'mensaje' => 'Veterinarios obtenidos',
                'data' => $veterinarios,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudieron obtener los veterinarios: '.$e->getMessage(), 0, $e);
        }
    }

    public function registrarUsuario(array $data)
    {
        try {
            $usuario = Usuario::create($data);

            return [
                'mensaje' => 'Usuario registrado',
                'usuario' => $usuario,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo registrar el usuario: '.$e->getMessage(), 0, $e);
        }
    }

    public function actualizarUsuario(Usuario $usuario, array $data)
    {
        try {
            if (empty($data['contrasena'])) {
                unset($data['contrasena']);
            }
            $usuario->update($data);

            return [
                'mensaje' => 'Usuario actualizado',
                'usuario' => $usuario,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo actualizar el usuario: '.$e->getMessage(), 0, $e);
        }
    }

    public function eliminarUsuario(Usuario $usuario)
    {
        try {
            $usuario->activo = false;
            $usuario->save();

            return [
                'mensaje' => 'Usuario eliminado',
                'usuario' => $usuario,
            ];
        } catch (\Exception $e) {
            throw new \Exception('No se pudo dar de baja al usuario: '.$e->getMessage(), 0, $e);
        }
    }

    public function reactivarUsuario(int $id)
{
     try {
    $usuario = Usuario::findOrFail($id);
    $usuario->activo = true;
    $usuario->save();

    return ['mensaje' => 'Usuario reactivado', 'usuario' => $usuario];
     }catch (\Exception $e) {
            throw new \Exception('No se pudo reactivar al usuario: '.$e->getMessage(), 0, $e);
        }
}
}
