<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h1>Motivos de Consulta mas Frecuentes</h1>

    <table>
        <thead>
            <tr><th>Motivo</th><th>Total</th></tr>
        </thead>
        <tbody>
            @foreach ($motivos as $fila)
            <tr><td>{{ $fila->motivo }}</td><td>{{ $fila->total }}</td></tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>