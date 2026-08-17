<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Veterinaria</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

    <!--HTML-->
    <div class="login-wrapper">
    <div class="contenedor-login" id="contenedorLogin">
        <div class="logo-container">
            <img src="{{ asset('Imagenes/logo_veterinaria_transparente.png') }}" alt="Logo Veterinaria">
        </div>

        <h2>Inicio de Sesión</h2>
        <p class="subtitulovet">Sistema de Gestión Veterinaria</p>

        <form id="formularioLogin">
            <div class="input-group-custom">
                <input type="email" id="correo" name="correo" class="form-control" placeholder="Correo Electrónico" required>
            </div>
            
            <div class="input-group-custom">
                <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Contraseña" required>
                <button type="button" class="btn btn-outline-secondary" id="btnTogglePassUsuarioLogin" tabindex="-1">
                <i class="bi bi-eye" id="iconTogglePassUsuarioLogin"></i>
                </button>
            </div>
            
            <button type="submit" class="btn btn-login">iniciar sesion</button>
        </form>

        <a href="#" id="enlaceOlvide" class="enlace-olvide">¿Olvidaste tu contraseña?</a>

        <p id="mensajeError" class="text-danger text-center mt-3" style="display: none;"></p>
    </div>
</div>

<!-- ===================== VENTANA DE RECUPERACIÓN ===================== -->
<div id="overlayOlvide" class="login-wrapper" style="display:none; position: fixed; inset: 0; background-color: rgba(0,0,0,0.75); z-index: 1000;">
    <div class="contenedor-login">
        <h2>Recuperar Contraseña</h2>
        <p class="subtitulovet">Te enviaremos un enlace a tu correo</p>

        <form id="formOlvideContrasena">
            <div class="input-group-custom">
                <input type="email" id="olvide_correo" class="form-control" placeholder="Correo Electrónico" required>
            </div>
            <button type="submit" class="btn btn-login">Enviar enlace</button>
        </form>

        <p id="olvideMensaje" class="text-center mt-3" style="display: none;"></p>

        <button type="button" id="btnCerrarOlvide" class="btn-cerrar-overlay">Cancelar</button>
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

    .enlace-olvide {
        display: block;
        text-align: center;
        margin-top: 18px;
        color: #ff4d4d;
        text-decoration: none;
        font-size: 0.85rem;
    }

    .enlace-olvide:hover {
        text-decoration: underline;
    }

    .btn-cerrar-overlay {
        background: none;
        border: none;
        color: #888888;
        width: 100%;
        margin-top: 10px;
        cursor: pointer;
        font-size: 0.85rem;
    }

    .btn-cerrar-overlay:hover {
        color: #ffffff;
    }
</style>

    <!--JAVASCRIPT-->
    <script>
        document.getElementById('formularioLogin').addEventListener('submit', async function(evento) {
            evento.preventDefault();
            
            const correo = document.getElementById('correo').value;
            const contrasena = document.getElementById('contrasena').value;
            const mensajeError = document.getElementById('mensajeError');
            
            mensajeError.style.display = 'none';
            
            try {
                const respuesta = await fetch('/api/auth/usuarios/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        correo: correo, 
                        contrasena: contrasena 
                    })
                });
                
                const datos = await respuesta.json();
                
                if (respuesta.ok) {
                    localStorage.setItem('token_veterinaria', datos.token);
                    localStorage.setItem('rol_usuario', datos.usuario.rol);
                    
                    if (datos.usuario.rol === 'recepcionista') {
                        window.location.href = '/panel/recepcion'; 
                    } else if (datos.usuario.rol === 'veterinario') {
                        window.location.href = '/panel/veterinario';
                    } else {
                        window.location.href = '/panel/admin';
                    }
                    
                } else {
                    mensajeError.textContent = datos.mensaje || 'Correo o contraseña incorrectos.';
                    mensajeError.style.display = 'block';
                }
                
            } catch (error) {
                mensajeError.textContent = 'Error de conexión con el servidor. Intenta nuevamente.';
                mensajeError.style.display = 'block';
            }
        });

        // ============ RECUPERAR CONTRASEÑA ============
        const overlayOlvide = document.getElementById('overlayOlvide');

        document.getElementById('enlaceOlvide').addEventListener('click', function(evento) {
            evento.preventDefault();
            overlayOlvide.style.display = 'flex';
        });

        document.getElementById('btnCerrarOlvide').addEventListener('click', function() {
            overlayOlvide.style.display = 'none';
            document.getElementById('formOlvideContrasena').reset();
            document.getElementById('olvideMensaje').style.display = 'none';
        });

        document.getElementById('formOlvideContrasena').addEventListener('submit', async function(evento) {
            evento.preventDefault();

            const correo = document.getElementById('olvide_correo').value;
            const mensajeEl = document.getElementById('olvideMensaje');

            try {
                const respuesta = await fetch('/api/auth/usuarios/olvide-contrasena', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ correo: correo })
                });

                const datos = await respuesta.json();

                mensajeEl.textContent = datos.mensaje;
                mensajeEl.style.color = '#4dff4d';
                mensajeEl.style.display = 'block';

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
    document.getElementById('btnTogglePassUsuarioLogin').addEventListener('click', () =>{
    verContrasenaIconoOjo('contrasena', 'iconTogglePassUsuarioLogin')
    });

    </script>

</body>
</html>