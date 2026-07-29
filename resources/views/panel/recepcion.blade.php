<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de recepción</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #121212; }
    .table { color: #fff; }
    .nav-tabs .nav-link { color: #ccc; }
    .nav-tabs .nav-link.active { background-color: #242424; color: #fff; border-color: #444 #444 #242424; }
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
        Recepción — <span id="nombre-usuario">Cargando...</span>
      </span>
      <button class="btn btn-outline-light btn-sm" id="btnLogout">Cerrar sesión</button>
    </div>
  </nav>

  <div class="container-fluid mt-4">
    <div id="alertArea"></div>

    <ul class="nav nav-tabs">
      <li class="nav-item"><button class="nav-link active" id="tabBtnDuenos" data-bs-toggle="tab" data-bs-target="#tab-duenos" type="button">Dueños</button></li>
      <li class="nav-item"><button class="nav-link" id="tabBtnMascotas" data-bs-toggle="tab" data-bs-target="#tab-mascotas" type="button">Mascotas</button></li>
      <li class="nav-item"><button class="nav-link" id="tabBtnCitas" data-bs-toggle="tab" data-bs-target="#tab-citas" type="button">Citas</button></li>
    </ul>

    <div class="tab-content mt-3">
      <div class="tab-pane fade show active" id="tab-duenos">
        <div class="d-flex gap-2 mb-3 flex-wrap">
          <input type="text" id="buscarDueno" class="form-control" style="max-width:320px" placeholder="Buscar por nombre, correo o teléfono">
          <button class="btn btn-outline-light" id="btnBuscarDueno">Buscar</button>
          <button class="btn btn-outline-secondary" id="btnLimpiarBusquedaDueno">Limpiar</button>
          <button class="btn btn-primary ms-auto" id="btnAgregarDueno" data-bs-toggle="modal" data-bs-target="#modalDueno">Agregar dueño</button>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
              <tr><th>Id</th><th>Nombre</th><th>Teléfono</th><th>Correo</th><th>Dirección</th><th>Acciones</th></tr>
            </thead>
            <tbody id="tablaDuenos"></tbody>
          </table>
        </div>
      </div>

      <div class="tab-pane fade" id="tab-mascotas">
        <div class="d-flex gap-2 mb-3 flex-wrap">
          <input type="text" id="buscarMascota" class="form-control" style="max-width:320px" placeholder="Buscar por nombre, especie o expediente">
          <button class="btn btn-outline-light" id="btnBuscarMascota">Buscar</button>
          <select id="filtroDuenoMascota" class="form-select" style="max-width:280px">
            <option value="">Todos los dueños</option>
          </select>
          <button class="btn btn-outline-secondary" id="btnLimpiarBusquedaMascota">Limpiar</button>
          <button class="btn btn-primary ms-auto" id="btnAgregarMascota" data-bs-toggle="modal" data-bs-target="#modalMascota">Agregar mascota</button>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
              <tr><th>Expediente</th><th>Nombre</th><th>Especie</th><th>Raza</th><th>Sexo</th><th>Nacimiento</th><th>Color</th><th>Dueño</th><th>Acciones</th></tr>
            </thead>
            <tbody id="tablaMascotas"></tbody>
          </table>
        </div>
      </div>

      <div class="tab-pane fade" id="tab-citas">
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
            <label class="form-label small mb-0">Veterinario</label>
            <select id="filtroVeterinario" class="form-select">
              <option value="">Todos</option>
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
            <button class="btn btn-outline-light" id="btnFiltrarCitas">Filtrar</button>
          </div>
          <div class="col-auto ms-auto">
            <button class="btn btn-primary" id="btnAgendarCita" data-bs-toggle="modal" data-bs-target="#modalCita">Agendar cita</button>
          </div>
        </div>
        <div id="filtroMascotaInfo" class="mb-2"></div>
        <div class="table-responsive">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
              <tr><th>Folio</th><th>Fecha</th><th>Hora</th><th>Mascota</th><th>Veterinario</th><th>Motivo</th><th>Estado</th><th>Llegada</th><th>Acciones</th></tr>
            </thead>
            <tbody id="tablaCitas"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalDueno" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="modalDuenoTitulo">Agregar dueño</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form id="formDueno">
          <div class="modal-body">
            <input type="hidden" id="dueno_id">
            <div class="mb-3"><label class="form-label">Nombre completo</label><input required class="form-control" id="dueno_nombre" maxlength="150"></div>
            <div class="mb-3"><label class="form-label">Teléfono</label><input required class="form-control" id="dueno_telefono" maxlength="10" pattern="\d{10}" inputmode="numeric"></div>
            <div class="mb-3"><label class="form-label">Correo</label><input required type="email" class="form-control" id="dueno_correo" maxlength="150"></div>
            <div class="mb-3"><label class="form-label">Dirección</label><input class="form-control" id="dueno_direccion" maxlength="255"></div>
            <div class="mb-3">
              <label class="form-label" id="dueno_contrasena_label">Contraseña</label>
              <input type="password" class="form-control" id="dueno_contrasena" minlength="8">
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

  <div class="modal fade" id="modalMascota" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="modalMascotaTitulo">Agregar mascota</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form id="formMascota">
          <div class="modal-body">
            <input type="hidden" id="mascota_id">
            <div class="mb-3">
              <label class="form-label">Dueño</label>
              <select required class="form-select" id="mascota_dueno_id"></select>
            </div>
            <div class="mb-3"><label class="form-label">Nombre</label><input required class="form-control" id="mascota_nombre" maxlength="100"></div>
            <div class="mb-3"><label class="form-label">Especie</label><input required class="form-control" id="mascota_especie" maxlength="50" placeholder="Perro, gato, ave..."></div>
            <div class="mb-3"><label class="form-label">Raza</label><input class="form-control" id="mascota_raza" maxlength="50"></div>
            <div class="mb-3">
              <label class="form-label">Sexo</label>
              <select required class="form-select" id="mascota_sexo">
                <option value="macho">Macho</option>
                <option value="hembra">Hembra</option>
              </select>
            </div>
            <div class="mb-3"><label class="form-label">Fecha de nacimiento</label><input type="date" class="form-control" id="mascota_fecha_nacimiento"></div>
            <div class="mb-3"><label class="form-label">Color</label><input class="form-control" id="mascota_color" maxlength="50"></div>
            <div class="mb-3"><label class="form-label">URL de la foto</label><input class="form-control" id="mascota_foto_url" maxlength="255" placeholder="https://..."></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalCita" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title">Agendar cita</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form id="formCita">
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Buscar mascota (nombre, especie o expediente)</label>
              <div class="d-flex gap-2">
                <input type="text" id="cita_buscar_mascota" class="form-control">
                <button type="button" class="btn btn-outline-light" id="btnBuscarMascotaCita">Buscar</button>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Mascota</label>
              <select required class="form-select" id="cita_mascota_id"></select>
            </div>
            <div class="mb-3">
              <label class="form-label">Veterinario</label>
              <select required class="form-select" id="cita_veterinario_id"></select>
            </div>
            <div class="mb-3"><label class="form-label">Motivo de consulta</label><input required class="form-control" id="cita_motivo" maxlength="255"></div>
            <div class="mb-3"><label class="form-label">Fecha</label><input required type="date" class="form-control" id="cita_fecha"></div>
            <div class="mb-3"><label class="form-label">Hora</label><input required type="time" class="form-control" id="cita_hora"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Agendar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalReprogramar" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title">Reprogramar cita</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form id="formReprogramar">
          <div class="modal-body">
            <input type="hidden" id="reprogramar_cita_id">
            <div class="mb-3">
              <label class="form-label">Veterinario</label>
              <select required class="form-select" id="reprogramar_veterinario_id"></select>
            </div>
            <div class="mb-3"><label class="form-label">Fecha</label><input required type="date" class="form-control" id="reprogramar_fecha"></div>
            <div class="mb-3"><label class="form-label">Hora</label><input required type="time" class="form-control" id="reprogramar_hora"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Reprogramar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalCancelar" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title">Cancelar cita</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form id="formCancelar">
          <div class="modal-body">
            <input type="hidden" id="cancelar_cita_id">
            <div class="mb-3">
              <label class="form-label">Motivo de la cancelación</label>
              <textarea required class="form-control" id="cancelar_motivo" maxlength="255"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-danger">Cancelar cita</button>
          </div>
        </form>
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

    function activarTab(idBoton) {
      bootstrap.Tab.getOrCreateInstance(document.getElementById(idBoton)).show();
    }

    document.addEventListener('DOMContentLoaded', () => {
      try {
        const payload = JSON.parse(atob(token.split('.')[1]));
        document.getElementById('nombre-usuario').innerText = payload.nombre_completo || 'Usuario';
      } catch (e) {
        document.getElementById('nombre-usuario').innerText = 'Usuario';
      }

      cargarDuenosCache();
      cargarVeterinarios();
      fetchDuenos();

      document.getElementById('filtroFecha').value = new Date().toISOString().slice(0, 10);
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

    // ---------- DUEÑOS ----------
    let duenosCache = {};

    async function cargarDuenosCache() {
      try {
        const res = await apiFetch('/duenos');
        duenosCache = {};
        res.data.forEach((d) => { duenosCache[d.id] = d; });

        const selectMascota = document.getElementById('mascota_dueno_id');
        const selectFiltro = document.getElementById('filtroDuenoMascota');
        selectMascota.innerHTML = '';
        selectFiltro.innerHTML = '<option value="">Todos los dueños</option>';

        res.data.forEach((d) => {
          selectMascota.innerHTML += `<option value="${d.id}">${esc(d.nombre_completo)}</option>`;
          selectFiltro.innerHTML += `<option value="${d.id}">${esc(d.nombre_completo)}</option>`;
        });
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    async function fetchDuenos() {
      const buscar = document.getElementById('buscarDueno').value.trim();
      try {
        const params = buscar ? `?buscar=${encodeURIComponent(buscar)}` : '';
        const res = await apiFetch(`/duenos${params}`);
        renderDuenos(res.data);
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    function renderDuenos(duenos) {
      duenos.forEach((d) => { duenosCache[d.id] = d; });
      const tbody = document.getElementById('tablaDuenos');
      tbody.innerHTML = duenos.map((d) => `
        <tr>
          <td>${d.id}</td>
          <td>${esc(d.nombre_completo)}</td>
          <td>${esc(d.telefono)}</td>
          <td>${esc(d.correo)}</td>
          <td>${esc(d.direccion || '')}</td>
          <td>
            <button class="btn btn-sm btn-outline-light mb-1" data-accion="ver-mascotas" data-id="${d.id}">Mascotas</button>
            <button class="btn btn-sm btn-warning mb-1" data-accion="editar" data-id="${d.id}">Editar</button>
            <button class="btn btn-sm btn-danger mb-1" data-accion="baja" data-id="${d.id}">Baja</button>
          </td>
        </tr>
      `).join('');
    }

    document.getElementById('btnBuscarDueno').addEventListener('click', fetchDuenos);
    document.getElementById('buscarDueno').addEventListener('keydown', (e) => { if (e.key === 'Enter') { e.preventDefault(); fetchDuenos(); } });
    document.getElementById('btnLimpiarBusquedaDueno').addEventListener('click', () => {
      document.getElementById('buscarDueno').value = '';
      fetchDuenos();
    });

    document.getElementById('btnAgregarDueno').addEventListener('click', () => {
      document.getElementById('formDueno').reset();
      document.getElementById('dueno_id').value = '';
      document.getElementById('modalDuenoTitulo').innerText = 'Agregar dueño';
      document.getElementById('dueno_contrasena_label').innerText = 'Contraseña';
      document.getElementById('dueno_contrasena').required = true;
    });

    document.getElementById('tablaDuenos').addEventListener('click', (e) => {
      const boton = e.target.closest('button[data-accion]');
      if (!boton) return;
      const id = boton.dataset.id;
      const dueno = duenosCache[id];

      if (boton.dataset.accion === 'editar') {
        document.getElementById('formDueno').reset();
        document.getElementById('dueno_id').value = dueno.id;
        document.getElementById('dueno_nombre').value = dueno.nombre_completo;
        document.getElementById('dueno_telefono').value = dueno.telefono;
        document.getElementById('dueno_correo').value = dueno.correo;
        document.getElementById('dueno_direccion').value = dueno.direccion || '';
        document.getElementById('modalDuenoTitulo').innerText = 'Editar dueño';
        document.getElementById('dueno_contrasena_label').innerText = 'Nueva contraseña (dejar en blanco para no cambiar)';
        document.getElementById('dueno_contrasena').required = false;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDueno')).show();
      }

      if (boton.dataset.accion === 'baja') {
        if (confirm(`¿Dar de baja a ${dueno.nombre_completo}?`)) {
          apiFetch(`/duenos/${id}`, { method: 'DELETE' })
            .then(() => { mostrarAlerta('Dueño dado de baja'); fetchDuenos(); cargarDuenosCache(); })
            .catch((err) => mostrarAlerta(mensajeError(err), 'danger'));
        }
      }

      if (boton.dataset.accion === 'ver-mascotas') {
        activarTab('tabBtnMascotas');
        document.getElementById('filtroDuenoMascota').value = id;
        fetchMascotas();
      }
    });

    document.getElementById('formDueno').addEventListener('submit', async (e) => {
      e.preventDefault();
      const id = document.getElementById('dueno_id').value;
      const payload = {
        nombre_completo: document.getElementById('dueno_nombre').value,
        telefono: document.getElementById('dueno_telefono').value,
        correo: document.getElementById('dueno_correo').value,
        direccion: document.getElementById('dueno_direccion').value,
      };
      const contrasena = document.getElementById('dueno_contrasena').value;
      if (contrasena) payload.contrasena = contrasena;

      try {
        if (id) {
          await apiFetch(`/duenos/${id}`, { method: 'PUT', body: JSON.stringify(payload) });
          mostrarAlerta('Dueño actualizado');
        } else {
          await apiFetch('/duenos', { method: 'POST', body: JSON.stringify(payload) });
          mostrarAlerta('Dueño registrado');
        }
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDueno')).hide();
        fetchDuenos();
        cargarDuenosCache();
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
      }
    });

    // ---------- MASCOTAS ----------
    let mascotasCache = {};

    async function fetchMascotas() {
      const buscar = document.getElementById('buscarMascota').value.trim();
      const duenoId = document.getElementById('filtroDuenoMascota').value;
      const params = new URLSearchParams();
      if (buscar) params.set('buscar', buscar);
      if (duenoId) params.set('dueno_id', duenoId);

      try {
        const res = await apiFetch(`/mascotas?${params.toString()}`);
        renderMascotas(res.data);
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    function renderMascotas(mascotas) {
      mascotasCache = {};
      mascotas.forEach((m) => { mascotasCache[m.id] = m; });
      const tbody = document.getElementById('tablaMascotas');
      tbody.innerHTML = mascotas.map((m) => {
        const dueno = duenosCache[m.dueno_id];
        return `
        <tr>
          <td>${esc(m.numero_expediente)}</td>
          <td>${esc(m.nombre)}</td>
          <td>${esc(m.especie)}</td>
          <td>${esc(m.raza || '')}</td>
          <td>${esc(m.sexo)}</td>
          <td>${soloFecha(m.fecha_nacimiento)}</td>
          <td>${esc(m.color || '')}</td>
          <td>${esc(dueno ? dueno.nombre_completo : m.dueno_id)}</td>
          <td>
            <button class="btn btn-sm btn-outline-light mb-1" data-accion="historial" data-id="${m.id}">Historial</button>
            <button class="btn btn-sm btn-warning mb-1" data-accion="editar" data-id="${m.id}">Editar</button>
            <button class="btn btn-sm btn-danger mb-1" data-accion="baja" data-id="${m.id}">Baja</button>
          </td>
        </tr>
      `;
      }).join('');
    }

    document.getElementById('btnBuscarMascota').addEventListener('click', fetchMascotas);
    document.getElementById('buscarMascota').addEventListener('keydown', (e) => { if (e.key === 'Enter') { e.preventDefault(); fetchMascotas(); } });
    document.getElementById('filtroDuenoMascota').addEventListener('change', fetchMascotas);
    document.getElementById('btnLimpiarBusquedaMascota').addEventListener('click', () => {
      document.getElementById('buscarMascota').value = '';
      document.getElementById('filtroDuenoMascota').value = '';
      fetchMascotas();
    });

    document.getElementById('btnAgregarMascota').addEventListener('click', () => {
      document.getElementById('formMascota').reset();
      document.getElementById('mascota_id').value = '';
      document.getElementById('modalMascotaTitulo').innerText = 'Agregar mascota';
    });

    document.getElementById('tablaMascotas').addEventListener('click', (e) => {
      const boton = e.target.closest('button[data-accion]');
      if (!boton) return;
      const id = boton.dataset.id;
      const mascota = mascotasCache[id];

      if (boton.dataset.accion === 'editar') {
        document.getElementById('formMascota').reset();
        document.getElementById('mascota_id').value = mascota.id;
        document.getElementById('mascota_dueno_id').value = mascota.dueno_id;
        document.getElementById('mascota_nombre').value = mascota.nombre;
        document.getElementById('mascota_especie').value = mascota.especie;
        document.getElementById('mascota_raza').value = mascota.raza || '';
        document.getElementById('mascota_sexo').value = mascota.sexo;
        document.getElementById('mascota_fecha_nacimiento').value = soloFecha(mascota.fecha_nacimiento);
        document.getElementById('mascota_color').value = mascota.color || '';
        document.getElementById('mascota_foto_url').value = mascota.foto_url || '';
        document.getElementById('modalMascotaTitulo').innerText = `Editar mascota — ${mascota.numero_expediente}`;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalMascota')).show();
      }

      if (boton.dataset.accion === 'baja') {
        if (confirm(`¿Dar de baja a ${mascota.nombre}?`)) {
          apiFetch(`/mascotas/${id}`, { method: 'DELETE' })
            .then(() => { mostrarAlerta('Mascota dada de baja'); fetchMascotas(); })
            .catch((err) => mostrarAlerta(mensajeError(err), 'danger'));
        }
      }

      if (boton.dataset.accion === 'historial') {
        irAHistorialMascota(mascota.id, mascota.nombre);
      }
    });

    document.getElementById('formMascota').addEventListener('submit', async (e) => {
      e.preventDefault();
      const id = document.getElementById('mascota_id').value;
      const payload = {
        dueno_id: document.getElementById('mascota_dueno_id').value,
        nombre: document.getElementById('mascota_nombre').value,
        especie: document.getElementById('mascota_especie').value,
        raza: document.getElementById('mascota_raza').value,
        sexo: document.getElementById('mascota_sexo').value,
        fecha_nacimiento: document.getElementById('mascota_fecha_nacimiento').value || null,
        color: document.getElementById('mascota_color').value,
        foto_url: document.getElementById('mascota_foto_url').value,
      };

      try {
        if (id) {
          await apiFetch(`/mascotas/${id}`, { method: 'PUT', body: JSON.stringify(payload) });
          mostrarAlerta('Mascota actualizada');
        } else {
          await apiFetch('/mascotas', { method: 'POST', body: JSON.stringify(payload) });
          mostrarAlerta('Mascota registrada');
        }
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalMascota')).hide();
        fetchMascotas();
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
      }
    });

    // ---------- CITAS ----------
    let citasCache = {};
    let mascotaHistorialId = null;

    async function cargarVeterinarios() {
      try {
        const res = await apiFetch('/veterinarios');
        const selects = ['filtroVeterinario', 'cita_veterinario_id', 'reprogramar_veterinario_id'];
        selects.forEach((idSelect) => {
          const select = document.getElementById(idSelect);
          const placeholder = idSelect === 'filtroVeterinario' ? '<option value="">Todos</option>' : '<option value="">Selecciona un veterinario</option>';
          select.innerHTML = placeholder;
          res.data.forEach((v) => {
            select.innerHTML += `<option value="${v.id}">${esc(v.nombre_completo)}</option>`;
          });
        });
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
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

    function irAHistorialMascota(mascotaId, mascotaNombre) {
      mascotaHistorialId = mascotaId;
      document.getElementById('filtroMascotaInfo').innerHTML = `
        <span class="badge bg-info text-dark">Historial de ${esc(mascotaNombre)}</span>
        <button class="btn btn-sm btn-link" id="btnQuitarFiltroMascota">Quitar filtro</button>
      `;
      document.getElementById('btnQuitarFiltroMascota').addEventListener('click', () => {
        mascotaHistorialId = null;
        document.getElementById('filtroMascotaInfo').innerHTML = '';
        fetchCitas();
      });
      activarTab('tabBtnCitas');
      fetchCitas();
    }

    function mostrarFechaEnCalendario(fecha) {
      mascotaHistorialId = null;
      document.getElementById('filtroMascotaInfo').innerHTML = '';
      document.getElementById('filtroEstado').value = '';
      document.getElementById('filtroRango').value = 'dia';
      document.getElementById('filtroFecha').value = fecha;
      fetchCitas();
    }

    async function fetchCitas() {
      const estado = document.getElementById('filtroEstado').value;
      const veterinarioId = document.getElementById('filtroVeterinario').value;
      const rango = document.getElementById('filtroRango').value;
      const fecha = document.getElementById('filtroFecha').value;

      const params = new URLSearchParams();
      if (estado) params.set('estado', estado);
      if (veterinarioId) params.set('veterinario_id', veterinarioId);
      if (mascotaHistorialId) params.set('mascota_id', mascotaHistorialId);

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
        const res = await apiFetch(`/citas?${params.toString()}`);
        renderCitas(res.data);
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
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

    function renderCitas(citas) {
      citasCache = {};
      citas.forEach((c) => { citasCache[c.id] = c; });
      const tbody = document.getElementById('tablaCitas');
      tbody.innerHTML = citas.map((c) => {
        const mascotaNombre = c.mascota ? c.mascota.nombre : `#${c.mascota_id}`;
        const vetNombre = c.veterinario ? c.veterinario.nombre_completo : `#${c.veterinario_id}`;
        let acciones = '';

        if (c.estado === 'agendada' || c.estado === 'confirmada') {
          if (c.estado === 'agendada') {
            acciones += `<button class="btn btn-sm btn-info text-white mb-1" data-accion="confirmar" data-id="${c.id}">Confirmar</button> `;
          }
          if (!c.hora_llegada) {
            acciones += `<button class="btn btn-sm btn-secondary mb-1" data-accion="checkin" data-id="${c.id}">Check-in</button> `;
          }
          acciones += `<button class="btn btn-sm btn-primary mb-1" data-accion="iniciar" data-id="${c.id}">Iniciar consulta</button> `;
          acciones += `<button class="btn btn-sm btn-warning mb-1" data-accion="reprogramar" data-id="${c.id}">Reprogramar</button> `;
          acciones += `<button class="btn btn-sm btn-danger mb-1" data-accion="cancelar" data-id="${c.id}">Cancelar</button> `;
        } else if (c.estado === 'en_consulta') {
          acciones += `<button class="btn btn-sm btn-success mb-1" data-accion="completar" data-id="${c.id}">Completar</button> `;
        }

        acciones += `<button class="btn btn-sm btn-outline-light mb-1" data-accion="historial" data-id="${c.id}">Historial mascota</button>`;

        return `
        <tr>
          <td>${esc(c.numero_folio)}</td>
          <td>${soloFecha(c.fecha)}</td>
          <td>${soloHora(c.hora)}</td>
          <td>${esc(mascotaNombre)}</td>
          <td>${esc(vetNombre)}</td>
          <td>${esc(c.motivo)}</td>
          <td>${badgeEstado(c.estado)}</td>
          <td>${c.hora_llegada ? 'Sí' : 'No'}</td>
          <td>${acciones}</td>
        </tr>
      `;
      }).join('');
    }

    document.getElementById('btnFiltrarCitas').addEventListener('click', fetchCitas);

    document.getElementById('tablaCitas').addEventListener('click', (e) => {
      const boton = e.target.closest('button[data-accion]');
      if (!boton) return;
      const id = boton.dataset.id;
      const cita = citasCache[id];
      const accion = boton.dataset.accion;

      const acciones = {
        confirmar: () => apiFetch(`/citas/${id}/confirmar`, { method: 'PUT' }).then(() => mostrarAlerta('Cita confirmada')),
        checkin: () => apiFetch(`/citas/${id}/check-in`, { method: 'PUT' }).then(() => mostrarAlerta('Llegada registrada')),
        iniciar: () => apiFetch(`/citas/${id}/iniciar-consulta`, { method: 'PUT' }).then(() => mostrarAlerta('Consulta iniciada')),
        completar: () => apiFetch(`/citas/${id}/completar`, { method: 'PUT' }).then(() => mostrarAlerta('Cita completada')),
      };

      if (accion in acciones) {
        acciones[accion]()
          .then(fetchCitas)
          .catch((err) => mostrarAlerta(mensajeError(err), 'danger'));
        return;
      }

      if (accion === 'reprogramar') {
        document.getElementById('reprogramar_cita_id').value = cita.id;
        document.getElementById('reprogramar_veterinario_id').value = cita.veterinario_id;
        document.getElementById('reprogramar_fecha').value = soloFecha(cita.fecha);
        document.getElementById('reprogramar_hora').value = soloHora(cita.hora);
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalReprogramar')).show();
      }

      if (accion === 'cancelar') {
        document.getElementById('formCancelar').reset();
        document.getElementById('cancelar_cita_id').value = cita.id;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalCancelar')).show();
      }

      if (accion === 'historial') {
        irAHistorialMascota(cita.mascota_id, cita.mascota ? cita.mascota.nombre : cita.mascota_id);
      }
    });

    document.getElementById('btnAgendarCita').addEventListener('click', () => {
      document.getElementById('formCita').reset();
      document.getElementById('cita_mascota_id').innerHTML = '<option value="">Busca una mascota primero</option>';
    });

    document.getElementById('btnBuscarMascotaCita').addEventListener('click', async () => {
      const buscar = document.getElementById('cita_buscar_mascota').value.trim();
      if (!buscar) return;
      try {
        const res = await apiFetch(`/mascotas?buscar=${encodeURIComponent(buscar)}`);
        const select = document.getElementById('cita_mascota_id');
        if (res.data.length === 0) {
          select.innerHTML = '<option value="">Sin resultados</option>';
          return;
        }
        select.innerHTML = res.data.map((m) => {
          const dueno = duenosCache[m.dueno_id];
          const duenoNombre = dueno ? dueno.nombre_completo : m.dueno_id;
          return `<option value="${m.id}">${esc(m.nombre)} (${esc(m.numero_expediente)}) — ${esc(duenoNombre)}</option>`;
        }).join('');
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    });

    document.getElementById('formCita').addEventListener('submit', async (e) => {
      e.preventDefault();
      const payload = {
        mascota_id: document.getElementById('cita_mascota_id').value,
        veterinario_id: document.getElementById('cita_veterinario_id').value,
        motivo: document.getElementById('cita_motivo').value,
        fecha: document.getElementById('cita_fecha').value,
        hora: document.getElementById('cita_hora').value,
      };

      try {
        await apiFetch('/citas', { method: 'POST', body: JSON.stringify(payload) });
        mostrarAlerta('Cita agendada');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalCita')).hide();
        mostrarFechaEnCalendario(payload.fecha);
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
      }
    });

    document.getElementById('formReprogramar').addEventListener('submit', async (e) => {
      e.preventDefault();
      const id = document.getElementById('reprogramar_cita_id').value;
      const payload = {
        veterinario_id: document.getElementById('reprogramar_veterinario_id').value,
        fecha: document.getElementById('reprogramar_fecha').value,
        hora: document.getElementById('reprogramar_hora').value,
      };

      try {
        await apiFetch(`/citas/${id}`, { method: 'PUT', body: JSON.stringify(payload) });
        mostrarAlerta('Cita reprogramada');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalReprogramar')).hide();
        mostrarFechaEnCalendario(payload.fecha);
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
      }
    });

    document.getElementById('formCancelar').addEventListener('submit', async (e) => {
      e.preventDefault();
      const id = document.getElementById('cancelar_cita_id').value;
      const payload = { motivo_cancelacion: document.getElementById('cancelar_motivo').value };

      try {
        await apiFetch(`/citas/${id}/cancelar`, { method: 'PUT', body: JSON.stringify(payload) });
        mostrarAlerta('Cita cancelada');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalCancelar')).hide();
        fetchCitas();
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
      }
    });

    document.getElementById('tabBtnCitas').addEventListener('click', () => { if (Object.keys(citasCache).length === 0) fetchCitas(); });
    document.getElementById('tabBtnMascotas').addEventListener('click', () => { if (Object.keys(mascotasCache).length === 0) fetchMascotas(); });
  </script>
</body>
</html>
