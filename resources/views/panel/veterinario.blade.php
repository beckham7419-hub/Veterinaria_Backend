<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel del veterinario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #1a1a1a;
      color: #ffffff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .navbar-veterinaria {
      background-color: #242424;
      border-bottom: 2px solid #ff4d4d;
      box-shadow: 0 2px 12px rgba(255, 77, 77, 0.15);
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

    .panel-card {
      background-color: #242424;
      border: 2px solid #ff4d4d;
      border-radius: 14px;
      padding: 25px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 15px rgba(255, 77, 77, 0.15);
    }

    .table { color: #ffffff; }
    .table > :not(caption) > * > * { background-color: transparent; color: #ffffff; border-bottom-color: #333333; }
    .table-dark thead { background-color: #1a1a1a; }
    .table-dark th { border-color: #333333; color: #ff4d4d; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }
    .table-striped > tbody > tr:nth-of-type(odd) > * { background-color: #262626; }
    .table-hover > tbody > tr:hover > * { background-color: #2f2020; }

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

    .form-label { color: #cccccc; }

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

    .alert { border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.1); }

    .badge-estado-agendada { background-color: #6c757d; }
    .badge-estado-confirmada { background-color: #0d6efd; }
    .badge-estado-en_consulta { background-color: #fd7e14; }
    .badge-estado-completada { background-color: #198754; }
    .badge-estado-cancelada { background-color: #dc3545; }
    .badge-estado-vencida { background-color: #6c757d; }

    .seccion-ficha {
      background-color: #1a1a1a;
      border: 1px solid #333333;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 15px;
    }

    .seccion-ficha h6 {
      color: #ff4d4d;
      text-transform: uppercase;
      font-size: 0.8rem;
      letter-spacing: 0.5px;
      margin-bottom: 10px;
    }

    .texto-tenue {
      color: #999999;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-veterinaria" data-bs-theme="dark">
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

    <div class="panel-card">
      <h2 class="mb-3">Mi agenda</h2>

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
            <option value="vencida">Vencida</option>
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
  </div>

  <!-- ===================== MODAL FICHA DE CONSULTA ===================== -->
  <div class="modal fade" id="modalFicha" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content modal-content-veterinaria">
        <div class="modal-header">
          <h5 class="modal-title">Ficha de consulta — <span id="ficha_folio"></span></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          <div class="seccion-ficha">
            <h6>Datos de la visita</h6>
            <p class="mb-1"><strong>Mascota:</strong> <span id="ficha_mascota_nombre"></span></p>
            <p class="mb-1"><strong>Dueño:</strong> <span id="ficha_dueno_nombre"></span></p>
            <p class="mb-0"><strong>Motivo:</strong> <span id="ficha_motivo"></span></p>
            <button type="button" class="btn btn-sm btn-outline-light mt-2" id="btnVerHistorial">Ver historial clínico completo</button>
          </div>

          <div class="seccion-ficha">
            <h6>Diagnóstico y tratamiento</h6>
            <form id="formFicha">
              <input type="hidden" id="ficha_cita_id">
              <div class="row g-2">
                <div class="col-md-6">
                  <label class="form-label">Peso (kg)</label>
                  <input type="number" step="0.01" min="0" max="999.99" class="form-control" id="ficha_peso">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Temperatura (°C)</label>
                  <input type="number" step="0.1" min="0" max="999.9" class="form-control" id="ficha_temperatura">
                </div>
              </div>
              <div class="mb-2 mt-2">
                <label class="form-label">Diagnóstico</label>
                <textarea class="form-control" id="ficha_diagnostico" rows="2"></textarea>
              </div>
              <div class="mb-2">
                <label class="form-label">Tratamiento indicado</label>
                <textarea class="form-control" id="ficha_tratamiento" rows="2"></textarea>
              </div>
              <div class="mb-2">
                <label class="form-label">Medicamentos recetados</label>
                <textarea class="form-control" id="ficha_medicamentos" rows="2"></textarea>
              </div>
              <div class="mb-2">
                <label class="form-label">Observaciones</label>
                <textarea class="form-control" id="ficha_observaciones" rows="2"></textarea>
              </div>
              <button type="submit" class="btn btn-primary" id="btnGuardarFicha">Guardar consulta</button>
              <span id="ficha_solo_lectura_aviso" class="texto-tenue ms-2" style="display:none;">Esta cita ya está completada; la consulta es de solo lectura.</span>
            </form>
          </div>

          <div class="seccion-ficha">
            <h6>Archivos adjuntos</h6>
            <div id="listaArchivos" class="mb-2"></div>
            <form id="formArchivo" class="d-flex gap-2">
              <input type="file" id="ficha_archivo" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
              <button type="submit" class="btn btn-outline-light">Adjuntar</button>
            </form>
            <div class="form-text">PDF, JPG o PNG, máximo 10MB. Guarda la consulta antes de adjuntar archivos.</div>
          </div>

          <div class="seccion-ficha">
            <h6>Vacunación</h6>
            <div id="listaVacunas" class="mb-2"></div>
            <form id="formVacuna" class="row g-2">
              <div class="col-md-4">
                <input type="text" id="vacuna_nombre" class="form-control" placeholder="Nombre de la vacuna" required>
              </div>
              <div class="col-md-3">
                <label class="form-label small mb-0">Fecha de aplicación</label>
                <input type="date" id="vacuna_fecha_aplicacion" class="form-control" required>
              </div>
              <div class="col-md-3">
                <label class="form-label small mb-0">Próxima dosis (opcional)</label>
                <input type="date" id="vacuna_proxima_dosis" class="form-control">
              </div>
              <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-light w-100">Registrar</button>
              </div>
            </form>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ===================== MODAL HISTORIAL CLÍNICO ===================== -->
  <div class="modal fade" id="modalHistorial" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content modal-content-veterinaria">
        <div class="modal-header">
          <h5 class="modal-title">Historial clínico completo</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="seccion-ficha">
            <h6>Consultas anteriores</h6>
            <div id="historialConsultas"></div>
          </div>
          <div class="seccion-ficha">
            <h6>Vacunas aplicadas</h6>
            <div id="historialVacunas"></div>
          </div>
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
          acciones += `<button class="btn btn-sm btn-primary mb-1" data-accion="iniciar" data-id="${c.id}">Iniciar consulta</button> `;
        } else if (c.estado === 'en_consulta') {
          acciones += `<button class="btn btn-sm btn-success mb-1" data-accion="completar" data-id="${c.id}">Completar</button> `;
        }

        if (c.estado !== 'cancelada' && c.estado !== 'vencida') {
          acciones += `<button class="btn btn-sm btn-outline-light mb-1" data-accion="ficha" data-id="${c.id}">Ficha</button>`;
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
      const accion = boton.dataset.accion;

      if (accion === 'ficha') {
        abrirFicha(citasCache[id]);
        return;
      }

      const rutas = { iniciar: `/citas/${id}/iniciar-consulta`, completar: `/citas/${id}/completar` };
      const mensajes = { iniciar: 'Consulta iniciada', completar: 'Cita completada' };

      apiFetch(rutas[accion], { method: 'PUT' })
        .then(() => { mostrarAlerta(mensajes[accion]); fetchCitas(); })
        .catch((err) => mostrarAlerta(mensajeError(err), 'danger'));
    });

    // ============ FICHA DE CONSULTA ============
    let fichaConsultaId = null;
    let fichaMascotaId = null;
    let fichaSoloLectura = false;

    async function abrirFicha(cita) {
      try {
        const res = await apiFetch(`/citas/${cita.id}/consulta`);

        document.getElementById('ficha_cita_id').value = cita.id;
        document.getElementById('ficha_folio').innerText = cita.numero_folio;
        document.getElementById('ficha_mascota_nombre').innerText = res.mascota ? res.mascota.nombre : '';
        document.getElementById('ficha_dueno_nombre').innerText = res.dueno ? res.dueno.nombre_completo : '';
        document.getElementById('ficha_motivo').innerText = res.motivo || '';

        fichaMascotaId = res.mascota ? res.mascota.id : null;
        const consulta = res.consulta;
        fichaConsultaId = consulta ? consulta.id : null;

        const puedeEditar = cita.estado === 'en_consulta';
        fichaSoloLectura = !puedeEditar;

        document.getElementById('ficha_diagnostico').value = consulta?.diagnostico || '';
        document.getElementById('ficha_tratamiento').value = consulta?.tratamiento || '';
        document.getElementById('ficha_medicamentos').value = consulta?.medicamentos_recetados || '';
        document.getElementById('ficha_observaciones').value = consulta?.observaciones || '';
        document.getElementById('ficha_peso').value = consulta?.peso ?? '';
        document.getElementById('ficha_temperatura').value = consulta?.temperatura ?? '';

        ['ficha_diagnostico', 'ficha_tratamiento', 'ficha_medicamentos', 'ficha_observaciones', 'ficha_peso', 'ficha_temperatura']
          .forEach((id) => { document.getElementById(id).readOnly = fichaSoloLectura; });
        document.getElementById('btnGuardarFicha').style.display = puedeEditar ? 'inline-block' : 'none';

        const avisoEl = document.getElementById('ficha_solo_lectura_aviso');
        if (cita.estado === 'completada') {
          avisoEl.textContent = 'Esta cita ya está completada; la consulta es de solo lectura.';
          avisoEl.style.display = 'inline';
        } else if (!puedeEditar) {
          avisoEl.textContent = 'Esta cita aún no está en consulta; inícala desde la agenda para poder registrar el diagnóstico.';
          avisoEl.style.display = 'inline';
        } else {
          avisoEl.style.display = 'none';
        }

        document.getElementById('formArchivo').style.display = puedeEditar ? 'flex' : 'none';

        if (fichaConsultaId) {
          cargarArchivos();
        } else {
          document.getElementById('listaArchivos').innerHTML = '<p class="texto-tenue">Guarda la consulta primero para poder adjuntar archivos.</p>';
        }

        if (fichaMascotaId) cargarVacunas();

        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalFicha')).show();
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    document.getElementById('formFicha').addEventListener('submit', async (e) => {
      e.preventDefault();
      const citaId = document.getElementById('ficha_cita_id').value;
      const payload = {
        diagnostico: document.getElementById('ficha_diagnostico').value,
        tratamiento: document.getElementById('ficha_tratamiento').value,
        medicamentos_recetados: document.getElementById('ficha_medicamentos').value,
        observaciones: document.getElementById('ficha_observaciones').value,
        peso: document.getElementById('ficha_peso').value || null,
        temperatura: document.getElementById('ficha_temperatura').value || null,
      };

      try {
        if (fichaConsultaId) {
          await apiFetch(`/consultas/${fichaConsultaId}`, { method: 'PUT', body: JSON.stringify(payload) });
          mostrarAlerta('Consulta actualizada');
        } else {
          const res = await apiFetch(`/citas/${citaId}/consulta`, { method: 'POST', body: JSON.stringify(payload) });
          fichaConsultaId = res.consulta.id;
          mostrarAlerta('Consulta registrada');
          cargarArchivos();
        }
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
      }
    });

    // ---- Archivos ----
    async function cargarArchivos() {
      try {
        const res = await apiFetch(`/consultas/${fichaConsultaId}/archivos`);
        const lista = document.getElementById('listaArchivos');
        if (!res.data || res.data.length === 0) {
          lista.innerHTML = '<p class="texto-tenue">Sin archivos adjuntos.</p>';
          return;
        }
        lista.innerHTML = res.data.map((a) => `
          <div class="mb-1">
            <a href="/storage/${esc(a.ruta_archivo)}" target="_blank" class="text-info">${esc(a.nombre_archivo)}</a>
            <span class="badge bg-secondary">${esc(a.tipo)}</span>
          </div>
        `).join('');
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    document.getElementById('formArchivo').addEventListener('submit', async (e) => {
      e.preventDefault();
      if (!fichaConsultaId) {
        mostrarAlerta('Guarda la consulta antes de adjuntar archivos', 'warning');
        return;
      }
      const archivo = document.getElementById('ficha_archivo').files[0];
      if (!archivo) return;

      const formData = new FormData();
      formData.append('archivo', archivo);

      try {
        await apiFetch(`/consultas/${fichaConsultaId}/archivos`, { method: 'POST', body: formData });
        mostrarAlerta('Archivo adjuntado');
        document.getElementById('ficha_archivo').value = '';
        cargarArchivos();
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
      }
    });

    // ---- Vacunas ----
    async function cargarVacunas() {
      try {
        const res = await apiFetch(`/mascotas/${fichaMascotaId}/vacunas`);
        const lista = document.getElementById('listaVacunas');
        if (!res.data || res.data.length === 0) {
          lista.innerHTML = '<p class="texto-tenue">Sin vacunas registradas.</p>';
          return;
        }
        lista.innerHTML = res.data.map((v) => `
          <div class="mb-1">
            <strong>${esc(v.nombre_vacuna)}</strong> — Aplicada: ${soloFecha(v.fecha_aplicacion)}
            ${v.fecha_proxima_dosis ? ` — Próxima dosis: ${soloFecha(v.fecha_proxima_dosis)}` : ''}
          </div>
        `).join('');
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    document.getElementById('formVacuna').addEventListener('submit', async (e) => {
      e.preventDefault();
      const payload = {
        nombre_vacuna: document.getElementById('vacuna_nombre').value,
        fecha_aplicacion: document.getElementById('vacuna_fecha_aplicacion').value,
      };
      const proximaDosis = document.getElementById('vacuna_proxima_dosis').value;
      if (proximaDosis) payload.fecha_proxima_dosis = proximaDosis;
      if (fichaConsultaId) payload.consulta_id = fichaConsultaId;

      try {
        await apiFetch(`/mascotas/${fichaMascotaId}/vacunas`, { method: 'POST', body: JSON.stringify(payload) });
        mostrarAlerta('Vacuna registrada');
        document.getElementById('formVacuna').reset();
        cargarVacunas();
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
      }
    });

    // ============ LOGOUT Y CARGA INICIAL ============
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
