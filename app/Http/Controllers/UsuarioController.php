<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UsuarioRepository;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    protected $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function index()
    {
        try {
            $usuarios = $this->usuarioRepository->obtenerUsuarios();
            return response()->json($usuarios, 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function veterinarios()
    {
        try {
            $veterinarios = $this->usuarioRepository->obtenerVeterinarios();
            return response()->json($veterinarios, 200);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function store(StoreUsuarioRequest $request)
    {
        try {
            $usuario = $this->usuarioRepository->registrarUsuario($request->validated());
            return response()->json($usuario, 201);
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function show(Usuario $usuario)
    {
        try {

            return response()->json($usuario, 200);

        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 404);
        }
    }

    public function update(UpdateUsuarioRequest $request, Usuario $usuario)
    {
        try {
             if ($usuario->correo === "administrador@veterinaria.com" ) {
            return response()->json([
                'mensaje' => 'No puedes editar la informacion del administrador principal.'
            ], 403); 
        }
            $usuario = $this->usuarioRepository->actualizarUsuario($usuario, $request->validated());
            return response()->json($usuario, 200);

        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 404);
        }
    }
    
    
    public function destroy(Request $request, Usuario $usuario) {
    try {
        if ($request->user() && $request->user()->id === $usuario->id) {
            return response()->json([
                'mensaje' => 'No puedes darte de baja a ti mismo estando en la misma sesión.'
            ], 403); 
        }
         if ($usuario->correo === "administrador@veterinaria.com" ) {
            return response()->json([
                'mensaje' => 'No puedes eliminar al administrador principal.'
            ], 403); 
        }
        $this->usuarioRepository->eliminarUsuario($usuario);

        return response()->json(["mensaje" => "Usuario dado de baja"], 200);
        
    } 
    catch (\Exception $e) {
        return response()->json(["mensaje" => $e->getMessage()], 500);
    }
}

    public function readOne(Request $request){
     try {
        $request->validate([
            'correo'=>'required|email'
        ]);
        
        $correo=$request->input('correo');        
        $resultado=$this->usuarioRepository->obtenerUnUsuario($correo);
        
        if (!$resultado) {
                return response()->json(["mensaje" => "Usuario no encontrado"], 404);
            }

                return response()->json([
                    "mensaje" => "Usuario encontrado",
                    "usuario"=> $resultado
                    ], 200);
        } 
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],404);
        }
    }

    public function reactivar($id)
{
    try {
        $resultado = $this->usuarioRepository->reactivarUsuario($id);
        return response()->json($resultado, 200);
    } catch (\Exception $e) {
        return response()->json(['mensaje' => $e->getMessage()], 500);
    }
}
}
