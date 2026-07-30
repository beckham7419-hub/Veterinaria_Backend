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

    public function index(Request $request)
    {
        try {
            $usuarios = $this->usuarioRepository->obtenerUsuarios();
            if ($request->expectsJson()) {
                return response()->json($usuarios, 200);
            }

            return view('panel.admin', ['users' => $usuarios['data']]);
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
            if ($request->expectsJson()) {
                return response()->json($usuario, 201);
            }

            return redirect()->back()->with('exito', 'Empleado registrado correctamente');
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, Usuario $usuario)
    {
        try {
            if ($request->expectsJson()) {
                return response()->json($usuario, 200);
            }

            return view('panel.admin_show', compact('usuario'));
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 404);
        }
    }

    public function update(UpdateUsuarioRequest $request, Usuario $usuario)
    {
        try {
            $usuario = $this->usuarioRepository->actualizarUsuario($usuario, $request->validated());
            if ($request->expectsJson()) {
                return response()->json($usuario, 200);
            }

            return redirect()->back()->with('exito', 'Empleado actualizado correctamente');
        } catch (\Exception $e) {
            return response()->json(['mensaje' => $e->getMessage()], 404);
        }
    }
    
    
    public function destroy(Request $request, Usuario $usuario) {
    try {
        
        if ($usuario->id == 1) {
            if ($request->expectsJson()) {
                return response()->json(["mensaje" => "El administrador principal no puede ser eliminado"], 403);
            }
            return redirect()->back()->with('error', 'El administrador principal no puede ser eliminado');
        }

        $idAutenticado = auth('usuarios')->check() 
    ? auth('usuarios')->id() 
    : (auth()->check() ? auth()->id() : null);

        if ($usuario->id == $idAutenticado) {
            if ($request->expectsJson()) {
                return response()->json(["mensaje" => "No puedes eliminar tu propia cuenta con la sesión activa"], 403);
            }
            return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta con la sesión activa');
        }

        $this->usuarioRepository->eliminarUsuario($usuario);

        if ($request->expectsJson()) {
            return response()->json(["mensaje" => "Usuario dado de baja"], 200);
        }

        return redirect()->back()->with('exito', 'Empleado dado de baja correctamente');
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
           
       if ($request->expectsJson()) {
                return response()->json([
                    "mensaje" => $resultado['mensaje'],
                    "data" => $resultado['data']
                ], $resultado['data'] ? 200 : 404);
            }
        
        if(!$resultado['data']){
            return redirect()->back()->with('error','No se contro un empleado con ese correo');
        }

           return redirect()->back()->with('usuarioEncontrado', $resultado['data']);
        } 
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],404);
        }
    }
}
