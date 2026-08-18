<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel del admin</title>
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

    .form-select:disabled,
    .form-control:disabled {
    background-color: #2a2a2a;
    color: #999999;
    border-color: #333333;
    opacity: 1; 
    }

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
        <li class="nav-item"><button class="nav-link" id="tabBtnDuenos" data-bs-toggle="tab" data-bs-target="#tab-gestionar-duenos" type="button">Gestionar dueños</button></li>
        <li class="nav-item"><button class="nav-link" id="tabBtnMascotas" data-bs-toggle="tab" data-bs-target="#tab-gestionar-mascotas" type="button">Gestionar mascotas</button></li>
        <li class="nav-item"><button class="nav-link" id="tabBtnCitas" data-bs-toggle="tab" data-bs-target="#tab-gestionar-citas" type="button">Gestionar citas</button></li>
        <li class="nav-item"><button class="nav-link" id="tabBtnInventario" data-bs-toggle="tab" data-bs-target="#tab-gestionar-inventario" type="button">Gestionar inventario</button></li>
        <li class="nav-item"><button class="nav-link" id="tabBtnReportes" data-bs-toggle="tab" data-bs-target="#tab-reportes" type="button">Gestionar reportes</button></li>
      </ul>

      <div class="tab-content mt-3">

        <!-- ===================== PERSONAL ===================== -->
        <div class="tab-pane fade show active" id="tab-gestionar-personal">
          <div class="d-flex gap-2 mb-3 flex-wrap">
            <input type="text" id="buscarEmpleado" class="form-control" style="max-width:620px" placeholder="Buscar empleado por su correo para restaurarlo o hacer otras acciones:">
            <button class="btn btn-outline-light" id="btnBuscarEmpleado">Buscar</button>
            <button class="btn btn-outline-secondary" id="btnLimpiarBusquedaEmpleado">Limpiar</button>
            <button type="button" class="btn btn-primary ms-auto" id="btnAgregarUsuario" data-bs-toggle="modal" data-bs-target="#modalUsuario">
              Agregar empleado
            </button>
            <button id="btnReintentarPersonal" class="btn btn-outline-warning d-none" type="button">Reintentar formulario('sin guardar')</button>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
              <thead class="table-dark">
                <tr><th>Nombre Completo</th><th>Correo</th><th>Rol</th><th>Estado</th><th>Acciones</th></tr>
              </thead>
              <tbody id="tablaUsuarios"></tbody>
            </table>
          </div>
        </div>

        <!-- ===================== DUEÑOS ===================== -->
        <div class="tab-pane fade" id="tab-gestionar-duenos">
  <div class="d-flex gap-2 mb-3 flex-wrap">
    <input type="text" id="buscarDueno" class="form-control" style="max-width:320px" placeholder="Buscar por nombre, correo o teléfono">
    <button class="btn btn-outline-light" id="btnBuscarDueno">Buscar</button>
    <button class="btn btn-outline-secondary" id="btnLimpiarBusquedaDueno">Limpiar</button>

    <input type="text" id="buscarDuenoCorreo" class="form-control" style="max-width:420px" placeholder="Buscar dueño por correo para restaurarlo">
    <button class="btn btn-outline-light" id="btnBuscarDuenoCorreo">Buscar por correo</button>
    <button class="btn btn-outline-secondary" id="btnLimpiarBusquedaDuenoCorreo">Limpiar</button>

    <button class="btn btn-primary ms-auto" id="btnAgregarDueno" data-bs-toggle="modal" data-bs-target="#modalDueno">Agregar dueño</button>
    <button id="btnReintentarDueno" class="btn btn-outline-warning d-none" type="button">Reintentar formulario('sin guardar')</button>
  </div>
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
              <thead class="table-dark">
               <tr><th>Nombre</th><th>Teléfono</th><th>Correo</th><th>Dirección</th><th>Estado</th><th>Acciones</th></tr>
              </thead>
              <tbody id="tablaDuenos"></tbody>
            </table>
          </div>
        </div>

        <!-- ===================== MASCOTAS ===================== -->
        <div class="tab-pane fade" id="tab-gestionar-mascotas">
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

        <!-- ===================== CITAS ===================== -->
        <div class="tab-pane fade" id="tab-gestionar-citas">
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

        <!-- ===================== INVENTARIO ===================== -->
        <div class="tab-pane fade" id="tab-gestionar-inventario">
          <div class="panel-card">
            <ul class="nav nav-tabs">
              <li class="nav-item"><button class="nav-link active" id="tabBtnProveedores" data-bs-toggle="tab" data-bs-target="#tab-gestionar-proveedores" type="button">Gestionar proveedores</button></li>
              <li class="nav-item"><button class="nav-link" id="tabBtnMedicamentos" data-bs-toggle="tab" data-bs-target="#tab-gestionar-medicamentos" type="button">Gestionar medicamentos</button></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade show active" id="tab-gestionar-proveedores">
                <div class="d-flex gap-2 mb-3 flex-wrap">
                  <input type="text" id="buscarProveedor" class="form-control" style="max-width:620px" placeholder="Buscar proveedor por su correo para restaurarlo o hacer otras acciones:">
                  <button class="btn btn-outline-light" id="btnBuscarProveedor">Buscar</button>
                  <button class="btn btn-outline-secondary" id="btnLimpiarBusquedaProveedor">Limpiar</button>
                  <button type="button" class="btn btn-primary ms-auto" id="btnAgregarProveedor" data-bs-toggle="modal" data-bs-target="#modalProveedor">
                    Agregar proveedor
                  </button>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                      <tr><th>Nombre</th><th>Telefono</th><th>Correo</th><th>Estado</th><th>Acciones</th></tr>
                    </thead>
                    <tbody id="tablaProveedores"></tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="tab-gestionar-medicamentos">
                <div class="d-flex gap-2 mb-3 flex-wrap">
                  <input type="text" id="buscarMedicamento" class="form-control" style="max-width:620px" placeholder="Buscar medicamento:">
                  <button class="btn btn-outline-light" id="btnBuscarMedicamento">Buscar</button>
                  <button class="btn btn-outline-secondary" id="btnLimpiarBusquedaMedicamento">Limpiar</button>
                  <button type="button" class="btn btn-primary ms-auto" id="btnAgregarMedicamento" data-bs-toggle="modal" data-bs-target="#modalMedicamento">
                    Agregar medicamento
                  </button>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                      <tr><th>Nombre</th><th>Tipo</th><th>Unidad</th><th>Cant. actual</th><th>Cant. mínima</th><th>Proveedor</th><th>Estado</th><th>Acciones</th></tr>
                    </thead>
                    <tbody id="tablaMedicamentos"></tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===================== REPORTES (pendiente) ===================== -->
      <div class="tab-pane fade" id="tab-reportes">
          <div class="row g-2 mb-4 align-items-end">
          <div class="col-auto">
          <label class="form-label small mb-0">Fecha inicio (periodo)</label>
          <input type="date" id="reporte_fecha_inicio" class="form-control">
      </div>
      <div class="col-auto">
          <label class="form-label small mb-0">Fecha fin (periodo)</label>
          <input type="date" id="reporte_fecha_fin" class="form-control">
      </div>
      <div class="col-auto">
          <label class="form-label small mb-0">Fecha (resumen del día)</label>
          <input type="date" id="reporte_fecha_dia" class="form-control">
      </div>
      <div class="col-auto">
          <label class="form-label small mb-0">Veterinario</label>
          <select id="reporte_veterinario_id" class="form-select">
          <option value="">Todos</option>
          </select>
      </div>
      <div class="col-auto">
          <label class="form-label small mb-0">Especie</label>
          <select id="reporte_especie" class="form-select">
          <option value="">Todas</option>
      </select>
      </div>
      </div>
      <p class="text-secondary small">Cada tarjeta usa solo los filtros que le aplican.</p>

      <div class="row g-3" id="tarjetasReportes"></div>
      </div>


      </div>
    </div>
  </div>

  <!-- ===================== MODALES ===================== -->

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
              <input type="text" id="usuario_nombre" class="form-control" required
              maxlength="160"
              pattern="[A-Za-zÀ-ÿÑñ'-]{2,50}(\s[A-Za-zÀ-ÿÑñ'-]{2,50}){1,}"
              title="Debe incluir al menos nombre y apellido, cada uno con 3 a 50 letras."
              placeholder="Nombre Apellido">
            <div class="form-text">Nombre y al menos un apellido (mínimo 3 letras cada uno).</div>
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
              <div class="input-group">
              <input type="password" id="usuario_contrasena" class="form-control" autocomplete="new-password">
              <button type="button" class="btn btn-outline-secondary" id="btnTogglePass" tabindex="-1">
              <i class="bi bi-eye" id="iconTogglePass"></i>
              </button>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label" id="usuario_contrasena_confirm_label">Confirmar contraseña</label>
              <div class="input-group">
              <input type="password" id="usuario_contrasena_confirm" class="form-control" autocomplete="new-password">
              <button type="button" class="btn btn-outline-secondary" id="btnTogglePassConfirm" tabindex="-1">
              <i class="bi bi-eye" id="iconTogglePassConfirm"></i>
              </button>
              </div>
              <div class="invalid-feedback d-block d-none" id="errorContrasenaMatch">
              Las contraseñas no coinciden
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="btnCancelarPersonal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

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
              <input required class="form-control" id="dueno_nombre" 
              maxlength="160"
              pattern="[A-Za-zÀ-ÿÑñ'-]{2,50}(\s[A-Za-zÀ-ÿÑñ'-]{2,50}){1,}"
              title="Debe incluir al menos nombre y apellido, cada uno con 3 a 50 letras."
              placeholder="Nombre Apellido">
              <div class="form-text">Nombre y al menos un apellido (mínimo 3 letras cada uno).</div>
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
              <div class="input-group">
              <input type="password" id="dueno_contrasena" class="form-control" autocomplete="new-password">
              <button type="button" class="btn btn-outline-secondary" id="btnTogglePassDueno" tabindex="-1">
              <i class="bi bi-eye" id="iconTogglePassDueno"></i>
              </button>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label" id="dueno_contrasena_confirm_label">Confirmar contraseña</label>
              <div class="input-group">
              <input type="password" id="dueno_contrasena_confirm" class="form-control" autocomplete="new-password">
              <button type="button" class="btn btn-outline-secondary" id="btnTogglePassConfirmDueno" tabindex="-1">
              <i class="bi bi-eye" id="iconTogglePassConfirmDueno"></i>
              </button>
              </div>
              <div class="invalid-feedback d-block d-none" id="errorContrasenaMatchDueno">
              Las contraseñas no coinciden
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="btnCancelarDueno">Cerrar</button>
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

  <div class="modal fade" id="modalProveedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content modal-content-veterinaria">
        <div class="modal-header">
          <h5 class="modal-title" id="modalProveedorTitulo">Agregar proveedor</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form id="formProveedor">
          <div class="modal-body">
            <input type="hidden" id="proveedor_id">
            <div class="mb-3">
              <label class="form-label">Nombre</label>
              <input type="text" id="proveedor_nombre" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Telefono</label>
              <input type="tel" id="proveedor_telefono" class="form-control" required maxlength="10" pattern="\d{10}" inputmode="numeric">
            </div>
            <div class="mb-3">
              <label class="form-label">Correo</label>
              <input type="email" id="proveedor_correo" class="form-control" required>
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

  <div class="modal fade" id="modalVerProveedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content modal-content-veterinaria">
        <div class="modal-header">
          <h5 class="modal-title">Detalles del Proveedor</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p><strong>Nombre:</strong> <span id="ver_proveedor_nombre"></span></p>
          <p><strong>Telefono:</strong> <span id="ver_proveedor_telefono"></span></p>
          <p><strong>Correo:</strong> <span id="ver_proveedor_correo"></span></p>
          <p><strong>Estado:</strong> <span id="ver_proveedor_estado"></span></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Agregar/Editar Medicamento -->
  <div class="modal fade" id="modalMedicamento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content modal-content-veterinaria bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="modalMedicamentoTitulo">Agregar medicamento</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form id="formMedicamento">
          <div class="modal-body">
            <input type="hidden" id="medicamento_id">
            <div class="mb-3">
              <label class="form-label">Nombre</label>
              <input type="text" id="medicamento_nombre" class="form-control" required maxlength="150">
            </div>
            <div class="mb-3">
              <label class="form-label">Tipo</label>
              <select id="medicamento_tipo" class="form-select" required>
              <option value="">Selecciona un tipo</option>
              <option value="Inyectable">Inyectable</option>
              <option value="Tableta">Tableta</option>
              <option value="Jarabe">Jarabe</option>
              <option value="Ungüento">Ungüento</option>
              <option value="Gotas">Gotas</option>
              <option value="Otro">Otro</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Unidad de medida</label>
              <select id="medicamento_unidad" class="form-select" required>
              <option value="">Selecciona una unidad</option>
              <option value="ml">Mililitros (ml)</option>
              <option value="mg">Miligramos (mg)</option>
              <option value="tabletas">Tabletas</option>
              <option value="cajas">Cajas</option>
              <option value="frascos">Frascos</option>
              </select>
            </div>
            <div class="mb-3" id="medicamento_cantidad_actual_grupo">
              <label class="form-label">Cantidad actual (inicial)</label>
              <input type="number" id="medicamento_cantidad_actual" class="form-control" required min="0" step="0.01" value="0">
              <div class="form-text">Para modificar el stock después de crear el medicamento, usa Entrada/Salida.</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Cantidad mínima de alerta</label>
              <input type="number" id="medicamento_cantidad_minima" class="form-control" required min="1" step="0.01" value="1">
            </div>
            <div class="mb-3">
              <label class="form-label">Proveedor</label>
              <select id="medicamento_proveedor_id" class="form-select">
                <option value="">Sin proveedor asignado</option>
              </select>
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

  <!-- Modal Entrada/Salida de stock -->
  <div class="modal fade" id="modalMovimiento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content modal-content-veterinaria bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="modalMovimientoTitulo">Registrar movimiento</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <form id="formMovimiento">
          <div class="modal-body">
            <input type="hidden" id="movimiento_medicamento_id">
            <input type="hidden" id="movimiento_tipo">
            <p class="mb-2">Medicamento: <strong id="movimiento_medicamento_nombre"></strong></p>
            <div class="mb-3">
              <label class="form-label">Cantidad</label>
              <input type="number" id="movimiento_cantidad" class="form-control" required min="0.01" step="0.01">
            </div>
            <div class="mb-3">
              <label class="form-label">Motivo (opcional)</label>
              <input type="text" id="movimiento_motivo" class="form-control" maxlength="255">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" id="btnGuardarMovimiento">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Historial de movimientos (solo lectura) -->
  <div class="modal fade" id="modalHistorialMedicamento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content modal-content-veterinaria bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title">Historial de movimientos — <span id="historial_medicamento_nombre"></span></h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
              <thead class="table-dark">
                <tr><th>Fecha</th><th>Tipo</th><th>Cantidad</th><th>Motivo</th><th>Usuario</th></tr>
              </thead>
              <tbody id="tablaHistorialMedicamento"></tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="modalVerReporte" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content modal-content-veterinaria bg-dark text-white">
        <div class="modal-header">
        <h5 class="modal-title" id="verReporteTitulo">Reporte</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
      <div class="modal-body" id="verReporteContenido">
        <div class="text-center text-secondary py-4">Sin datos</div>
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

    // Activa una pestaña por el id de su botón (usado al saltar entre secciones)
    function activarTab(idBoton) {
      const boton = document.getElementById(idBoton);
      if (boton) bootstrap.Tab.getOrCreateInstance(boton).show();
    }

    // Devuelve solo la parte de fecha (YYYY-MM-DD) de un valor de fecha/fecha-hora
    function soloFecha(valor) {
      if (!valor) return '';
      return String(valor).slice(0, 10);
    }

    // Devuelve solo horas y minutos (HH:MM) de un valor de hora
    function soloHora(valor) {
      if (!valor) return '';
      return String(valor).slice(0, 5);
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

    // ============ EMPLEADOS / USUARIOS ============
    let usuariosCache = {};

    async function fetchEmpleados() {
      try {
        const res = await apiFetch('/usuarios');
        const lista = res.data ? res.data : res;
        renderEmpleados(lista);
      } catch (e) {
        mostrarAlerta(mensajeError(e), 'danger');
      }
    }

    function renderEmpleados(empleados) {
      usuariosCache = {};
      const tbody = document.getElementById('tablaUsuarios');

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

    document.getElementById('btnLogout').addEventListener('click', async () => {
      try {
        await apiFetch('/auth/usuarios/logout', { method: 'POST' });
      } catch (e) {}
      localStorage.removeItem('token_veterinaria');
      localStorage.removeItem('rol_usuario');
      window.location.href = '/';
    });

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

     //para poder borrar los datos del usuario en el formulario
    let UsuarioConDatosPendientes = false;

    document.getElementById('btnCancelarPersonal').addEventListener('click', () => {
      document.getElementById('formUsuario').reset();
      document.getElementById('usuario_id').value='';
      duenoConDatosPendientes=false;
      document.getElementById('btnReintentarPersonal').classList.add('d-none');
      document.getElementById('errorContrasenaMatch').classList.add('d-none');
      document.getElementById('usuario_contrasena_confirm').classList.remove('is-invalid');
      bootstrap.Modal.getOrCreateInstance(document.getElementById('modalUsuario')).hide();
    });

    //para en dado caso del mensaje de error del formulario del modal

    document.getElementById('btnReintentarPersonal').addEventListener('click', () => {
       bootstrap.Modal.getOrCreateInstance(document.getElementById('modalUsuario')).show();
    });

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
        document.getElementById('usuario_contrasena_confirm').required = false;
        document.getElementById('errorContrasenaMatch').classList.add('d-none');
        document.getElementById('usuario_contrasena_confirm').classList.remove('is-invalid');
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

    document.getElementById('formUsuario').addEventListener('submit', async (e) => {
      e.preventDefault();
      const id = document.getElementById('usuario_id').value;
      const payload = {
        nombre_completo: document.getElementById('usuario_nombre').value,
        correo: document.getElementById('usuario_correo').value,
        rol: document.getElementById('usuario_rol').value,
      };
      const contrasena = document.getElementById('usuario_contrasena').value;
      const contrasenaConfirmada=document.getElementById('usuario_contrasena_confirm').value;
      const errorContrasenaDiv=document.getElementById('errorContrasenaMatch');
      if(contrasena||contrasenaConfirmada){
     
      if(contrasena!==contrasenaConfirmada){
        errorContrasenaDiv.classList.remove('d-none');
        document.getElementById('usuario_contrasena_confirm').classList.add('is-invalid');
        return;
      }

      }
      errorContrasenaDiv.classList.add('d-none');
      document.getElementById('usuario_contrasena_confirm').classList.remove('is-invalid');
      
      if (contrasena) payload.contrasena = contrasena;

      try {
        if (id) {
          await apiFetch(`/usuarios/${id}`, { method: 'PUT', body: JSON.stringify(payload) });
          mostrarAlerta('Empleado actualizado correctamente');
        } else {
          await apiFetch('/usuarios', { method: 'POST', body: JSON.stringify(payload) });
          mostrarAlerta('Empleado registrado correctamente');
        }
        document.getElementById('formUsuario').reset();
        UsuarioConDatosPendientes=false;
        document.getElementById('btnReintentarPersonal').classList.add('d-none');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalUsuario')).hide();
        cargarDuenosCache();
        fetchEmpleados();
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
        UsuarioConDatosPendientes=true;
        document.getElementById('btnReintentarPersonal').classList.remove('d-none');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalUsuario')).hide()
      }
    });

    document.getElementById('btnAgregarUsuario').addEventListener('click', () => {
      document.getElementById('formUsuario').reset();
      document.getElementById('usuario_id').value = '';
      document.getElementById('modalUsuarioTitulo').innerText = 'Agregar empleado';
      document.getElementById('usuario_contrasena_label').innerText = 'Contraseña';
      document.getElementById('usuario_contrasena').required = true;
      document.getElementById('usuario_contrasena_confirm').required = true; 
      document.getElementById('errorContrasenaMatch').classList.add('d-none');
      document.getElementById('usuario_contrasena_confirm').classList.remove('is-invalid');
    });

    //funcion para poder ver la contraseña mediante el icono del ojito
    function verContrasenaIconoOjo(usuarios_id_contra, icon_toogle_id){
      const input=document.getElementById(usuarios_id_contra);
      const icono=document.getElementById(icon_toogle_id);
      const miContrasena=input.type==='password';
      input.type=miContrasena?'text':'password';
      icono.classList.toggle('bi-eye', !miContrasena);
      icono.classList.toggle('bi-eye-slash', miContrasena);
    }

    //en dado caso de que sea la contraseña que se active el ojito
    document.getElementById('btnTogglePass').addEventListener('click', () =>{
    verContrasenaIconoOjo('usuario_contrasena', 'iconTooglePass')
    });

    document.getElementById('btnTogglePassConfirm').addEventListener('click', () => {
     verContrasenaIconoOjo('usuario_contrasena_confirm', 'iconTooglePassConfirm')
    });

    // ============ DUEÑOS ============
    let duenosCache = {};
    let duenosCacheListo = null;

   
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

      if (!duenos || duenos.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7" class="text-center">No se encontraron dueños.</td></tr>`;
        return;
      }

      tbody.innerHTML = duenos.map((d) => {
        const esActivo = Boolean(d.activo);
        const botonEstado = esActivo
          ? `<button class="btn btn-sm btn-danger mb-1" data-accion="baja" data-id="${d.id}">Baja</button>`
          : `<button class="btn btn-sm btn-success mb-1" data-accion="reactivar" data-id="${d.id}">Reactivar</button>`;

        return `
          <tr>
            <td>${esc(d.nombre_completo)}</td>
            <td>${esc(d.telefono)}</td>
            <td>${esc(d.correo)}</td>
            <td>${esc(d.direccion || '')}</td>
            <td><span class="badge ${esActivo ? 'bg-success' : 'bg-secondary'}">${esActivo ? 'Activo' : 'Inactivo'}</span></td>
            <td>
              <button class="btn btn-sm btn-outline-light mb-1" data-accion="ver-mascotas" data-id="${d.id}">Mascotas</button>
              <button class="btn btn-sm btn-warning mb-1" data-accion="editar" data-id="${d.id}">Editar</button>
              ${botonEstado}
            </td>
          </tr>
        `;
      }).join('');
    }

    document.getElementById('btnBuscarDuenoCorreo').addEventListener('click', async () => {
      const correo = document.getElementById('buscarDuenoCorreo').value.trim();
      if (!correo) {
        mostrarAlerta('Ingresa un correo para buscar', 'warning');
        return;
      }
      try {
        const res = await apiFetch('/duenos/buscar-correo', {
          method: 'POST',
          body: JSON.stringify({ correo }),
        });
        if (res.data) {
          renderDuenos([res.data]);
        } else {
          mostrarAlerta('No se encontró ningún dueño con ese correo', 'info');
        }
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
      }
    });

    document.getElementById('btnBuscarDueno').addEventListener('click', fetchDuenos);
    document.getElementById('buscarDueno').addEventListener('keydown', (e) => { if (e.key === 'Enter') { e.preventDefault(); fetchDuenos(); } });
    document.getElementById('btnLimpiarBusquedaDueno').addEventListener('click', () => {
      document.getElementById('buscarDueno').value = '';
      fetchDuenos();
    });

    document.getElementById('btnLimpiarBusquedaDuenoCorreo').addEventListener('click', () => {
      document.getElementById('buscarDuenoCorreo').value = '';
      fetchDuenos();
    });

    document.getElementById('btnAgregarDueno').addEventListener('click', () => {
      document.getElementById('formDueno').reset();
      document.getElementById('dueno_id').value = '';
      document.getElementById('modalDuenoTitulo').innerText = 'Agregar dueño';
      document.getElementById('dueno_contrasena_label').innerText = 'Contraseña';
      document.getElementById('dueno_contrasena').required = true;
      document.getElementById('dueno_contrasena_confirm').required = true;
      document.getElementById('errorContrasenaMatchDueno').classList.add('d-none');
      document.getElementById('dueno_contrasena_confirm').classList.remove('is-invalid');
    });

    //para poder borrar los datos del dueño en el formulario
    let duenoConDatosPendientes = false;

    document.getElementById('btnCancelarDueno').addEventListener('click', () => {
      document.getElementById('formDueno').reset();
      document.getElementById('dueno_id').value='';
      duenoConDatosPendientes=false;
      document.getElementById('btnReintentarDueno').classList.add('d-none');
      document.getElementById('errorContrasenaMatchDueno').classList.add('d-none');
      document.getElementById('dueno_contrasena_confirm').classList.remove('is-invalid');
      bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDueno')).hide();
    });

    //para en dado caso del mensaje de error del formulario del modal

    document.getElementById('btnReintentarDueno').addEventListener('click', () => {
       bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDueno')).show();
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
        document.getElementById('dueno_contrasena_confirm').required = false;
        document.getElementById('errorContrasenaMatchDueno').classList.add('d-none');
        document.getElementById('dueno_contrasena_confirm').classList.remove('is-invalid');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDueno')).show();
      }

      if (boton.dataset.accion === 'baja') {
        if (confirm(`¿Dar de baja a ${dueno.nombre_completo}?`)) {
          apiFetch(`/duenos/${id}`, { method: 'DELETE' })
            .then(() => { mostrarAlerta('Dueño dado de baja'); fetchDuenos(); cargarDuenosCache(); })
            .catch((err) => mostrarAlerta(mensajeError(err), 'danger'));
        }
      }

      if (boton.dataset.accion === 'reactivar') {
        if (confirm(`¿Deseas reactivar a ${dueno.nombre_completo}?`)) {
          apiFetch(`/duenos/${id}/reactivar`, { method: 'PUT' })
            .then(() => { mostrarAlerta('Dueño reactivado'); fetchDuenos(); cargarDuenosCache(); })
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
      const contrasenaConfirmada=document.getElementById('dueno_contrasena_confirm').value;
      const errorContrasenaDiv=document.getElementById('errorContrasenaMatchDueno');
      if(contrasena||contrasenaConfirmada){
     
      if(contrasena!==contrasenaConfirmada){
        errorContrasenaDiv.classList.remove('d-none');
        document.getElementById('dueno_contrasena_confirm').classList.add('is-invalid');
        return;
      }

      }
      errorContrasenaDiv.classList.add('d-none');
      document.getElementById('dueno_contrasena_confirm').classList.remove('is-invalid');

      if (contrasena) payload.contrasena = contrasena;

      try {
        if (id) {
          await apiFetch(`/duenos/${id}`, { method: 'PUT', body: JSON.stringify(payload) });
          mostrarAlerta('Dueño actualizado');
        } else {
          await apiFetch('/duenos', { method: 'POST', body: JSON.stringify(payload) });
          mostrarAlerta('Dueño registrado');
        }
        document.getElementById('formDueno').reset();
        duenoConDatosPendientes=false;
        document.getElementById('btnReintentarDueno').classList.add('d-none');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDueno')).hide();
        fetchDuenos();
        cargarDuenosCache();
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
        duenoConDatosPendientes=true;
        document.getElementById('btnReintentarDueno').classList.remove('d-none');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDueno')).hide()
      }
    });

     //funcion para poder ver la contraseña mediante el icono del ojito
    function verContrasenaIconoOjoDueno(duenos_id_contra, icon_dueno_toogle_id){
      const input=document.getElementById(duenos_id_contra);
      const icono=document.getElementById(icon_dueno_toogle_id);
      const miContrasena=input.type==='password';
      input.type=miContrasena?'text':'password';
      icono.classList.toggle('bi-eye', !miContrasena);
      icono.classList.toggle('bi-eye-slash', miContrasena);
    }

    //en dado caso de que sea la contraseña que se active el ojito
    document.getElementById('btnTogglePassDueno').addEventListener('click', () =>{
    verContrasenaIconoOjo('dueno_contrasena', 'iconTooglePassDueno')
    });

    document.getElementById('btnTogglePassConfirmDueno').addEventListener('click', () => {
     verContrasenaIconoOjo('dueno_contrasena_confirm', 'iconTooglePassConfirmDueno')
    });

    // ============ MASCOTAS ============
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
  if (duenosCacheListo) await duenosCacheListo; 

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

      if (!mascotas || mascotas.length === 0) {
        tbody.innerHTML = `<tr><td colspan="10" class="text-center">No se encontraron mascotas.</td></tr>`;
        return;
      }

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

    // ============ CITAS ============
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

      if (!citas || citas.length === 0) {
        tbody.innerHTML = `<tr><td colspan="9" class="text-center">No se encontraron citas.</td></tr>`;
        return;
      }

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
    
   // Proveedor
let proveedoresCache = {};

async function fetchProveedores() {
  try {
    const res = await apiFetch('/proveedores');
    const lista = res.data ? res.data : res;
    renderProveedores(lista);
  } catch (e) {
    mostrarAlerta(mensajeError(e), 'danger');
  }
}

function renderProveedores(proveedores) {
  proveedoresCache = {};
  const tbody = document.getElementById('tablaProveedores');

  if (!proveedores || proveedores.length === 0) {
    tbody.innerHTML = `<tr><td colspan="5" class="text-center">No se encontraron proveedores.</td></tr>`;
    return;
  }

  tbody.innerHTML = proveedores.map((p) => {
    proveedoresCache[p.id] = p;
    const esActivo = Boolean(p.activo);

    const botonEstado = esActivo
      ? `<button class="btn btn-danger btn-sm mb-1" data-accion="baja" data-id="${p.id}">Dar de baja</button>`
      : `<button class="btn btn-success btn-sm mb-1" data-accion="reactivar" data-id="${p.id}">Reactivar</button>`;

    return `
      <tr>
        <td>${esc(p.nombre)}</td>
        <td>${esc(p.telefono)}</td>
        <td>${esc(p.correo)}</td>
        <td><span class="badge ${esActivo ? 'bg-success' : 'bg-secondary'}">${esActivo ? 'Activo' : 'Inactivo'}</span></td>
        <td>
          <button class="btn btn-info btn-sm text-white mb-1" data-accion="ver" data-id="${p.id}">Ver</button>
          <button class="btn btn-warning btn-sm mb-1" data-accion="editar" data-id="${p.id}">Modificar</button>
          ${botonEstado}
        </td>
      </tr>
    `;
  }).join('');
}

document.getElementById('btnBuscarProveedor').addEventListener('click', async () => {
  const correo = document.getElementById('buscarProveedor').value.trim();

  if (!correo) {
    mostrarAlerta('Ingresa un correo para buscar', 'warning');
    return;
  }

  try {
    const res = await apiFetch('/proveedores/buscar-correo', {
      method: 'POST',
      body: JSON.stringify({ correo: correo })
    });

    const proveedorEncontrado = res.data;

    if (proveedorEncontrado) {
      renderProveedores([proveedorEncontrado]);
    } else {
      mostrarAlerta('No se encontró ningún proveedor con ese correo', 'info');
    }
  } catch (err) {
    mostrarAlerta(mensajeError(err), 'danger');
  }
});

document.getElementById('btnLimpiarBusquedaProveedor').addEventListener('click', () => {
  document.getElementById('buscarProveedor').value = '';
  fetchProveedores();
});

document.getElementById('tablaProveedores').addEventListener('click', (e) => {
  const boton = e.target.closest('button[data-accion]');
  if (!boton) return;
  const id = boton.dataset.id;
  const accion = boton.dataset.accion;
  const proveedor = proveedoresCache[id];

  if (!proveedor) return;

 if (accion === 'ver') {
  document.getElementById('ver_proveedor_nombre').innerText = proveedor.nombre;
  document.getElementById('ver_proveedor_telefono').innerText = proveedor.telefono;
  document.getElementById('ver_proveedor_correo').innerText = proveedor.correo;
  document.getElementById('ver_proveedor_estado').innerText = proveedor.activo ? 'Activo' : 'Inactivo';
  bootstrap.Modal.getOrCreateInstance(document.getElementById('modalVerProveedor')).show();
}

if (accion === 'editar') {
  document.getElementById('formProveedor').reset();
  document.getElementById('proveedor_id').value = proveedor.id;
  document.getElementById('proveedor_nombre').value = proveedor.nombre;
  document.getElementById('proveedor_telefono').value = proveedor.telefono;
  document.getElementById('proveedor_correo').value = proveedor.correo;
  document.getElementById('modalProveedorTitulo').innerText = 'Actualizar proveedor';
  bootstrap.Modal.getOrCreateInstance(document.getElementById('modalProveedor')).show();
}

  if (accion === 'baja') {
    if (confirm(`¿Dar de baja a ${proveedor.nombre}?`)) {
      apiFetch(`/proveedores/${id}`, { method: 'DELETE' })
        .then(() => {
          mostrarAlerta('Proveedor dado de baja correctamente');
          fetchProveedores();
        })
        .catch((err) => mostrarAlerta(mensajeError(err), 'danger'));
    }
  }

  if (accion === 'reactivar') {
    if (confirm('¿Deseas reactivar a este proveedor?')) {
      apiFetch(`/proveedores/${id}/reactivar`, { method: 'PUT' })
        .then(() => {
          mostrarAlerta('Proveedor reactivado con éxito');
          fetchProveedores();
        })
        .catch((err) => mostrarAlerta(mensajeError(err), 'danger'));
    }
  }
});

document.getElementById('formProveedor').addEventListener('submit', async (e) => {
  e.preventDefault();
  const id = document.getElementById('proveedor_id').value;
  const payload = {
    nombre: document.getElementById('proveedor_nombre').value,
    telefono: document.getElementById('proveedor_telefono').value,
    correo: document.getElementById('proveedor_correo').value,
  };

  try {
    if (id) {
      await apiFetch(`/proveedores/${id}`, { method: 'PUT', body: JSON.stringify(payload) });
      mostrarAlerta('Proveedor actualizado correctamente');
    } else {
      await apiFetch('/proveedores', { method: 'POST', body: JSON.stringify(payload) });
      mostrarAlerta('Proveedor registrado correctamente');
    }
    bootstrap.Modal.getOrCreateInstance(document.getElementById('modalProveedor')).hide();
    fetchProveedores();
  } catch (err) {
    mostrarAlerta(mensajeError(err), 'danger');
  }
});

document.getElementById('btnAgregarProveedor').addEventListener('click', () => {
  document.getElementById('formProveedor').reset();
  document.getElementById('proveedor_id').value = '';
  document.getElementById('modalProveedorTitulo').innerText = 'Agregar proveedor';
});

document.getElementById('tabBtnProveedores').addEventListener('click', () => {
  if (Object.keys(proveedoresCache).length === 0) fetchProveedores();
});

document.getElementById('tabBtnInventario').addEventListener('click', () => {
  if (Object.keys(medicamentosCache).length === 0) fetchMedicamentos();
  if (Object.keys(proveedoresCache).length === 0) fetchProveedores();
});

// ============ MEDICAMENTOS ============
let medicamentosCache = {};

async function fetchMedicamentos() {
  try {
    const res = await apiFetch('/medicamentos');
    const lista = res.data ? res.data : res;
    renderMedicamentos(lista);
  } catch (e) {
    mostrarAlerta(mensajeError(e), 'danger');
  }
}

function renderMedicamentos(medicamentos) {
  medicamentosCache = {};
  const tbody = document.getElementById('tablaMedicamentos');

  if (!medicamentos || medicamentos.length === 0) {
    tbody.innerHTML = `<tr><td colspan="8" class="text-center">No se encontraron medicamentos.</td></tr>`;
    return;
  }

  tbody.innerHTML = medicamentos.map((m) => {
    medicamentosCache[m.id] = m;
    const esActivo = Boolean(m.activo);
    const stockBajo = Boolean(m.stock_bajo);
    const proveedorNombre = m.proveedor ? m.proveedor.nombre : '<span class="text-secondary">—</span>';

    const botonEstado = esActivo
      ? `<button class="btn btn-danger btn-sm mb-1" data-accion="baja" data-id="${m.id}">Dar de baja</button>`
      : `<button class="btn btn-success btn-sm mb-1" data-accion="reactivar" data-id="${m.id}">Reactivar</button>`;

    return `
      <tr>
        <td>${esc(m.nombre)}</td>
        <td>${esc(m.tipo)}</td>
        <td>${esc(m.unidad_medida)}</td>
        <td>${esc(m.cantidad_actual)} ${stockBajo ? '<span class="badge bg-danger ms-1">Stock bajo</span>' : ''}</td>
        <td>${esc(m.cantidad_minima_alerta)}</td>
        <td>${m.proveedor ? esc(m.proveedor.nombre) : '<span class="text-secondary">—</span>'}</td>
        <td><span class="badge ${esActivo ? 'bg-success' : 'bg-secondary'}">${esActivo ? 'Activo' : 'Inactivo'}</span></td>
        <td>
          <button class="btn btn-info btn-sm text-white mb-1" data-accion="entrada" data-id="${m.id}">Entrada</button>
          <button class="btn btn-warning btn-sm mb-1" data-accion="salida" data-id="${m.id}">Salida</button>
          <button class="btn btn-outline-light btn-sm mb-1" data-accion="historial" data-id="${m.id}">Historial</button>
          <button class="btn btn-secondary btn-sm mb-1" data-accion="editar" data-id="${m.id}">Editar</button>
          ${botonEstado}
        </td>
      </tr>
    `;
  }).join('');
}

async function cargarProveedoresSelect() {
  try {
    const res = await apiFetch('/proveedores');
    const select = document.getElementById('medicamento_proveedor_id');
    select.innerHTML = '<option value="">Sin proveedor asignado</option>';
    res.data.forEach((p) => {
      select.innerHTML += `<option value="${p.id}">${esc(p.nombre)}</option>`;
    });
  } catch (e) {
    mostrarAlerta(mensajeError(e), 'danger');
  }
}

document.getElementById('btnBuscarMedicamento').addEventListener('click', async () => {
  const nombre = document.getElementById('buscarMedicamento').value.trim();

  if (!nombre) {
    mostrarAlerta('Ingresa un nombre para buscar', 'warning');
    return;
  }

  try {
    const res = await apiFetch('/medicamentos/buscar-nombre', {
      method: 'POST',
      body: JSON.stringify({ nombre })
    });

    const medicamentoEncontrado = res.data;

    if (medicamentoEncontrado) {
      renderMedicamentos([medicamentoEncontrado]);
    } else {
      mostrarAlerta('No se encontró ningún medicamento con ese nombre', 'info');
    }
  } catch (err) {
    mostrarAlerta(mensajeError(err), 'danger');
  }
});

document.getElementById('buscarMedicamento').addEventListener('keydown', (e) => { if (e.key === 'Enter') { e.preventDefault(); fetchMedicamentos(); } });

document.getElementById('btnLimpiarBusquedaMedicamento').addEventListener('click', () => {
  document.getElementById('buscarMedicamento').value = '';
  fetchMedicamentos();
});

document.getElementById('btnAgregarMedicamento').addEventListener('click', async () => {
  document.getElementById('formMedicamento').reset();
  document.getElementById('medicamento_id').value = '';
  document.getElementById('modalMedicamentoTitulo').innerText = 'Agregar medicamento';
  document.getElementById('medicamento_cantidad_actual_grupo').style.display = 'block';
  document.getElementById('medicamento_cantidad_actual').required = true;
  await cargarProveedoresSelect();
});

document.getElementById('tablaMedicamentos').addEventListener('click', async (e) => {
  const boton = e.target.closest('button[data-accion]');
  if (!boton) return;
  const id = boton.dataset.id;
  const accion = boton.dataset.accion;
  const medicamento = medicamentosCache[id];

  if (!medicamento) return;

  if (accion === 'editar') {
    document.getElementById('formMedicamento').reset();
    await cargarProveedoresSelect();
    document.getElementById('medicamento_id').value = medicamento.id;
    document.getElementById('medicamento_nombre').value = medicamento.nombre;
    document.getElementById('medicamento_tipo').value = medicamento.tipo;
    document.getElementById('medicamento_unidad').value = medicamento.unidad_medida;
    document.getElementById('medicamento_cantidad_minima').value = medicamento.cantidad_minima_alerta;
    document.getElementById('medicamento_proveedor_id').value = medicamento.proveedor_id || '';
    // La cantidad actual solo se ajusta vía Entrada/Salida, no se edita aquí.
    document.getElementById('medicamento_cantidad_actual_grupo').style.display = 'none';
    document.getElementById('medicamento_cantidad_actual').required = false;
    document.getElementById('modalMedicamentoTitulo').innerText = `Editar medicamento — ${medicamento.nombre}`;
    bootstrap.Modal.getOrCreateInstance(document.getElementById('modalMedicamento')).show();
  }

  if (accion === 'baja') {
    if (confirm(`¿Dar de baja a ${medicamento.nombre}?`)) {
      apiFetch(`/medicamentos/${id}`, { method: 'DELETE' })
        .then(() => { mostrarAlerta('Medicamento dado de baja'); fetchMedicamentos(); })
        .catch((err) => mostrarAlerta(mensajeError(err), 'danger'));
    }
  }

  if (accion === 'entrada' || accion === 'salida') {
    document.getElementById('formMovimiento').reset();
    document.getElementById('movimiento_medicamento_id').value = medicamento.id;
    document.getElementById('movimiento_tipo').value = accion;
    document.getElementById('movimiento_medicamento_nombre').innerText = medicamento.nombre;
    document.getElementById('modalMovimientoTitulo').innerText = accion === 'entrada' ? 'Registrar entrada' : 'Registrar salida';
    document.getElementById('btnGuardarMovimiento').className = accion === 'entrada' ? 'btn btn-success' : 'btn btn-warning';
    bootstrap.Modal.getOrCreateInstance(document.getElementById('modalMovimiento')).show();
  }

  if (accion === 'historial') {
    try {
      const res = await apiFetch(`/medicamentos/${id}/movimientos`);
      renderHistorialMedicamento(res.data, medicamento.nombre);
      bootstrap.Modal.getOrCreateInstance(document.getElementById('modalHistorialMedicamento')).show();
    } catch (err) {
      mostrarAlerta(mensajeError(err), 'danger');
    }
  }
});

function renderHistorialMedicamento(movimientos, nombreMedicamento) {
  document.getElementById('historial_medicamento_nombre').innerText = nombreMedicamento;
  const tbody = document.getElementById('tablaHistorialMedicamento');

  if (!movimientos || movimientos.length === 0) {
    tbody.innerHTML = `<tr><td colspan="5" class="text-center">Sin movimientos registrados.</td></tr>`;
    return;
  }

  tbody.innerHTML = movimientos.map((mv) => {
    const badge = mv.tipo === 'entrada' ? 'bg-success' : 'bg-warning';
    return `
      <tr>
        <td>${soloFecha(mv.fecha)} ${soloHora(mv.fecha)}</td>
        <td><span class="badge ${badge}">${esc(mv.tipo)}</span></td>
        <td>${esc(mv.cantidad)}</td>
        <td>${esc(mv.motivo || '')}</td>
        <td>${mv.usuario ? esc(mv.usuario.nombre_completo) : ''}</td>
      </tr>
    `;
  }).join('');
}

document.getElementById('formMedicamento').addEventListener('submit', async (e) => {
  e.preventDefault();
  const id = document.getElementById('medicamento_id').value;
  const payload = {
    nombre: document.getElementById('medicamento_nombre').value,
    tipo: document.getElementById('medicamento_tipo').value,
    unidad_medida: document.getElementById('medicamento_unidad').value,
    cantidad_minima_alerta: document.getElementById('medicamento_cantidad_minima').value,
    proveedor_id: document.getElementById('medicamento_proveedor_id').value || null,
  };

  if (!id) {
    payload.cantidad_actual = document.getElementById('medicamento_cantidad_actual').value;
  }

  try {
    if (id) {
      await apiFetch(`/medicamentos/${id}`, { method: 'PUT', body: JSON.stringify(payload) });
      mostrarAlerta('Medicamento actualizado correctamente');
    } else {
      await apiFetch('/medicamentos', { method: 'POST', body: JSON.stringify(payload) });
      mostrarAlerta('Medicamento registrado correctamente');
    }
    bootstrap.Modal.getOrCreateInstance(document.getElementById('modalMedicamento')).hide();
    fetchMedicamentos();
  } catch (err) {
    mostrarAlerta(mensajeError(err), 'danger');
  }
});

document.getElementById('formMovimiento').addEventListener('submit', async (e) => {
  e.preventDefault();
  const medicamentoId = document.getElementById('movimiento_medicamento_id').value;
  const tipo = document.getElementById('movimiento_tipo').value;
  const payload = {
    cantidad: document.getElementById('movimiento_cantidad').value,
    motivo: document.getElementById('movimiento_motivo').value,
  };

  try {
    await apiFetch(`/medicamentos/${medicamentoId}/${tipo}`, { method: 'POST', body: JSON.stringify(payload) });
    mostrarAlerta(tipo === 'entrada' ? 'Entrada registrada correctamente' : 'Salida registrada correctamente');
    bootstrap.Modal.getOrCreateInstance(document.getElementById('modalMovimiento')).hide();
    fetchMedicamentos();
  } catch (err) {
    mostrarAlerta(mensajeError(err), 'danger');
  }
});

document.getElementById('tabBtnInventario').addEventListener('click', () => {
  if (Object.keys(medicamentosCache).length === 0) fetchMedicamentos();
});

//Reportes
const REPORTES=[
  {id:'resumen-del-dia', titulo:"Resumen del dia", filtros:['fecha']},
  {id:'consultas-por-periodo', titulo:"Consultas por periodo", filtros:['fecha_inicio', 'fecha_fin', 'veterinario_id', 'especie']},
  {id:'motivos-frecuentes', titulo:"Motivos frecuentes", filtros:['fecha_inicio', 'fecha_fin', 'veterinario_id']},
  {id:'vacunas-por-vencer', titulo:"Vacunas por vencer", filtros:['especie']},
  {id:'medicamentos-stock-bajo', titulo:"Medicamentos con stock bajo", filtros:[]},
];

  function renderizarTarjetasReportes() {
  const contenedor = document.getElementById('tarjetasReportes');
  contenedor.innerHTML = REPORTES.map((r) => `
    <div class="col-md-6 col-lg-4">
      <div class="panel-card h-100 d-flex flex-column">
        <h6 class="mb-3">${esc(r.titulo)}</h6>
        <div class="mt-auto d-flex gap-2 flex-wrap">
          <button class="btn btn-outline-light btn-sm" data-accion="ver" data-reporte="${r.id}">
            <i class="bi bi-eye"></i> Ver
          </button>
          <button class="btn btn-outline-danger btn-sm" data-accion="pdf" data-reporte="${r.id}">
            <i class="bi bi-file-earmark-pdf"></i> PDF
          </button>
          <button class="btn btn-outline-success btn-sm" data-accion="excel" data-reporte="${r.id}">
            <i class="bi bi-file-earmark-excel"></i> Excel
          </button>
        </div>
      </div>
    </div>
  `).join('');
}

function construirParamsReporte(reporte) {
  const params = new URLSearchParams();
  const mapaCampos = {
    fecha_inicio: 'reporte_fecha_inicio',
    fecha_fin: 'reporte_fecha_fin',
    fecha: 'reporte_fecha_dia',
    veterinario_id: 'reporte_veterinario_id',
    especie: 'reporte_especie',
  };

  reporte.filtros.forEach((campo) => {
    const valor = document.getElementById(mapaCampos[campo]).value;
    if (valor) params.set(campo, valor);
  });

  return params.toString();
}

async function poblarFiltroEspecieReportes() {
  const select = document.getElementById('reporte_especie');
  select.innerHTML = '<option value="">Todas</option>' +
    Object.entries(ESPECIES).map(([valor, etiqueta]) => `<option value="${valor}">${esc(etiqueta)}</option>`).join('');
}

async function poblarFiltroVeterinarioReportes() {
  try {
    const res = await apiFetch('/veterinarios');
    const select = document.getElementById('reporte_veterinario_id');
    select.innerHTML = '<option value="">Todos</option>' +
      res.data.map((v) => `<option value="${v.id}">${esc(v.nombre_completo)}</option>`).join('');
  } catch (e) {
    mostrarAlerta(mensajeError(e), 'danger');
  }
}

 async function conEstadoCarga(boton, textoCargando, tarea) {
  const contenidoOriginal = boton.innerHTML;
  boton.disabled = true;
  boton.innerHTML = `<span class="spinner-border spinner-border-sm"></span> ${textoCargando}`;
  try {
    await tarea();
  } finally {
    boton.disabled = false;
    boton.innerHTML = contenidoOriginal;
  }
}

  async function descargarArchivoReporte(path, nombreArchivo) {
  const res = await fetch(`/api${path}`, {
    headers: { Authorization: `Bearer ${token}` },
  });

  if (res.status === 401) {
    localStorage.removeItem('token_veterinaria');
    localStorage.removeItem('rol_usuario');
    window.location.href = '/';
    throw new Error('No autenticado');
  }

  if (!res.ok) {
    let mensaje = 'No se pudo generar el archivo';
    try {
      const data = await res.json();
      mensaje = data.mensaje || mensaje;
    } catch (e) {}
    throw new Error(mensaje);
  }

  const blob = await res.blob();
  const url = URL.createObjectURL(blob);
  const enlace = document.createElement('a');
  enlace.href = url;
  enlace.download = nombreArchivo;
  document.body.appendChild(enlace);
  enlace.click();
  enlace.remove();
  URL.revokeObjectURL(url);
}

function tablaSimple(columnas, filas) {
  if (!filas || filas.length === 0) return '<p class="text-secondary">Sin registros.</p>';
  return `
    <table class="table table-striped table-sm">
      <thead><tr>${columnas.map((c) => `<th>${esc(c)}</th>`).join('')}</tr></thead>
      <tbody>${filas.map((fila) => `<tr>${fila.map((v) => `<td>${esc(v)}</td>`).join('')}</tr>`).join('')}</tbody>
    </table>
  `;
}

const RENDERIZADORES_REPORTE = {
  'resumen-del-dia': (json) => {
    const d = json.data || {};
    return tablaSimple(['Estado', 'Total'], [
      ['Agendadas', d.agendadas],
      ['Confirmadas', d.confirmadas],
      ['En consulta', d.en_consulta],
      ['Completadas', d.completadas],
      ['Canceladas', d.canceladas],
    ]);
  },

  'consultas-por-periodo': (json) => `
    <h6 class="text-uppercase text-secondary">Por veterinario</h6>
    ${tablaSimple(['Veterinario', 'Total'], (json.por_veterinario || []).map((f) => [f.veterinario, f.total]))}
    <h6 class="text-uppercase text-secondary mt-4">Por especie</h6>
    ${tablaSimple(['Especie', 'Total'], (json.por_especie || []).map((f) => [f.especie, f.total]))}
  `,

  'motivos-frecuentes': (json) =>
    tablaSimple(['Motivo', 'Total'], (json.data || []).map((f) => [f.motivo, f.total])),

  'vacunas-por-vencer': (json) =>
    tablaSimple(
      ['Mascota', 'Especie', 'Vacuna', 'Próxima dosis'],
      (json.data || []).map((v) => [
        v.mascota ? v.mascota.nombre : '',
        v.mascota ? v.mascota.especie : '',
        v.nombre_vacuna,
        soloFecha(v.fecha_proxima_dosis),
      ])
    ),

  'medicamentos-stock-bajo': (json) =>
    tablaSimple(
      ['Nombre', 'Tipo', 'Cant. actual', 'Cant. mínima'],
      (json.data || []).map((m) => [m.nombre, m.tipo, m.cantidad_actual, m.cantidad_minima_alerta])
    ),
};

document.getElementById('tarjetasReportes').addEventListener('click', async (e) => {
  const boton = e.target.closest('button[data-accion]');
  if (!boton) return;

  const reporte = REPORTES.find((r) => r.id === boton.dataset.reporte);
  if (!reporte) return;

  const accion = boton.dataset.accion;
  const params = construirParamsReporte(reporte);
  const query = params ? `?${params}` : '';

  if (accion === 'ver') {
    await conEstadoCarga(boton, 'Cargando...', async () => {
      try {
        const json = await apiFetch(`/reportes/${reporte.id}${query}`);
        document.getElementById('verReporteTitulo').innerText = reporte.titulo;
        document.getElementById('verReporteContenido').innerHTML = RENDERIZADORES_REPORTE[reporte.id](json);
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalVerReporte')).show();
      } catch (err) {
        mostrarAlerta(mensajeError(err), 'danger');
      }
    });
  }

  if (accion === 'pdf' || accion === 'excel') {
    const extension = accion === 'pdf' ? 'pdf' : 'xlsx';
    await conEstadoCarga(boton, 'Generando...', async () => {
      try {
        await descargarArchivoReporte(`/reportes/${reporte.id}/${accion}${query}`, `${reporte.id}.${extension}`);
        mostrarAlerta('Archivo generado correctamente');
      } catch (err) {
        mostrarAlerta(err.message, 'danger');
      }
    });
  }
});

document.getElementById('tabBtnReportes').addEventListener('click', () => {
  if (document.getElementById('reporte_veterinario_id').options.length <= 1) {
    poblarFiltroVeterinarioReportes();
  }
});

    // ============ CARGA INICIAL ============
    document.addEventListener('DOMContentLoaded', () => {
      try {
        const payload = JSON.parse(atob(token.split('.')[1]));
        document.getElementById('nombre-usuario').innerText = payload.nombre_completo || 'Usuario';
      } catch (e) {
        document.getElementById('nombre-usuario').innerText = 'Usuario';
      }

      fetchEmpleados();
      cargarDuenosCache();
      cargarVeterinarios();
      fetchDuenos();
      poblarEspecies();
      renderizarTarjetasReportes();
      poblarFiltroEspecieReportes();
      poblarFiltroVeterinarioReportes();
      document.getElementById('reporte_fecha_dia').value = new Date().toISOString().slice(0, 10);
      const hoy = new Date();
      const inicioMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
      document.getElementById('reporte_fecha_inicio').value = inicioMes.toISOString().slice(0, 10);
      document.getElementById('reporte_fecha_fin').value = hoy.toISOString().slice(0, 10);
      document.getElementById('filtroFecha').value = new Date().toISOString().slice(0, 10);
    });
  </script>
</body>
</html>