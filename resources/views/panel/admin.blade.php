<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel del admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
   body {
      background-color: #1a1a1a;
      color: #ffffff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* ---------- Navbar ---------- */
    .navbar-veterinaria {
      background-color: #242424;
      border-bottom: 2px solid #ff4d4d;
      box-shadow: 0 2px 12px rgba(255, 77, 77, 0.15);
    }

    .logo-container-nav {
      width: 48px;
      height: 48px;
      border: 2px solid #ff4d4d;
      border-radius: 10px;
      padding: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 8px rgba(255, 77, 77, 0.3);
    }

    .logo-container-nav img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
    }

    .navbar-brand-text {
      font-weight: 600;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      font-size: 0.95rem;
    }

    #btnLogout {
      border-color: #ff4d4d;
      color: #ff4d4d;
      font-weight: 600;
    }

    #btnLogout:hover {
      background-color: #ff4d4d;
      color: #ffffff;
    }

    /* ---------- Panel principal ---------- */
    .panel-card {
      background-color: #242424;
      border: 2px solid #ff4d4d;
      border-radius: 14px;
      padding: 25px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 15px rgba(255, 77, 77, 0.15);
    }

    /* ---------- Tabs ---------- */
    .nav-tabs { border-bottom: 1px solid #333333; }
    .nav-tabs .nav-link { color: #999999; border: none; font-weight: 500; }
    .nav-tabs .nav-link:hover { color: #ffffff; border-color: transparent; }
    .nav-tabs .nav-link.active {
      background-color: transparent;
      color: #ff4d4d;
      border: none;
      border-bottom: 2px solid #ff4d4d;
    }

    /* ---------- Tablas ---------- */
    .table { color: #ffffff; }
    .table > :not(caption) > * > * { background-color: transparent; color: #ffffff; border-bottom-color: #333333; }
    .table-dark thead { background-color: #1a1a1a; }
    .table-dark th { border-color: #333333; color: #ff4d4d; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }
    .table-striped > tbody > tr:nth-of-type(odd) > * { background-color: #262626; }
    .table-hover > tbody > tr:hover > * { background-color: #2f2020; }

    /* ---------- Formularios ---------- */
    .form-control, .form-select {
      background-color: #1a1a1a;
      border: 1px solid #333333;
      color: #ffffff;
      border-radius: 6px;
    }

    .form-control::placeholder { color: #777777; }

    .form-control:focus, .form-select:focus {
      background-color: #1a1a1a;
      color: #ffffff;
      border-color: #ff4d4d;
      box-shadow: 0 0 0 0.2rem rgba(255, 77, 77, 0.25);
    }

    .form-select option { background-color: #1a1a1a; color: #ffffff; }

    .form-label { color: #cccccc; }

    /* ---------- Botones ---------- */
    .btn-primary {
      background-color: #ff4d4d;
      border-color: #ff4d4d;
      font-weight: 600;
    }

    .btn-primary:hover, .btn-primary:focus {
      background-color: #e03b3b;
      border-color: #e03b3b;
    }

    .btn-outline-light:hover { color: #1a1a1a; }

    /* ---------- Modales ---------- */
    .modal-content-veterinaria {
      background-color: #242424;
      border: 2px solid #ff4d4d;
      border-radius: 14px;
      box-shadow: 0 0 20px rgba(255, 77, 77, 0.25);
    }

    .modal-content-veterinaria .modal-header,
    .modal-content-veterinaria .modal-footer {
      border-color: #333333;
    }

    /* ---------- Alertas ---------- */
    .alert { border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.1); }

    /* ---------- Badges de estado ---------- */
    .badge-estado-agendada { background-color: #6c757d; }
    .badge-estado-confirmada { background-color: #0d6efd; }
    .badge-estado-en_consulta { background-color: #fd7e14; }
    .badge-estado-completada { background-color: #198754; }
    .badge-estado-cancelada { background-color: #dc3545; }
  </style>
</head>
<body>
  <nav class="navbar navbar-veterinaria" data-bs-theme="dark">
    <div class="container-fluid">
      <span class="navbar-brand d-flex align-items-center gap-2">
        <span class="logo-container-nav">
        <img src="{{ asset('Imagenes/logo_veterinaria_transparente.png') }}" width="50" height="50" class="rounded-circle" alt="Logo">
        </span>
        Admin — <span id="nombre-usuario">Cargando...</span>
      </span>
      <button class="btn btn-outline-light btn-sm" id="btnLogout">Cerrar sesión</button>
    </div>
  </nav>

   <div class="container-fluid mt-4">
    <div id="alertArea"></div>

  <div class="panel-card">
    <ul class="nav nav-tabs">
      <li class="nav-item"><button class="nav-link active" id="tabBtnPersonal" data-bs-toggle="tab" data-bs-target="#tab-gestionar-personal" type="button">Gestionar personal</button></li>
      <li class="nav-item"><button class="nav-link" id="tabBtnInventario" data-bs-toggle="tab" data-bs-target="#tab-gestionar-inventario" type="button">Gestionar inventario</button></li>
      <li class="nav-item"><button class="nav-link" id="tabBtnReportes" data-bs-toggle="tab" data-bs-target="#tab-reportes" type="button">Gestionar reportes</button></li>
    </ul>

    <div class="tab-content mt-3">
      <div class="tab-pane fade show active" id="tab-gestionar-personal">
      <div class="d-flex gap-2 mb-3 flex-wrap">

     <input type="text" id="buscarEmpleado" class="form-control" style="max-width:320px" placeholder="Buscar empleado por su correo:">
     <button class="btn btn-outline-light" id="btnBuscarEmpleado">Buscar</button>
     <button class="btn btn-outline-secondary" id="btnLimpiarBusquedaEmpleado">Limpiar</button>
     <button type="button" class="btn btn-primary ms-auto" id="btnAgregarUsuario" data-bs-toggle="modal" data-bs-target="#modalUsuario">
      Agregar empleado
     </button>
      </div>
       <div class="table-responsive">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
              <tr><th>Nombre Completo</th><th>Correo</th><th>Rol</th><th>Estado</th><th>Acciones</th></tr>
            </thead>
            <tbody id="tablaUsuarios">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<!-- MODAL PARA CREAR / EDITAR EMPLEADO -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-content-veterinaria">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUsuarioTitulo">Agregar empleado</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="formUsuario">
        <div class="modal-body">
          <input type="hidden" id="usuario_id">
          <div class="mb-3">
            <label class="form-label">Nombre completo</label>
            <input type="text" id="usuario_nombre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" id="usuario_correo" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Rol</label>
            <select id="usuario_rol" class="form-select" required>
              <option value="veterinario">Veterinario</option>
              <option value="recepcionista">Recepcionista</option>
              <option value="administrador">Administrador</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" id="usuario_contrasena_label">Contraseña</label>
            <input type="password" id="usuario_contrasena" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL PARA VER DETALLES -->
<div class="modal fade" id="modalVerUsuario" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-content-veterinaria">
      <div class="modal-header">
        <h5 class="modal-title">Detalles del Empleado</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Nombre:</strong> <span id="ver_usuario_nombre"></span></p>
        <p><strong>Correo:</strong> <span id="ver_usuario_correo"></span></p>
        <p><strong>Rol:</strong> <span id="ver_usuario_rol"></span></p>
        <p><strong>Estado:</strong> <span id="ver_usuario_estado"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
   const token = localStorage.getItem('token_veterinaria');
    if (!token) {
      window.location.href = '/';
    }

    function esc(valor) {
      if (valor === null || valor === undefined) return '';
      const div = document.createElement('div');
      div.textContent = String(valor);
      return div.innerHTML;
    }

    async function apiFetch(path, options = {}) {
      const headers = Object.assign({ Accept: 'application/json' }, options.headers || {});
      if (options.body) headers['Content-Type'] = 'application/json';
      headers['Authorization'] = `Bearer ${token}`;

      const res = await fetch(`/api${path}`, Object.assign({}, options, { headers }));

      if (res.status === 401) {
        localStorage.removeItem('token_veterinaria');
        localStorage.removeItem('rol_usuario');
        window.location.href = '/';
        throw new Error('No autenticado');
      }

      const data = await res.json().catch(() => ({}));

      if (!res.ok) {
        const error = new Error(data.mensaje || 'Ocurrio un error');
        error.data = data;
        throw error;
      }

      return data;
    }

    function mensajeError(e) {
      if (e.data && e.data.errores) {
        return Object.values(e.data.errores).flat().join(' ');
      }
      return e.message;
    }

    function mostrarAlerta(mensaje, tipo = 'success') {
      const area = document.getElementById('alertArea');
      const div = document.createElement('div');
      div.className = `alert alert-${tipo} alert-dismissible fade show`;
      div.innerHTML = `${esc(mensaje)}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
      area.appendChild(div);
      setTimeout(() => div.remove(), 6000);
    }

    let usuariosCache = {};

    // 1. OBTENER EMPLEADOS / USUARIOS
    async function fetchEmpleados() {
      try {
        const res = await apiFetch('/usuarios');
        const lista = res.data ? res.data : res;
        renderEmpleados(lista);
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    // 2. RENDERIZAR TABLA CON BOTÓN DINÁMICO (Baja / Reactivar)
    function renderEmpleados(empleados) {
      usuariosCache = {};
      const tbody = document.getElementById('tablaUsuarios'); // Mantenemos tu id real de HTML
      
      if (!empleados || empleados.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5" class="text-center">No se encontraron empleados.</td></tr>`;
        return;
      }

      tbody.innerHTML = empleados.map((u) => {
        usuariosCache[u.id] = u;
        const esActivo = Boolean(u.activo);

        const botonEstado = esActivo 
          ? `<button class="btn btn-danger btn-sm mb-1" data-accion="baja" data-id="${u.id}">Dar de baja</button>`
          : `<button class="btn btn-success btn-sm mb-1" data-accion="reactivar" data-id="${u.id}">Reactivar</button>`;

        return `
          <tr>
            <td>${esc(u.nombre_completo)}</td>
            <td>${esc(u.correo)}</td>
            <td><span class="badge bg-info text-dark">${esc(u.rol ? u.rol.charAt(0).toUpperCase() + u.rol.slice(1) : '')}</span></td>
            <td><span class="badge ${esActivo ? 'bg-success' : 'bg-secondary'}">${esActivo ? 'Activo' : 'Inactivo'}</span></td>
            <td>
              <button class="btn btn-info btn-sm text-white mb-1" data-accion="ver" data-id="${u.id}">Ver</button>
              <button class="btn btn-warning btn-sm mb-1" data-accion="editar" data-id="${u.id}">Modificar</button>
              ${botonEstado}
            </td>
          </tr>
        `;
      }).join('');
    }

    // EVENTOS DE CARGA Y LOGOUT
    document.addEventListener('DOMContentLoaded', () => {
      try {
        const payload = JSON.parse(atob(token.split('.')[1]));
        document.getElementById('nombre-usuario').innerText = payload.nombre_completo || 'Usuario';
      } catch (e) {
        document.getElementById('nombre-usuario').innerText = 'Usuario';
      }

      fetchEmpleados();
    });

    document.getElementById('btnLogout').addEventListener('click', async () => {
      try {
        await apiFetch('/auth/usuarios/logout', { method: 'POST' });
      } catch (e) {}
      localStorage.removeItem('token_veterinaria');
      localStorage.removeItem('rol_usuario');
      window.location.href = '/';
    });

    // BUSCADOR LOCAL O POR API
    document.getElementById('btnBuscarEmpleado').addEventListener('click', async () => {
      const correo = document.getElementById('buscarEmpleado').value.trim();

      if (!correo) {
        mostrarAlerta('Ingresa un correo para buscar', 'warning');
        return;
      }

      try {
        const res = await apiFetch('/usuarios/buscar-correo', {
          method: 'POST',
          body: JSON.stringify({ correo: correo })
        });

        const usuarioEncontrado = res.usuario ? res.usuario.data : res.data;

        if (usuarioEncontrado) {
          renderEmpleados([usuarioEncontrado]); 
        } else {
          mostrarAlerta('No se encontró ningún usuario con ese correo', 'info');
        }
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
      }
    });

    document.getElementById('btnLimpiarBusquedaEmpleado').addEventListener('click', () => {
      document.getElementById('buscarEmpleado').value = '';
      fetchEmpleados(); 
    });

    // CAPTURA DE EVENTOS DE TABLA (VER, EDITAR, BAJA Y REACTIVAR)
    document.getElementById('tablaUsuarios').addEventListener('click', (e) => {
      const boton = e.target.closest('button[data-accion]');
      if (!boton) return;
      const id = boton.dataset.id;
      const accion = boton.dataset.accion;
      const usuario = usuariosCache[id];

      if (accion === 'ver' && usuario) {
        document.getElementById('ver_usuario_nombre').innerText = usuario.nombre_completo;
        document.getElementById('ver_usuario_correo').innerText = usuario.correo;
        document.getElementById('ver_usuario_rol').innerText = usuario.rol.charAt(0).toUpperCase() + usuario.rol.slice(1);
        document.getElementById('ver_usuario_estado').innerText = usuario.activo ? 'Activo' : 'Inactivo';
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalVerUsuario')).show();
      }

      if (accion === 'editar' && usuario) {
        document.getElementById('formUsuario').reset();
        document.getElementById('usuario_id').value = usuario.id;
        document.getElementById('usuario_nombre').value = usuario.nombre_completo;
        document.getElementById('usuario_correo').value = usuario.correo;
        document.getElementById('usuario_rol').value = usuario.rol;
        document.getElementById('modalUsuarioTitulo').innerText = 'Actualizar empleado';
        document.getElementById('usuario_contrasena_label').innerText = 'Nueva contraseña (dejar en blanco para no cambiar)';
        document.getElementById('usuario_contrasena').required = false;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalUsuario')).show();
      }

      if (accion === 'baja' && usuario) {
        if (confirm(`¿Dar de baja a ${usuario.nombre_completo}?`)) {
          apiFetch(`/usuarios/${id}`, { method: 'DELETE' })
            .then(() => { 
              mostrarAlerta('Empleado dado de baja correctamente'); 
              fetchEmpleados(); 
            })
            .catch((err) => mostrarAlerta(mensajeError(err), 'danger'));
        }
      }

      if (accion === 'reactivar') {
        if (confirm('¿Deseas reactivar a este empleado?')) {
          apiFetch(`/usuarios/${id}/reactivar`, { method: 'PUT' })
            .then(() => {
              mostrarAlerta('Empleado reactivado con éxito');
              fetchEmpleados(); 
            })
            .catch((err) => mostrarAlerta(mensajeError(err), 'danger'));
        }
      }
    });

    // CREAR Y EDITAR FORMULARIO
    document.getElementById('formUsuario').addEventListener('submit', async (e) => {
      e.preventDefault();
      const id = document.getElementById('usuario_id').value;
      const payload = {
        nombre_completo: document.getElementById('usuario_nombre').value,
        correo: document.getElementById('usuario_correo').value,
        rol: document.getElementById('usuario_rol').value,
      };
      const contrasena = document.getElementById('usuario_contrasena').value;
      if (contrasena) payload.contrasena = contrasena;

      try {
        if (id) {
          await apiFetch(`/usuarios/${id}`, { method: 'PUT', body: JSON.stringify(payload) });
          mostrarAlerta('Empleado actualizado correctamente');
        } else {
          await apiFetch('/usuarios', { method: 'POST', body: JSON.stringify(payload) });
          mostrarAlerta('Empleado registrado correctamente');
        }
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalUsuario')).hide();
        fetchEmpleados();
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
      }
    });

    document.getElementById('btnAgregarUsuario').addEventListener('click', () => {
      document.getElementById('formUsuario').reset();
      document.getElementById('usuario_id').value = '';
      document.getElementById('modalUsuarioTitulo').innerText = 'Agregar empleado';
      document.getElementById('usuario_contrasena_label').innerText = 'Contraseña';
      document.getElementById('usuario_contrasena').required = true;
    });
  </script>
</body>
</html>
