<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 5px; }
        h2 { font-size: 14px; margin-top: 25px; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h1>Reporte de Consultas por Periodo</h1>

    <h2>Por Veterinario</h2>
    <table>
        <thead>
            <tr><th>Veterinario</th><th>Total</th></tr>
        </thead>
        <tbody>
            @foreach ($por_veterinario as $fila)
            <tr><td>{{ $fila->veterinario }}</td><td>{{ $fila->total }}</td></tr>
            @endforeach
        </tbody>
    </table>

    <h2>Por Especie</h2>
    <table>
        <thead>
            <tr><th>Especie</th><th>Total</th></tr>
        </thead>
        <tbody>
            @foreach ($por_especie as $fila)
            <tr><td>{{ $fila->especie }}</td><td>{{ $fila->total }}</td></tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>