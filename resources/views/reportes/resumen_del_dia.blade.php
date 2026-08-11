<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 5px; }
        p { color: #555; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h1>Resumen del Dia</h1>
    <p>Fecha: {{ $fecha }}</p>

    <table>
        <tr><th>Agendadas</th><td>{{ $data["agendadas"] }}</td></tr>
        <tr><th>Confirmadas</th><td>{{ $data["confirmadas"] }}</td></tr>
        <tr><th>En consulta</th><td>{{ $data["en_consulta"] }}</td></tr>
        <tr><th>Completadas</th><td>{{ $data["completadas"] }}</td></tr>
        <tr><th>Canceladas</th><td>{{ $data["canceladas"] }}</td></tr>
    </table>
</body>
</html>