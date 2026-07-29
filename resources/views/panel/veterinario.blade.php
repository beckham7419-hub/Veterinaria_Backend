<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel del veterinario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #121212; }
    .table { color: #fff; }
    .badge-estado-agendada { background-color: #6c757d; }
    .badge-estado-confirmada { background-color: #0d6efd; }
    .badge-estado-en_consulta { background-color: #fd7e14; }
    .badge-estado-completada { background-color: #198754; }
    .badge-estado-cancelada { background-color: #dc3545; }
  </style>
</head>
<body>
  <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
    <div class="container-fluid">
      <span class="navbar-brand d-flex align-items-center gap-2">
        <img src="{{ asset('Imagenes/logo_de_la_veterinaria.jpg') }}" width="45" height="45" class="rounded-circle" alt="Logo">
        Bienvenido, <span id="nombre-usuario">Cargando...</span>
      </span>
      <button class="btn btn-outline-light btn-sm" id="btnLogout">Cerrar sesión</button>
    </div>
  </nav>

  <div class="container-fluid mt-4">
    <div id="alertArea"></div>
    <h2>Mi agenda</h2>

    <div class="row g-2 mb-2 align-items-end">
      <div class="col-auto">
        <label class="form-label small mb-0">Estado</label>
        <select id="filtroEstado" class="form-select">
          <option value="">Todos</option>
          <option value="agendada">Agendada</option>
          <option value="confirmada">Confirmada</option>
          <option value="en_consulta">En consulta</option>
          <option value="completada">Completada</option>
          <option value="cancelada">Cancelada</option>
        </select>
      </div>
      <div class="col-auto">
        <label class="form-label small mb-0">Rango</label>
        <select id="filtroRango" class="form-select">
          <option value="dia">Día</option>
          <option value="semana">Semana</option>
          <option value="todas">Sin filtro de fecha</option>
        </select>
      </div>
      <div class="col-auto">
        <label class="form-label small mb-0">Fecha</label>
        <input type="date" id="filtroFecha" class="form-control">
      </div>
      <div class="col-auto">
        <button class="btn btn-outline-light" id="btnFiltrar">Filtrar</button>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
          <tr><th>Folio</th><th>Fecha</th><th>Hora</th><th>Mascota</th><th>Motivo</th><th>Estado</th><th>Llegada</th><th>Acciones</th></tr>
        </thead>
        <tbody id="tablaCitas"></tbody>
      </table>
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

    function soloFecha(valor) {
      return valor ? String(valor).slice(0, 10) : '';
    }

    function soloHora(valor) {
      return valor ? String(valor).slice(0, 5) : '';
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

    function badgeEstado(estado) {
      const etiquetas = {
        agendada: 'Agendada',
        confirmada: 'Confirmada',
        en_consulta: 'En consulta',
        completada: 'Completada',
        cancelada: 'Cancelada',
      };
      return `<span class="badge badge-estado-${estado}">${etiquetas[estado] || estado}</span>`;
    }

    function rangoSemana(fechaStr) {
      const d = new Date(`${fechaStr}T00:00:00`);
      const dia = d.getDay();
      const diffLunes = dia === 0 ? -6 : 1 - dia;
      const lunes = new Date(d);
      lunes.setDate(d.getDate() + diffLunes);
      const domingo = new Date(lunes);
      domingo.setDate(lunes.getDate() + 6);
      const formatear = (dt) => dt.toISOString().slice(0, 10);
      return [formatear(lunes), formatear(domingo)];
    }

    let citasCache = {};

    async function fetchCitas() {
      const estado = document.getElementById('filtroEstado').value;
      const rango = document.getElementById('filtroRango').value;
      const fecha = document.getElementById('filtroFecha').value;

      const params = new URLSearchParams();
      if (estado) params.set('estado', estado);

      if (rango !== 'todas' && fecha) {
        if (rango === 'dia') {
          params.set('fecha_inicio', fecha);
          params.set('fecha_fin', fecha);
        } else {
          const [inicio, fin] = rangoSemana(fecha);
          params.set('fecha_inicio', inicio);
          params.set('fecha_fin', fin);
        }
      }

      try {
        const res = await apiFetch(`/mi-agenda?${params.toString()}`);
        renderCitas(res.data);
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    function renderCitas(citas) {
      citasCache = {};
      citas.forEach((c) => { citasCache[c.id] = c; });
      const tbody = document.getElementById('tablaCitas');
      tbody.innerHTML = citas.map((c) => {
        const mascotaNombre = c.mascota ? c.mascota.nombre : `#${c.mascota_id}`;
        let acciones = '';

        if (c.estado === 'agendada' || c.estado === 'confirmada') {
          acciones += `<button class="btn btn-sm btn-primary mb-1" data-accion="iniciar" data-id="${c.id}">Iniciar consulta</button> `;
        } else if (c.estado === 'en_consulta') {
          acciones += `<button class="btn btn-sm btn-success mb-1" data-accion="completar" data-id="${c.id}">Completar</button> `;
        }

        return `
        <tr>
          <td>${esc(c.numero_folio)}</td>
          <td>${soloFecha(c.fecha)}</td>
          <td>${soloHora(c.hora)}</td>
          <td>${esc(mascotaNombre)}</td>
          <td>${esc(c.motivo)}</td>
          <td>${badgeEstado(c.estado)}</td>
          <td>${c.hora_llegada ? 'Sí' : 'No'}</td>
          <td>${acciones}</td>
        </tr>
      `;
      }).join('');
    }

    document.getElementById('btnFiltrar').addEventListener('click', fetchCitas);

    document.getElementById('tablaCitas').addEventListener('click', (e) => {
      const boton = e.target.closest('button[data-accion]');
      if (!boton) return;
      const id = boton.dataset.id;

      const rutas = {
        iniciar: `/citas/${id}/iniciar-consulta`,
        completar: `/citas/${id}/completar`,
      };

      const mensajes = {
        iniciar: 'Consulta iniciada',
        completar: 'Cita completada',
      };

      apiFetch(rutas[boton.dataset.accion], { method: 'PUT' })
        .then(() => { mostrarAlerta(mensajes[boton.dataset.accion]); fetchCitas(); })
        .catch((err) => mostrarAlerta(mensajeError(err), 'danger'));
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

    document.addEventListener('DOMContentLoaded', () => {
      try {
        const payload = JSON.parse(atob(token.split('.')[1]));
        document.getElementById('nombre-usuario').innerText = payload.nombre_completo || 'Usuario';
      } catch (e) {
        document.getElementById('nombre-usuario').innerText = 'Usuario';
      }

      document.getElementById('filtroFecha').value = new Date().toISOString().slice(0, 10);
      fetchCitas();
    });
  </script>
</body>
</html>
