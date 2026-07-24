<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Veterinaria</title>
</head>
<body>

    <!--HTML-->
    <div class="contenedor-login">
        <h2>Inicio de Sesión - Veterinaria</h2>
        <form id="formularioLogin">
            <div>
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" placeholder="ejemplo@clinica.com" required>
            </div>
            
            <div>
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="********" required>
            </div>
            
            <button type="submit">Ingresar al Sistema</button>
        </form>
        
        <p id="mensajeError" style="color: red; display: none;"></p>
    </div>

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