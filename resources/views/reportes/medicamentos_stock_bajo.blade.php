<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 5px; }
        p { color: #555; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h1>Reporte de Medicamentos con Stock Bajo</h1>
    <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Cantidad Actual</th>
                <th>Cantidad Minima</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medicamentos as $medicamento)
            <tr>
                <td>{{ $medicamento->nombre }}</td>
                <td>{{ $medicamento->tipo }}</td>
                <td>{{ $medicamento->cantidad_actual }}</td>
                <td>{{ $medicamento->cantidad_minima_alerta }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>