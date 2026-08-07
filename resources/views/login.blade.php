<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Veterinaria</title>
</head>
<body>

    <!--HTML-->
   <div class="login-wrapper">
    <div class="contenedor-login">
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
            </div>
            
            <button type="submit" class="btn btn-login">iniciar sesion</button>
        </form>

        <p id="mensajeError" class="text-danger text-center mt-3" style="display: none;"></p>
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
    </script>

</body>
</html>