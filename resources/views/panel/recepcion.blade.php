<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de recepción</title>
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

    /* ---------- Inputs de fecha ---------- */
    input[type="date"] {
      zoom: 2.1;
      cursor: pointer;
      font-size: calc(1rem / 2.1); 
    }

    /* ---------- Bot ones ---------- */
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
          <img src="{{ asset('Imagenes/logo_veterinaria_transparente.png') }}" alt="Logo">
        </span>
        <span class="navbar-brand-text">Recepción — <span id="nombre-usuario">Cargando...</span></span>
      </span>
      <button class="btn btn-outline-light btn-sm" id="btnLogout">Cerrar sesión</button>
    </div>
  </nav>

  <div class="container-fluid mt-4">
    <div id="alertArea"></div>

    <div class="panel-card">
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
              <tr><th>Foto</th><th>Expediente</th><th>Nombre</th><th>Especie</th><th>Raza</th><th>Sexo</th><th>Nacimiento</th><th>Color</th><th>Dueño</th><th>Acciones</th></tr>
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
  </div>

  <div class="modal fade" id="modalDueno" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content modal-content-veterinaria bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="modalDuenoTitulo">Agregar dueño</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form id="formDueno">
          <div class="modal-body">
            <input type="hidden" id="dueno_id">
            <div class="mb-3">
              <label class="form-label">Nombre completo</label>
              <input required class="form-control" id="dueno_nombre" maxlength="160"
                pattern="[A-Za-zÀ-ÿÑñ]{3,50}(\s[A-Za-zÀ-ÿÑñ]{3,50}){2,}"
                title="Debe incluir nombre, apellido paterno y apellido materno, cada uno con 3 a 50 letras."
                placeholder="Nombre Apellido paterno Apellido materno">
              <div class="form-text">Nombre, apellido paterno y apellido materno (mínimo 3 letras cada uno).</div>
            </div>
            <div class="mb-3"><label class="form-label">Teléfono</label><input required class="form-control" id="dueno_telefono" maxlength="10" pattern="\d{10}" inputmode="numeric"></div>
            <div class="mb-3"><label class="form-label">Correo</label><input required type="email" class="form-control" id="dueno_correo" maxlength="150"></div>
            <div class="mb-3">
              <label class="form-label">Dirección</label>
              <input required class="form-control" id="dueno_direccion" maxlength="255"
                placeholder="Ciudad, Colonia, Calle, Número (ej: Tijuana, Centro, Av. Insurgentes, 123)">
              <div class="form-text">Debe incluir ciudad, colonia, calle y número de casa, separados por comas.</div>
            </div>
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
      <div class="modal-content modal-content-veterinaria bg-dark text-white">
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
            <div class="mb-3"><label class="form-label">Nombre</label><input required class="form-control" id="mascota_nombre" minlength="2" maxlength="100"></div>
            <div class="mb-3">
              <label class="form-label">Especie</label>
              <select required class="form-select" id="mascota_especie">
                <option value="">Selecciona una especie</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Raza</label>
              <select required class="form-select" id="mascota_raza">
                <option value="">Selecciona primero una especie</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Sexo</label>
              <select required class="form-select" id="mascota_sexo">
                <option value="macho">Macho</option>
                <option value="hembra">Hembra</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Fecha de nacimiento</label>
              <input required type="date" class="form-control" id="mascota_fecha_nacimiento"
                max="{{ now()->subDay()->format('Y-m-d') }}" min="{{ now()->subYears(30)->format('Y-m-d') }}">
              <div class="form-text">No puede ser hoy, una fecha futura, ni de hace más de 30 años.</div>
            </div>
            <div class="mb-3"><label class="form-label">Color</label><input required class="form-control" id="mascota_color" maxlength="50"></div>
            <div class="mb-3">
              <label class="form-label">Foto</label>
              <input type="file" accept="image/*" class="form-control" id="mascota_foto_archivo">
              <img id="mascota_foto_preview" class="mt-2 rounded border" style="max-width:120px; max-height:120px; display:none;" alt="Vista previa de la foto">
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

  <div class="modal fade" id="modalCita" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content modal-content-veterinaria bg-dark text-white">
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
            <div class="mb-3"><label class="form-label">Fecha</label><input required type="date" class="form-control"
          min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+3 months')) }}" id="cita_fecha" required></div>
            <div class="mb-3"><label class="form-label">Hora</label><input required type="time" class="form-control" id="cita_hora" min="07:00" max="21:00"></div>
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
      <div class="modal-content modal-content-veterinaria bg-dark text-white">
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
            <div class="mb-3"><label class="form-label">Fecha</label><input required type="date" class="form-control"
           min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+3 months')) }}" id="reprogramar_fecha" required></div>
            <div class="mb-3"><label class="form-label">Hora</label><input required type="time" class="form-control" id="reprogramar_hora" min="07:00" max="21:00"></div>
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
      <div class="modal-content modal-content-veterinaria bg-dark text-white">
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
      if (options.body && !(options.body instanceof FormData)) headers['Content-Type'] = 'application/json';
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
      poblarEspecies();

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
    let mascotaFotoArchivo = null;

    const ESPECIES = {
      perro: 'Perro',
      gato: 'Gato',
      ave: 'Ave',
      conejo: 'Conejo',
      hamster: 'Hámster',
      cuy: 'Cuy (cobaya)',
      tortuga: 'Tortuga',
      pez: 'Pez',
      huron: 'Hurón',
    };

    const RAZAS = {
      perro: ['Labrador Retriever', 'Golden Retriever', 'Pastor Alemán', 'Bulldog Francés', 'Bulldog Inglés', 'Chihuahua', 'Poodle (Caniche)', 'Beagle', 'Boxer', 'Schnauzer', 'Pug', 'Husky Siberiano', 'Rottweiler', 'Doberman', 'Shih Tzu', 'Yorkshire Terrier', 'Cocker Spaniel', 'Salchicha (Dachshund)', 'Border Collie', 'Gran Danés', 'Criollo/Mestizo'],
      gato: ['Común Europeo (Mestizo)', 'Persa', 'Siamés', 'Maine Coon', 'Bengalí', 'Ragdoll', 'Sphynx', 'Británico de Pelo Corto', 'Angora', 'Himalayo'],
      ave: ['Periquito', 'Canario', 'Cacatúa', 'Loro', 'Agapornis', 'Ninfa (Cockatiel)', 'Guacamayo'],
      conejo: ['Holandés', 'Cabeza de León', 'Angora', 'Rex', 'Mini Lop', 'Mestizo'],
      hamster: ['Sirio', 'Ruso', 'Chino', 'Roborovski'],
      cuy: ['Americano', 'Peruano', 'Abisinio', 'Mestizo'],
      tortuga: ['Terrestre', 'Acuática', 'Orejas Rojas'],
      pez: ['Betta', 'Pez Dorado (Goldfish)', 'Guppy', 'Disco', 'Koi'],
      huron: ['Estándar', 'Angora'],
    };

    function poblarEspecies() {
      const select = document.getElementById('mascota_especie');
      select.innerHTML = '<option value="">Selecciona una especie</option>' +
        Object.entries(ESPECIES).map(([valor, etiqueta]) => `<option value="${valor}">${esc(etiqueta)}</option>`).join('');
    }

    function poblarRazas(especie, razaSeleccionada = '') {
      const select = document.getElementById('mascota_raza');
      const razas = RAZAS[especie] || [];
      if (!especie) {
        select.innerHTML = '<option value="">Selecciona primero una especie</option>';
        return;
      }
      select.innerHTML = '<option value="">Selecciona una raza</option>' +
        razas.map((raza) => `<option value="${esc(raza)}">${esc(raza)}</option>`).join('');
      if (razaSeleccionada) select.value = razaSeleccionada;
    }

    document.getElementById('mascota_especie').addEventListener('change', (e) => poblarRazas(e.target.value));

    function mostrarFotoPreview(url) {
      const preview = document.getElementById('mascota_foto_preview');
      if (url) {
        preview.src = url;
        preview.style.display = 'block';
      } else {
        preview.removeAttribute('src');
        preview.style.display = 'none';
      }
    }

    document.getElementById('mascota_foto_archivo').addEventListener('change', (e) => {
      const archivo = e.target.files[0] || null;
      mascotaFotoArchivo = archivo;
      if (archivo) {
        mostrarFotoPreview(URL.createObjectURL(archivo));
      }
    });

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
        const fotoHtml = m.foto_url
          ? `<img src="${esc(m.foto_url)}" alt="Foto de ${esc(m.nombre)}" class="rounded" style="width:40px; height:40px; object-fit:cover;">`
          : '<span class="text-secondary">—</span>';
        return `
        <tr>
          <td>${fotoHtml}</td>
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
      document.getElementById('mascota_dueno_id').disabled = false;
      document.getElementById('mascota_especie').disabled = false;
      document.getElementById('mascota_raza').disabled = false;
      poblarEspecies();
      poblarRazas('');
      mascotaFotoArchivo = null;
      mostrarFotoPreview(null);
      document.getElementById('modalMascotaTitulo').innerText = 'Agregar mascota';
    });

    document.getElementById('tablaMascotas').addEventListener('click', (e) => {
      const boton = e.target.closest('button[data-accion]');
      if (!boton) return;
      const id = boton.dataset.id;
      const mascota = mascotasCache[id];

      if (boton.dataset.accion === 'editar') {
        document.getElementById('formMascota').reset();
        poblarEspecies();
        document.getElementById('mascota_id').value = mascota.id;
        document.getElementById('mascota_dueno_id').value = mascota.dueno_id;
        document.getElementById('mascota_nombre').value = mascota.nombre;
        document.getElementById('mascota_especie').value = mascota.especie;
        poblarRazas(mascota.especie, mascota.raza || '');
        document.getElementById('mascota_sexo').value = mascota.sexo;
        document.getElementById('mascota_fecha_nacimiento').value = soloFecha(mascota.fecha_nacimiento);
        document.getElementById('mascota_color').value = mascota.color || '';
        document.getElementById('mascota_dueno_id').disabled = true;
        document.getElementById('mascota_especie').disabled = true;
        document.getElementById('mascota_raza').disabled = true;
        mascotaFotoArchivo = null;
        mostrarFotoPreview(mascota.foto_url || null);
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
      const fechaNacimiento = document.getElementById('mascota_fecha_nacimiento').value;
      const hoyIso = new Date().toISOString().slice(0, 10);
      if (fechaNacimiento && fechaNacimiento >= hoyIso) {
        mostrarAlerta('La fecha de nacimiento no puede ser hoy ni una fecha futura', 'danger');
        return;
      }
      const haceTreintaAnios = new Date();
      haceTreintaAnios.setFullYear(haceTreintaAnios.getFullYear() - 30);
      if (fechaNacimiento && fechaNacimiento < haceTreintaAnios.toISOString().slice(0, 10)) {
        mostrarAlerta('La fecha de nacimiento no puede ser de hace más de 30 años', 'danger');
        return;
      }
      const formData = new FormData();
      formData.append('nombre', document.getElementById('mascota_nombre').value);
      formData.append('sexo', document.getElementById('mascota_sexo').value);
      formData.append('fecha_nacimiento', fechaNacimiento);
      formData.append('color', document.getElementById('mascota_color').value);
      if (mascotaFotoArchivo) {
        formData.append('foto', mascotaFotoArchivo);
      }

      try {
        if (id) {
          formData.append('_method', 'PUT');
          await apiFetch(`/mascotas/${id}`, { method: 'POST', body: formData });
          mostrarAlerta('Mascota actualizada');
        } else {
          formData.append('dueno_id', document.getElementById('mascota_dueno_id').value);
          formData.append('especie', document.getElementById('mascota_especie').value);
          formData.append('raza', document.getElementById('mascota_raza').value);
          await apiFetch('/mascotas', { method: 'POST', body: formData });
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

    function irAMascotaDesdeCita(mascotaId, mascotaNombre) {
      activarTab('tabBtnMascotas');
      document.getElementById('filtroDuenoMascota').value = '';
      document.getElementById('buscarMascota').value = mascotaNombre || '';
      fetchMascotas();
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
         const vencida = citaVencida(c);
        let acciones = '';
        if (c.estado === 'agendada' && vencida) {
        } 
        else if (c.estado === 'agendada' || c.estado === 'confirmada') {
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

        acciones += `<button class="btn btn-sm btn-outline-light mb-1" data-accion="ver-mascota" data-id="${c.id}">Ver mascota</button>`;

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
        if (!citaCancelable(cita)) {
        mostrarAlerta('Solo se puede cancelar una cita hasta 2 horas antes de la hora agendada', 'danger');
        return;
        }
        document.getElementById('formCancelar').reset();
        document.getElementById('cancelar_cita_id').value = cita.id;
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalCancelar')).show();
      }

      if (accion === 'ver-mascota') {
        irAMascotaDesdeCita(cita.mascota_id, cita.mascota ? cita.mascota.nombre : cita.mascota_id);
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
       const fecha = document.getElementById('cita_fecha').value;
       if (!fechaDentroDeRango(fecha)) {
    mostrarAlerta('Solo se pueden agendar citas entre hoy y un año a partir de hoy', 'danger');
    return;
  }
      const hora = document.getElementById('cita_hora').value;
      if (!horaValida(hora)) {
      mostrarAlerta('Las citas solo se pueden agendar entre las 7:00 y las 22:00 horas', 'danger');
      return;
      }
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
      const fecha = document.getElementById('reprogramar_fecha').value;
      if (!fechaDentroDeRango(fecha)) {
    mostrarAlerta('Solo se pueden reprogramar citas entre hoy y un año a partir de hoy', 'danger');
    return;
  }
      const hora = document.getElementById('reprogramar_hora').value;
      if (!horaValida(hora)) {
      mostrarAlerta('Las citas solo se pueden agendar entre las 7:00 y las 22:00 horas', 'danger');
      return;
      }
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

    function citaVencida(c) {
    return new Date(`${soloFecha(c.fecha)}T${soloHora(c.hora)}`) < new Date();
    }

    function citaCancelable(c) {
  const fechaHoraCita = new Date(`${soloFecha(c.fecha)}T${soloHora(c.hora)}`);
  const ahora = new Date();
  const diferenciaHoras = (fechaHoraCita - ahora) / (1000 * 60 * 60);
  return diferenciaHoras >= 2;
}
    
    function horaValida(hora) {
  const [h] = hora.split(':').map(Number);
  return h >= 7 && h < 22;
}

function fechaDentroDeRango(fecha) {
  const hoy = new Date().toISOString().slice(0, 10);
  const en3Meses = new Date();
  en3Meses.setMonth(en3Meses.getMonth() + 3);
  const maxFecha = en3Meses.toISOString().slice(0, 10);
  return fecha >= hoy && fecha <= maxFecha;
}
    document.getElementById('tabBtnCitas').addEventListener('click', () => { if (Object.keys(citasCache).length === 0) fetchCitas(); });
    document.getElementById('tabBtnMascotas').addEventListener('click', () => { if (Object.keys(mascotasCache).length === 0) fetchMascotas(); });
  </script>
</body>
</html>
