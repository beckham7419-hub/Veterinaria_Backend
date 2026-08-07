<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>Tu cita ha sido confirmada</h2>
    <p>Numero de folio: <strong>{{ $cita->numero_folio }}</strong></p>
    <p>Fecha: {{ $cita->fecha->format('d/m/Y') }}</p>
    <p>Hora: {{ $cita->hora }}</p>
    <p>Motivo: {{ $cita->motivo }}</p>
    <p>Gracias por confiar en nosotros.</p>
</body>
</html>