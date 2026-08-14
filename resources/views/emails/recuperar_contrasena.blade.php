<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: sans-serif;">
    <p>Recibimos una solicitud para restablecer tu contraseña.</p>
    <p><a href="{{ $enlace }}">Haz clic aquí para restablecer tu contraseña</a></p>
    <p>O copia este enlace en tu navegador:</p>
    <p>{{ $enlace }}</p>
    <p style="color: #888; font-size: 12px;">Este enlace expira en 60 minutos. Si tú no solicitaste este cambio, puedes ignorar este correo.</p>
</body>
</html>