<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel del admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
  <div class="container-fluid">
    <img src="{{ asset('Imagenes/logo_de_la_veterinaria.jpg') }}" width="50px" height="50px"  style="border-radius: 50px;">
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
            Mas opciones
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Gestionar citas</li>
            <li><a class="dropdown-item" href="#">Gestionar clientes</a></li>
            <li><a class="dropdown-item" href="#">Gestionar mascotas</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<h1 class="text-center mt-4">¡Bienvenido <span id="nombre-usuario">Cargando...</span>!</h1>
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
        document.getElementById('nombre-usuario').innerText = " Usuario";
      }
    } else {
      document.getElementById('nombre-usuario').innerText = " Invitado";
    }
  });
</script>
</body>
</html>
