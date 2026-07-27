<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Http\Repositories\UsuarioRepository;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    protected $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository) {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function index() {
        try {
            $usuarios = $this->usuarioRepository->obtenerUsuarios();
            if ($request->expectsJson()) {
                return response()->json($usuarios, 200);
            }
            return view('panel.admin', ['users' => $usuarios['data']]);
        } 
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function store(StoreUsuarioRequest $request) {
        try {
            $usuario = $this->usuarioRepository->registrarUsuario($request->validated());
            if ($request->expectsJson()) {
                return response()->json($usuario,201);
            }
          return redirect()->back()->with('exito', 'Empleado registrado correctamente');
        } 
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function show(Usuario $usuario) {
        try {
            if ($request->expectsJson()) {
                return response()->json($usuario, 200);
            }
            return view('panel.admin_show', compact('usuario'));
        }
        catch(\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],404);
        }
    }

    public function update(UpdateUsuarioRequest $request, Usuario $usuario) {
        try {
            $usuario = $this->usuarioRepository->actualizarUsuario($usuario, $request->validated());
         if ($request->expectsJson()) {
                return response()->json($resultado, 200);
            }
            return redirect()->back()->with('exito', 'Empleado actualizado correctamente');
        } 
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],404);
        }
    }
    
    public function destroy(Request $request, Usuario $usuario) {
        try {
            $this->usuarioRepository->eliminarUsuario($usuario);
           if ($request->expectsJson()) {
                return response()->json(["mensaje" => "Usuario dado de baja"], 200);
            }

            return redirect()->back()->with('exito', 'Empleado dado de baja correctamente');
        } 
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],404);
        }
    }

    public function readOne(Request $request, Usuario $usuario){
     try {
            $this->usuarioRepository->obtenerUnUsuario($request);
           if ($request->expectsJson()) {
                return response()->json(["mensaje" => "Usuario encontrado"], $usuario, 200);
            }

            return redirect()->back()->with('exito', 'Usuario encontrado');
        } 
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],404);
        }
    }
}
