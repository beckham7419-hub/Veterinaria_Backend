<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - Veterinaria</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

    <div class="login-wrapper">
        <div class="contenedor-login">
            <div class="logo-container">
                <img src="{{ asset('Imagenes/logo_veterinaria_transparente.png') }}" alt="Logo Veterinaria">
            </div>

            <h2>Restablecer Contraseña</h2>
            <p class="subtitulovet">Ingresa tu nueva contraseña</p>

            <form id="formRestablecer">
                <div class="input-group-custom">
                    <input type="password" id="contrasena_nueva" class="form-control" placeholder="Nueva contraseña" minlength="8" required>
                    <button type="button" class="btn btn-outline-secondary" id="btnTogglePassUsuario" tabindex="-1">
                    <i class="bi bi-eye" id="iconTogglePassUsuario"></i>
                    </button>
                </div>
                <div class="input-group-custom">
                    <input type="password" id="contrasena_confirmar" class="form-control" placeholder="Confirma tu nueva contraseña" minlength="8" required>
                    <button type="button" class="btn btn-outline-secondary" id="btnTogglePassUsuarioConfirm" tabindex="-1">
                    <i class="bi bi-eye" id="iconTogglePassUsuarioConfirm"></i>
                    </button>
                </div>
                <button type="submit" class="btn btn-login">Restablecer contraseña</button>
            </form>

            <p id="mensajeResultado" class="text-center mt-3" style="display: none;"></p>
        </div>
    </div>

    <style>
        body {
            background-color: #1a1a1a;
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #1e1e1e;
            padding: 20px;
        }

        .contenedor-login {
            background-color: #242424;
            border: 2px solid #ff4d4d;
            padding: 40px 35px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 15px rgba(255, 77, 77, 0.15);
            width: 100%;
            max-width: 380px;
            text-align: center;
            box-sizing: border-box;
        }

        .logo-container {
            width: 170px;
            height: 120px;
            background-color: transparent;
            border: 2px solid #ff4d4d;
            border-radius: 16px;
            margin: 0 auto 25px auto;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 14px rgba(255, 77, 77, 0.35);
            box-sizing: border-box;
        }

        .logo-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            display: block;
        }

        .contenedor-login h2 {
            color: #ffffff;
            font-weight: 600;
            font-size: 1.3rem;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .subtitulovet {
            color: #888888;
            font-size: 0.85rem;
            margin-bottom: 30px;
        }

        .input-group-custom {
            margin-bottom: 18px;
            display: flex;
            justify-content: center;
        }

        .contenedor-login .form-control {
            background-color: #1a1a1a;
            border: 1px solid #333333;
            color: #ffffff;
            border-radius: 6px;
            padding: 14px 16px;
            font-size: 0.95rem;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .contenedor-login .form-control::placeholder {
            color: #777777;
        }

        .contenedor-login .form-control:focus {
            background-color: #1a1a1a;
            color: #ffffff;
            border-color: #ff4d4d;
            box-shadow: none;
            outline: none;
        }

        .contenedor-login .btn-login {
            background-color: #ff4d4d;
            border: none;
            color: #ffffff;
            font-weight: 600;
            border-radius: 6px;
            padding: 14px;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            width: 100%;
            box-sizing: border-box;
            margin-top: 10px;
            transition: background-color 0.2s ease-in-out;
        }

        .contenedor-login .btn-login:hover {
            background-color: #e03b3b;
            color: #ffffff;
        }
    </style>

    <script>
        const parametros = new URLSearchParams(window.location.search);
        const correo = parametros.get('correo');
        const token = parametros.get('token');
        const tipo = parametros.get('tipo');

        if (!correo || !token || !tipo) {
            document.querySelector('.contenedor-login').innerHTML =
                '<p class="text-center">Este enlace es inválido o está incompleto. Solicita uno nuevo desde la pantalla de inicio de sesión.</p>';
        }

        document.getElementById('formRestablecer')?.addEventListener('submit', async function(evento) {
            evento.preventDefault();

            const nueva = document.getElementById('contrasena_nueva').value;
            const confirmar = document.getElementById('contrasena_confirmar').value;
            const mensajeEl = document.getElementById('mensajeResultado');

            if (nueva !== confirmar) {
                mensajeEl.textContent = 'Las contraseñas no coinciden.';
                mensajeEl.style.color = '#ff4d4d';
                mensajeEl.style.display = 'block';
                return;
            }

            const ruta = tipo === 'dueno'
                ? '/api/auth/duenos/restablecer-contrasena'
                : '/api/auth/usuarios/restablecer-contrasena';

            try {
                const respuesta = await fetch(ruta, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        correo: correo,
                        token: token,
                        contrasena_nueva: nueva
                    })
                });

                const datos = await respuesta.json();

                if (respuesta.ok) {
                    mensajeEl.textContent = datos.mensaje + ' Redirigiendo al inicio de sesión...';
                    mensajeEl.style.color = '#4dff4d';
                    mensajeEl.style.display = 'block';
                    document.getElementById('formRestablecer').style.display = 'none';
                    setTimeout(() => { window.location.href = '/'; }, 2500);
                } else {
                    mensajeEl.textContent = datos.mensaje || 'No se pudo restablecer la contraseña.';
                    mensajeEl.style.color = '#ff4d4d';
                    mensajeEl.style.display = 'block';
                }
            } catch (error) {
                mensajeEl.textContent = 'Error de conexión con el servidor.';
                mensajeEl.style.color = '#ff4d4d';
                mensajeEl.style.display = 'block';
            }
        });

    //funcion para poder ver la contraseña mediante el icono del ojito
    function verContrasenaIconoOjo(usuario_id_contra, icon_usuario_toogle_id){
      const input=document.getElementById(usuario_id_contra);
      const icono=document.getElementById(icon_usuario_toogle_id);
      const miContrasena=input.type==='password';
      input.type=miContrasena?'text':'password';
      icono.classList.toggle('bi-eye', !miContrasena);
      icono.classList.toggle('bi-eye-slash', miContrasena);
    }

    //en dado caso de que sea la contraseña que se active el ojito
    document.getElementById('btnTogglePassUsuario').addEventListener('click', () =>{
    verContrasenaIconoOjo('contrasena_nueva', 'iconTogglePassUsuario')
    });

    document.getElementById('btnTogglePassUsuarioConfirm').addEventListener('click', () =>{
    verContrasenaIconoOjo('contrasena_confirmar', 'iconTogglePassUsuarioConfirm')
    });
    </script>

</body>
</html>