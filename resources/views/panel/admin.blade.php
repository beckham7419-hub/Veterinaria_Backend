<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel del admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #121212; }
    .table { color: #fff; }
  </style>
</head>
<body>
  <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid">
      <span class="navbar-brand d-flex align-items-center gap-2">
        <img src="{{ asset('Imagenes/logo_de_la_veterinaria.jpg') }}" width="50" height="50" class="rounded-circle" alt="Logo">
        Admin — <span id="nombre-usuario">Cargando...</span>
      </span>
      <button class="btn btn-outline-light btn-sm" id="btnLogout">Cerrar sesión</button>
    </div>
  </nav>

  <div class="container-fluid mt-4">
    <div id="alertArea"></div>

    <h2>Gestionar personal</h2>

    <button type="button" class="btn btn-primary my-3" id="btnAgregarUsuario" data-bs-toggle="modal" data-bs-target="#modalUsuario">
      Agregar empleado
    </button>

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Nombre</th>
            <th scope="col">Correo</th>
            <th scope="col">Rol</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody id="tablaUsuarios"></tbody>
      </table>
    </div>
  </div>

  <!-- Modal Agregar/Actualizar Empleado -->
  <div class="modal fade" id="modalUsuario" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUsuarioTitulo">Agregar empleado</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form id="formUsuario">
          <div class="modal-body">
            <input type="hidden" id="usuario_id">
            <div class="mb-3">
              <label class="form-label">Nombre completo</label>
              <input required class="form-control" id="usuario_nombre" maxlength="150">
            </div>
            <div class="mb-3">
              <label class="form-label">Correo electrónico</label>
              <input required type="email" class="form-control" id="usuario_correo" maxlength="150">
            </div>
            <div class="mb-3">
              <label class="form-label" id="usuario_contrasena_label">Contraseña</label>
              <input type="password" class="form-control" id="usuario_contrasena" minlength="8">
            </div>
            <div class="mb-3">
              <label class="form-label">Rol</label>
              <select class="form-select" id="usuario_rol" required>
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

  <!-- Modal Ver Empleado -->
  <div class="modal fade" id="modalVerUsuario" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title">Detalles del empleado</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-start">
          <p><strong>ID:</strong> <span id="ver_usuario_id"></span></p>
          <p><strong>Nombre:</strong> <span id="ver_usuario_nombre"></span></p>
          <p><strong>Correo:</strong> <span id="ver_usuario_correo"></span></p>
          <p><strong>Rol:</strong> <span id="ver_usuario_rol" class="badge bg-info text-dark"></span></p>
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

    document.addEventListener('DOMContentLoaded', () => {
      try {
        const payload = JSON.parse(atob(token.split('.')[1]));
        document.getElementById('nombre-usuario').innerText = payload.nombre_completo || 'Usuario';
      } catch (e) {
        document.getElementById('nombre-usuario').innerText = 'Usuario';
      }

      fetchUsuarios();
    });

    document.getElementById('btnLogout').addEventListener('click', async () => {
      try {
        await apiFetch('/auth/usuarios/logout', { method: 'POST' });
      } catch (e) {
        // continua con el cierre de sesion local aunque falle la peticion
      }
      localStorage.removeItem('token_veterinaria');
      localStorage.removeItem('rol_usuario');
      window.location.href = '/';
    });

    // ---------- USUARIOS ----------
    let usuariosCache = {};

    async function fetchUsuarios() {
      try {
        const res = await apiFetch('/usuarios');
        renderUsuarios(res.data);
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    function renderUsuarios(usuarios) {
      usuariosCache = {};
      usuarios.forEach((u) => { usuariosCache[u.id] = u; });
      const tbody = document.getElementById('tablaUsuarios');
      tbody.innerHTML = usuarios.map((u) => `
        <tr>
          <td>${u.id}</td>
          <td>${esc(u.nombre_completo)}</td>
          <td>${esc(u.correo)}</td>
          <td><span class="badge bg-info text-dark">${esc(u.rol.charAt(0).toUpperCase() + u.rol.slice(1))}</span></td>
          <td>
            <button class="btn btn-info btn-sm text-white mb-1" data-accion="ver" data-id="${u.id}">Ver</button>
            <button class="btn btn-warning btn-sm mb-1" data-accion="editar" data-id="${u.id}">Actualizar</button>
            <button class="btn btn-danger btn-sm mb-1" data-accion="baja" data-id="${u.id}">Eliminar</button>
          </td>
        </tr>
      `).join('');
    }

    document.getElementById('btnAgregarUsuario').addEventListener('click', () => {
      document.getElementById('formUsuario').reset();
      document.getElementById('usuario_id').value = '';
      document.getElementById('modalUsuarioTitulo').innerText = 'Agregar empleado';
      document.getElementById('usuario_contrasena_label').innerText = 'Contraseña';
      document.getElementById('usuario_contrasena').required = true;
    });

    document.getElementById('tablaUsuarios').addEventListener('click', (e) => {
      const boton = e.target.closest('button[data-accion]');
      if (!boton) return;
      const id = boton.dataset.id;
      const usuario = usuariosCache[id];

      if (boton.dataset.accion === 'ver') {
        document.getElementById('ver_usuario_id').innerText = usuario.id;
        document.getElementById('ver_usuario_nombre').innerText = usuario.nombre_completo;
        document.getElementById('ver_usuario_correo').innerText = usuario.correo;
        document.getElementById('ver_usuario_rol').innerText = usuario.rol.charAt(0).toUpperCase() + usuario.rol.slice(1);
        document.getElementById('ver_usuario_estado').innerText = usuario.activo ? 'Activo' : 'Inactivo';
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalVerUsuario')).show();
      }

      if (boton.dataset.accion === 'editar') {
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

      if (boton.dataset.accion === 'baja') {
        if (confirm(`¿Dar de baja a ${usuario.nombre_completo}?`)) {
          apiFetch(`/usuarios/${id}`, { method: 'DELETE' })
            .then(() => { mostrarAlerta('Empleado dado de baja correctamente'); fetchUsuarios(); })
            .catch((err) => mostrarAlerta(mensajeError(err), 'danger'));
        }
      }
    });

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
        fetchUsuarios();
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
      }
    });
  </script>
</body>
</html>
