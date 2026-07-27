<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel del admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid">
      <img src="{{ asset('Imagenes/logo_de_la_veterinaria.jpg') }}" width="50" height="50" class="rounded-circle" alt="Logo">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Gestionar personal</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Gestionar inventario de medicamentos</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Más opciones
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Gestionar citas</a></li>
              <li><a class="dropdown-item" href="#">Gestionar clientes</a></li>
              <li><a class="dropdown-item" href="#">Gestionar mascotas</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <h1 class="text-center mt-4">¡Bienvenido <span id="nombre-usuario">Cargando...</span>!</h1>

  <div class="container mt-4">
    <h2>Gestionar personal</h2>
    @if(session('exito'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('exito') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
    <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">
      Agregar empleado 
    </button>

    <!--formulario de busqueda de un empleado-->
    <form action="{{route('buscarEmpleado')}}" method="GET" class="mb-4">
    <div class="row align-items-end">
            <div class="col-md-8">
                <label class="form-label">Buscar empleado por correo:</label>
                <input type="email" name="correo" class="form-control" placeholder="ejemplo@veterinaria.com" required value="{{ request('correo') }}">
            </div>
            <div class="col-md-4 mt-2 mt-md-0">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="{{ url()->current() }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </div>
    </form>
    <!-- Si se encuentra un empleado -->
    @if(session('usuarioEncontrado'))
    @php 
        $buscado = (object) session('usuarioEncontrado'); 
    @endphp
    
    <div class="card border-info mb-4 shadow-sm">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Empleado Encontrado</h5>
            <a href="{{ route('gestionPersonal') }}" class="btn-close btn-close-white" title="Cerrar resultado"></a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <p class="mb-1"><strong>Nombre Completo:</strong> {{ $buscado->nombre_completo }}</p>
                    <p class="mb-1"><strong>Correo Electrónico:</strong> {{ $buscado->correo }}</p>
                    <p class="mb-1">
                        <strong>Rol:</strong> 
                        <span class="badge bg-info text-dark">{{ ucfirst($buscado->rol) }}</span>
                    </p>
                    <p class="mb-1">
                        <strong>Estado:</strong> 
                        @if(!empty($buscado->activo))
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inactivo</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif
    <!-- Modal Agregar Empleado -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalAgregarLabel">Agregar empleado</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="post" action="{{ url('agregarEmpleado') }}">
            @csrf
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Nombre completo:</label>
                <input type="text" name="nombre_completo" class="form-control" placeholder="Nombre completo del empleado" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Correo electrónico:</label>
                <input type="email" name="correo" class="form-control" placeholder="Correo del empleado" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Contraseña:</label>
                <input type="password" name="contrasena" class="form-control" placeholder="Contraseña del empleado" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Rol:</label>
                <select class="form-select" name="rol" required>
                  <option value="" disabled selected>Selecciona el rol del empleado</option>
                  <option value="veterinario">Veterinario</option>
                  <option value="recepcionista">Recepcionista</option>
                  <option value="administrador">Administrador</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Tabla de Usuarios -->
    <table class="table table-striped table-hover mt-3">
      <thead class="table-dark">
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Nombre</th>
          <th scope="col">Correo</th>
          <th scope="col">Rol</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
        @php $user = (object) $user; @endphp
          <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->nombre_completo }}</td>
            <td>{{ $user->correo }}</td>
            <td><span class="badge bg-info text-dark">{{ ucfirst($user->rol) }}</span></td>
            <td>

<button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#ver-{{ $user->id }}">
    Ver
</button>

              <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#actualizar-{{ $user->id }}">
                Actualizar
              </button>
              <!--Boton de eliminar-->
             @if($user->id != 1 && $user->id != auth('usuarios')->id())
    <form action="{{ url('eliminarEmpleado', [$user->id]) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">
            Eliminar
        </button>
    </form>
@endif
              
              
<!-- Modal Ver Empleado -->
<div class="modal fade" id="ver-{{ $user->id }}" tabindex="-1" aria-labelledby="verLabel-{{ $user->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="verLabel-{{ $user->id }}">Detalles del Empleado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-start">
        <p><strong>Nombre:</strong> {{ $user->nombre_completo }}</p>
        <p><strong>Correo:</strong> {{ $user->correo }}</p>
        <p><strong>Rol:</strong> <span class="badge bg-info text-dark">{{ ucfirst($user->rol) }}</span></p>
        <p><strong>Estado:</strong> {{ $user->activo ? 'Activo' : 'Inactivo' }}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
              <!-- Modal Actualizar -->
              <div class="modal fade" id="actualizar-{{ $user->id }}" tabindex="-1" aria-labelledby="actualizarLabel-{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="actualizarLabel-{{ $user->id }}">Actualizar Empleado</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="{{ url('actualizarEmpleado', [$user->id]) }}">
                      @csrf
                      @method('PUT')
                      <div class="modal-body text-start">
                        <div class="mb-3">
                          <label class="form-label">Nombre del empleado</label>
                          <input type="text" name="nombre_completo" class="form-control" value="{{ $user->nombre_completo }}" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Correo electrónico</label>
                          <input type="email" name="correo" class="form-control" value="{{ $user->correo }}" required>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Contraseña (Dejar en blanco para no cambiar)</label>
                          <input type="password" name="contrasena" class="form-control" placeholder="Nueva contraseña opcional">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Rol</label>
                          <select class="form-select" name="rol" required>
                            <option value="veterinario" {{ $user->rol == 'veterinario' ? 'selected' : '' }}>Veterinario</option>
                            <option value="recepcionista" {{ $user->rol == 'recepcionista' ? 'selected' : '' }}>Recepcionista</option>
                            <option value="administrador" {{ $user->rol == 'administrador' ? 'selected' : '' }}>Administrador</option>
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div> 
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const token = localStorage.getItem('token_veterinaria'); 

      if (token) {
        try {
          const payloadBase64 = token.split('.')[1];
          const payloadDecoded = JSON.parse(atob(payloadBase64));

          if (payloadDecoded.nombre_completo) {
            document.getElementById('nombre-usuario').innerText = payloadDecoded.nombre_completo;
          }
        } catch (e) {
          console.error("Error al decodificar el token:", e);
          document.getElementById('nombre-usuario').innerText = "Usuario";
        }
      } else {
        document.getElementById('nombre-usuario').innerText = "Invitado";
      }
    });
  </script>
</body>
</html>
