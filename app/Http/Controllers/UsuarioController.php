<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Http\Repositories\UsuarioRepository;

class UsuarioController extends Controller
{
    protected $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository) {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function index() {
        try {
            $usuarios = $this->usuarioRepository->obtenerUsuarios();
            return response()->json($usuarios,200);
        } 
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function store(StoreUsuarioRequest $request) {
        try {
            $usuario = $this->usuarioRepository->registrarUsuario($request->validated());
            return response()->json($usuario,201);
        } 
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function show(Usuario $usuario) {
        try {
            return response()->json($usuario,200);
        }
        catch(\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],404);
        }
    }

    public function update(UpdateUsuarioRequest $request, Usuario $usuario) {
        try {
            $usuario = $this->usuarioRepository->actualizarUsuario($usuario, $request->validated());
            return response()->json($usuario,200);
        } 
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],404);
        }
    }
    
    public function destroy(Usuario $usuario) {
        try {
            $this->usuarioRepository->eliminarUsuario($usuario);
            return response()->json(["mensaje" => "Usuario dado de baja"],200);
        } 
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],404);
        }
    }
}
