<?php

namespace App\Http\Repositories;

use App\Models\Usuario;

class UsuarioRepository
{
    public function obtenerUsuarios() {
        try {
            $usuarios = Usuario::all();
            return [
                "mensaje" => "Usuarios obtenidos",
                "data" => $usuarios
            ];
        } 
        catch (\Exception $e) {
            throw new \Exception("No se pudieron obtener los usuarios: " . $e -> getMessage(), 0, $e);
        }
    }

    public function registrarUsuario(array $data) {
        try {
            $usuario = Usuario::create($data);
            return [
                "mensaje" => "Usuario registrado",
                "usuario" => $usuario
            ];
        } 
        catch (\Exception $e) {
            throw new \Exception("No se pudo registrar el usuario: " . $e -> getMessage(), 0, $e);
        }
    }

    public function actualizarUsuario(Usuario $usuario, array $data) {
        try {
            $usuario->update($data);
            return [
                "mensaje" => "Usuario actualizado",
                "usuario" => $usuario
            ];
        } 
        catch (\Exception $e) {
            throw new \Exception("No se pudo actualizar el usuario: " . $e -> getMessage(), 0, $e);
        }
    }

    public function eliminarUsuario(Usuario $usuario) {
        try {
            $usuario->update(["activo" => false]);
            return [
                "mensaje" => "Usuario eliminado",
                "usuario" => $usuario
            ];
        } 
        catch (\Exception $e) {
            throw new \Exception("No se pudo dar de baja al usuario: " . $e -> getMessage(), 0, $e);
        }
    }
}