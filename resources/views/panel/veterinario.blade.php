<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel del veterinario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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

    /* ---------- Tabs (modal de ficha) ---------- */
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

    .form-select:disabled,
    .form-control:disabled {
      background-color: #2a2a2a;
      color: #999999;
      border-color: #333333;
      opacity: 1;
    }

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

    /* ---------- Acciones de la tabla ---------- */
    .acciones-cell { display: flex; flex-wrap: wrap; gap: 6px; }

    .archivo-link { color: #6ea8fe; }
    .list-group-item { background-color: #1a1a1a; color: #fff; border-color: #333333; }
  </style>
</head>
<body>
  <nav class="navbar navbar-veterinaria" data-bs-theme="dark">
    <div class="container-fluid">
      <span class="navbar-brand d-flex align-items-center gap-2">
        <span class="logo-container-nav">
          <img src="{{ asset('Imagenes/logo_de_la_veterinaria.jpg') }}" width="45" height="45" class="rounded-circle" alt="Logo">
        </span>
        Bienvenido, <span id="nombre-usuario">Cargando...</span>
      </span>
      <button class="btn btn-outline-light btn-sm" id="btnLogout">Cerrar sesión</button>
    </div>
  </nav>

  <div class="container-fluid mt-4">
    <div id="alertArea"></div>

    <div class="panel-card">
      <h2 class="mb-3">Mi agenda</h2>

      <div class="row g-2 mb-3 align-items-end">
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
          <button class="btn btn-primary" id="btnFiltrar">Filtrar</button>
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
  </div>

  <!-- ===================== MODAL: FICHA DE CONSULTA ===================== -->
  <div class="modal fade" id="modalFicha" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content modal-content-veterinaria">
        <div class="modal-header">
          <h5 class="modal-title">Ficha de consulta</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-4"><strong>Mascota:</strong> <span id="fichaMascota">-</span></div>
            <div class="col-md-4"><strong>Dueño:</strong> <span id="fichaDueno">-</span></div>
            <div class="col-md-4"><strong>Motivo:</strong> <span id="fichaMotivo">-</span></div>
          </div>

          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabDiagnostico" type="button">Diagnóstico</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabArchivos" type="button">Archivos</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabVacunas" type="button">Vacunación</button></li>
          </ul>

          <div class="tab-content pt-3">
            <!-- Diagnóstico / tratamiento / peso / temperatura -->
            <div class="tab-pane fade show active" id="tabDiagnostico">
              <div class="row g-2 mb-2">
                <div class="col-md-6">
                  <label class="form-label small mb-0">Peso (kg)</label>
                  <input type="number" step="0.01" class="form-control" id="inputPeso">
                </div>
                <div class="col-md-6">
                  <label class="form-label small mb-0">Temperatura (°C)</label>
                  <input type="number" step="0.1" class="form-control" id="inputTemperatura">
                </div>
              </div>
              <div class="mb-2">
                <label class="form-label small mb-0">Diagnóstico</label>
                <textarea class="form-control" id="inputDiagnostico" rows="2"></textarea>
              </div>
              <div class="mb-2">
                <label class="form-label small mb-0">Tratamiento indicado</label>
                <textarea class="form-control" id="inputTratamiento" rows="2"></textarea>
              </div>
              <div class="mb-2">
                <label class="form-label small mb-0">Medicamentos recetados</label>
                <textarea class="form-control" id="inputMedicamentos" rows="2"></textarea>
              </div>
              <div class="mb-2">
                <label class="form-label small mb-0">Observaciones</label>
                <textarea class="form-control" id="inputObservaciones" rows="2"></textarea>
              </div>
              <button class="btn btn-primary" id="btnGuardarConsulta">Guardar consulta</button>
            </div>

            <!-- Archivos -->
            <div class="tab-pane fade" id="tabArchivos">
              <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputArchivo" accept=".pdf,.jpg,.jpeg,.png">
                <button class="btn btn-outline-light" id="btnSubirArchivo">Adjuntar</button>
              </div>
              <ul class="list-group" id="listaArchivos"></ul>
            </div>

            <!-- Vacunas -->
            <div class="tab-pane fade" id="tabVacunas">
              <div class="row g-2 mb-3">
                <div class="col-md-5">
                  <label class="form-label small mb-0">Vacuna aplicada</label>
                  <input type="text" class="form-control" id="inputNombreVacuna">
                </div>
                <div class="col-md-3">
                  <label class="form-label small mb-0">Fecha aplicación</label>
                  <input type="date" class="form-control" id="inputFechaAplicacion">
                </div>
                <div class="col-md-3">
                  <label class="form-label small mb-0">Próxima dosis</label>
                  <input type="date" class="form-control" id="inputProximaDosis">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                  <button class="btn btn-primary w-100" id="btnAgregarVacuna">+</button>
                </div>
              </div>
              <ul class="list-group" id="listaVacunas"></ul>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-success" id="btnCompletarDesdeFicha">Marcar como completada</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ===================== MODAL: HISTORIAL CLÍNICO ===================== -->
  <div class="modal fade" id="modalHistorial" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content modal-content-veterinaria">
        <div class="modal-header">
          <h5 class="modal-title">Historial clínico</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div id="historialContenido">Cargando...</div>
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

    // Variante para envío de archivos (multipart/form-data): no fijar Content-Type,
    // el navegador lo arma junto con el boundary.
    async function apiFetchForm(path, formData, method = 'POST') {
      const headers = { Accept: 'application/json', Authorization: `Bearer ${token}` };
      const res = await fetch(`/api${path}`, { method, headers, body: formData });

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
        agendada: 'Agendada', confirmada: 'Confirmada', en_consulta: 'En consulta',
        completada: 'Completada', cancelada: 'Cancelada', vencida: 'Vencida',
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

    // ============ AGENDA ============
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

      if (!citas || citas.length === 0) {
        tbody.innerHTML = `<tr><td colspan="8" class="text-center">No se encontraron citas.</td></tr>`;
        return;
      }

      tbody.innerHTML = citas.map((c) => {
        const mascotaNombre = c.mascota ? c.mascota.nombre : `#${c.mascota_id}`;
        let acciones = '';

        if (c.estado === 'agendada' || c.estado === 'confirmada') {
          acciones += `<button class="btn btn-sm btn-primary" data-accion="iniciar" data-id="${c.id}">Iniciar consulta</button>`;
        } else if (c.estado === 'en_consulta') {
          acciones += `<button class="btn btn-sm btn-warning" data-accion="ficha" data-id="${c.id}">Abrir ficha</button>`;
          acciones += `<button class="btn btn-sm btn-success" data-accion="completar" data-id="${c.id}">Completar</button>`;
        } else if (c.estado === 'completada') {
          acciones += `<button class="btn btn-sm btn-outline-light" data-accion="ficha" data-id="${c.id}">Ver ficha</button>`;
        }

        acciones += `<button class="btn btn-sm btn-outline-light" data-accion="historial" data-mascota-id="${c.mascota_id}">Historial</button>`;

        return `
        <tr>
          <td>${esc(c.numero_folio)}</td>
          <td>${soloFecha(c.fecha)}</td>
          <td>${soloHora(c.hora)}</td>
          <td>${esc(mascotaNombre)}</td>
          <td>${esc(c.motivo)}</td>
          <td>${badgeEstado(c.estado)}</td>
          <td>${c.hora_llegada ? 'Sí' : 'No'}</td>
          <td><div class="acciones-cell">${acciones}</div></td>
        </tr>
      `;
      }).join('');
    }

    document.getElementById('btnFiltrar').addEventListener('click', fetchCitas);

    document.getElementById('tablaCitas').addEventListener('click', (e) => {
      const boton = e.target.closest('button[data-accion]');
      if (!boton) return;
      const accion = boton.dataset.accion;

      if (accion === 'iniciar') {
        iniciarConsulta(boton.dataset.id);
      } else if (accion === 'completar') {
        completarCita(boton.dataset.id);
      } else if (accion === 'ficha') {
        abrirFicha(boton.dataset.id);
      } else if (accion === 'historial') {
        abrirHistorial(boton.dataset.mascotaId);
      }
    });

    async function iniciarConsulta(id) {
      try {
        await apiFetch(`/citas/${id}/iniciar-consulta`, { method: 'PUT' });
        mostrarAlerta('Consulta iniciada');
        await fetchCitas();
        abrirFicha(id);
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    async function completarCita(id) {
      try {
        await apiFetch(`/citas/${id}/completar`, { method: 'PUT' });
        mostrarAlerta('Cita completada');
        fetchCitas();
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    // ===================== FICHA DE CONSULTA =====================

    let fichaCitaId = null;
    let fichaConsultaId = null;
    let fichaMascotaId = null;
    const modalFichaEl = document.getElementById('modalFicha');
    const modalFicha = new bootstrap.Modal(modalFichaEl);

    function limpiarFicha() {
      ['inputPeso', 'inputTemperatura', 'inputDiagnostico', 'inputTratamiento', 'inputMedicamentos', 'inputObservaciones', 'inputNombreVacuna', 'inputFechaAplicacion', 'inputProximaDosis', 'inputArchivo'].forEach((id) => {
        document.getElementById(id).value = '';
      });
      document.getElementById('listaArchivos').innerHTML = '';
      document.getElementById('listaVacunas').innerHTML = '';
    }

    async function abrirFicha(citaId) {
      limpiarFicha();
      fichaCitaId = citaId;

      try {
        const res = await apiFetch(`/citas/${citaId}/consulta`);
        document.getElementById('fichaMascota').innerText = res.mascota ? res.mascota.nombre : `#${res.mascota?.id ?? ''}`;
        document.getElementById('fichaDueno').innerText = res.dueno ? res.dueno.nombre_completo || res.dueno.nombre : '-';
        document.getElementById('fichaMotivo').innerText = res.motivo || '-';
        fichaMascotaId = res.mascota ? res.mascota.id : null;

        if (res.consulta) {
          fichaConsultaId = res.consulta.id;
          document.getElementById('inputPeso').value = res.consulta.peso ?? '';
          document.getElementById('inputTemperatura').value = res.consulta.temperatura ?? '';
          document.getElementById('inputDiagnostico').value = res.consulta.diagnostico ?? '';
          document.getElementById('inputTratamiento').value = res.consulta.tratamiento ?? '';
          document.getElementById('inputMedicamentos').value = res.consulta.medicamentos_recetados ?? '';
          document.getElementById('inputObservaciones').value = res.consulta.observaciones ?? '';
          cargarArchivos(fichaConsultaId);
        } else {
          fichaConsultaId = null;
        }

        if (fichaMascotaId) {
          cargarVacunas(fichaMascotaId);
        }

        const estadoCompletada = citasCache[citaId] && citasCache[citaId].estado === 'completada';
        document.getElementById('btnGuardarConsulta').disabled = estadoCompletada;
        document.getElementById('btnCompletarDesdeFicha').disabled = estadoCompletada;
        document.getElementById('btnSubirArchivo').disabled = estadoCompletada;
        document.getElementById('btnAgregarVacuna').disabled = estadoCompletada;

        modalFicha.show();
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    document.getElementById('btnGuardarConsulta').addEventListener('click', async () => {
      const payload = {
        peso: document.getElementById('inputPeso').value || null,
        temperatura: document.getElementById('inputTemperatura').value || null,
        diagnostico: document.getElementById('inputDiagnostico').value || null,
        tratamiento: document.getElementById('inputTratamiento').value || null,
        medicamentos_recetados: document.getElementById('inputMedicamentos').value || null,
        observaciones: document.getElementById('inputObservaciones').value || null,
      };

      try {
        if (fichaConsultaId) {
          const res = await apiFetch(`/consultas/${fichaConsultaId}`, { method: 'PUT', body: JSON.stringify(payload) });
          mostrarAlerta(res.mensaje || 'Consulta actualizada');
        } else {
          const res = await apiFetch(`/citas/${fichaCitaId}/consulta`, { method: 'POST', body: JSON.stringify(payload) });
          fichaConsultaId = res.consulta.id;
          mostrarAlerta(res.mensaje || 'Consulta registrada');
        }
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    });

    document.getElementById('btnCompletarDesdeFicha').addEventListener('click', async () => {
      if (!fichaCitaId) return;
      try {
        await apiFetch(`/citas/${fichaCitaId}/completar`, { method: 'PUT' });
        mostrarAlerta('Cita completada');
        modalFicha.hide();
        fetchCitas();
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    });

    // Archivos

    function renderArchivos(archivos) {
      const lista = document.getElementById('listaArchivos');
      if (!archivos || !archivos.length) {
        lista.innerHTML = '<li class="list-group-item">Sin archivos adjuntos.</li>';
        return;
      }
      lista.innerHTML = archivos.map((a) => `
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <a class="archivo-link" href="${esc(a.ruta_archivo)}" target="_blank" rel="noopener">${esc(a.nombre_archivo)}</a>
          <span class="badge bg-secondary">${esc(a.tipo)}</span>
        </li>
      `).join('');
    }

    async function cargarArchivos(consultaId) {
      try {
        const res = await apiFetch(`/consultas/${consultaId}/archivos`);
        renderArchivos(res.data || res.archivos || res);
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    document.getElementById('btnSubirArchivo').addEventListener('click', async () => {
      const input = document.getElementById('inputArchivo');
      const file = input.files[0];
      if (!file) {
        mostrarAlerta('Selecciona un archivo (PDF, JPG o PNG).', 'warning');
        return;
      }
      if (!fichaConsultaId) {
        mostrarAlerta('Guarda primero los datos de la consulta antes de adjuntar archivos.', 'warning');
        return;
      }

      const formData = new FormData();
      formData.append('archivo', file);

      try {
        await apiFetchForm(`/consultas/${fichaConsultaId}/archivos`, formData);
        mostrarAlerta('Archivo adjuntado');
        input.value = '';
        cargarArchivos(fichaConsultaId);
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    });

    // Vacunas

    function renderVacunas(vacunas) {
      const lista = document.getElementById('listaVacunas');
      if (!vacunas || !vacunas.length) {
        lista.innerHTML = '<li class="list-group-item">Sin vacunas registradas.</li>';
        return;
      }
      lista.innerHTML = vacunas.map((v) => `
        <li class="list-group-item">
          <strong>${esc(v.nombre_vacuna)}</strong> — aplicada: ${soloFecha(v.fecha_aplicacion)}
          ${v.fecha_proxima_dosis ? ` · próxima dosis: ${soloFecha(v.fecha_proxima_dosis)}` : ''}
        </li>
      `).join('');
    }

    async function cargarVacunas(mascotaId) {
      try {
        const res = await apiFetch(`/mascotas/${mascotaId}/vacunas`);
        renderVacunas(res.data || res);
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    document.getElementById('btnAgregarVacuna').addEventListener('click', async () => {
      const nombre = document.getElementById('inputNombreVacuna').value.trim();
      const fechaAplicacion = document.getElementById('inputFechaAplicacion').value;
      const proximaDosis = document.getElementById('inputProximaDosis').value;

      if (!nombre || !fechaAplicacion) {
        mostrarAlerta('Nombre de vacuna y fecha de aplicación son obligatorios.', 'warning');
        return;
      }
      if (!fichaMascotaId) {
        mostrarAlerta('No se pudo determinar la mascota de esta ficha.', 'danger');
        return;
      }

      const payload = {
        nombre_vacuna: nombre,
        fecha_aplicacion: fechaAplicacion,
        fecha_proxima_dosis: proximaDosis || null,
        consulta_id: fichaConsultaId || null,
      };

      try {
        await apiFetch(`/mascotas/${fichaMascotaId}/vacunas`, { method: 'POST', body: JSON.stringify(payload) });
        mostrarAlerta('Vacuna registrada');
        document.getElementById('inputNombreVacuna').value = '';
        document.getElementById('inputFechaAplicacion').value = '';
        document.getElementById('inputProximaDosis').value = '';
        cargarVacunas(fichaMascotaId);
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    });

    // ===================== HISTORIAL CLÍNICO =====================

    const modalHistorial = new bootstrap.Modal(document.getElementById('modalHistorial'));

    function renderHistorial(consultas) {
      if (!consultas || !consultas.length) {
        return '<p>Esta mascota no tiene consultas registradas.</p>';
      }
      return consultas.map((c) => `
        <div class="panel-card mb-2 p-3">
          <h6>${soloFecha(c.fecha || c.cita?.fecha)} — ${esc(c.motivo || c.cita?.motivo || '')}</h6>
          <p class="mb-1"><strong>Diagnóstico:</strong> ${esc(c.diagnostico) || '—'}</p>
          <p class="mb-1"><strong>Tratamiento:</strong> ${esc(c.tratamiento) || '—'}</p>
          <p class="mb-1"><strong>Medicamentos:</strong> ${esc(c.medicamentos_recetados) || '—'}</p>
          <p class="mb-1"><strong>Observaciones:</strong> ${esc(c.observaciones) || '—'}</p>
          <p class="mb-0"><strong>Peso:</strong> ${esc(c.peso) || '—'} kg &nbsp; <strong>Temp.:</strong> ${esc(c.temperatura) || '—'} °C</p>
        </div>
      `).join('');
    }

    async function abrirHistorial(mascotaId) {
      document.getElementById('historialContenido').innerHTML = 'Cargando...';
      modalHistorial.show();
      try {
        const res = await apiFetch(`/mascotas/${mascotaId}/historial`);
        const consultas = res.data || res.historial || res;
        document.getElementById('historialContenido').innerHTML = renderHistorial(consultas);
      } catch (e) {
        document.getElementById('historialContenido').innerHTML = `<div class="alert alert-danger">${esc(mensajeError(e))}</div>`;
      }
    }

    // ===================== LOGOUT / INIT =====================

    document.getElementById('btnLogout').addEventListener('click', async () => {
      try {
        await apiFetch('/auth/usuarios/logout', { method: 'POST' });
      } catch (e) {}
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

    // ============ HISTORIAL CLÍNICO ============
    async function abrirHistorial() {
      if (!fichaMascotaId) return;
      try {
        const res = await apiFetch(`/mascotas/${fichaMascotaId}/historial`);

        const consultasDiv = document.getElementById('historialConsultas');
        if (!res.consultas || res.consultas.length === 0) {
          consultasDiv.innerHTML = '<p class="texto-tenue">Sin consultas completadas registradas.</p>';
        } else {
          consultasDiv.innerHTML = res.consultas.map((c) => `
            <div class="mb-2 pb-2" style="border-bottom: 1px solid #333;">
              <p class="mb-1"><strong>${soloFecha(c.fecha_cita)}</strong> — Dr(a). ${esc(c.veterinario_nombre)} — ${esc(c.motivo)}</p>
              <p class="mb-1"><strong>Diagnóstico:</strong> ${esc(c.diagnostico || '—')}</p>
              <p class="mb-1"><strong>Tratamiento:</strong> ${esc(c.tratamiento || '—')}</p>
              ${c.peso ? `<p class="mb-0 texto-tenue">Peso: ${esc(c.peso)} kg — Temp: ${esc(c.temperatura || '—')} °C</p>` : ''}
            </div>
          `).join('');
        }

        const vacunasDiv = document.getElementById('historialVacunas');
        if (!res.vacunas || res.vacunas.length === 0) {
          vacunasDiv.innerHTML = '<p class="texto-tenue">Sin vacunas registradas.</p>';
        } else {
          vacunasDiv.innerHTML = res.vacunas.map((v) => `
            <div class="mb-1">
              <strong>${esc(v.nombre_vacuna)}</strong> — ${soloFecha(v.fecha_aplicacion)}
              ${v.proxima_a_vencer ? '<span class="badge bg-warning text-dark">Próxima a vencer</span>' : ''}
            </div>
          `).join('');
        }

        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalHistorial')).show();
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    document.getElementById('btnVerHistorial').addEventListener('click', abrirHistorial);
  </script>
</body>
</html>