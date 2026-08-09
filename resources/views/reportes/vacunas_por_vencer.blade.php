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
    <h1>Vacunas Proximas a Vencer (30 dias)</h1>

    <table>
        <thead>
            <tr><th>Mascota</th><th>Especie</th><th>Vacuna</th><th>Proxima Dosis</th></tr>
        </thead>
        <tbody>
            @foreach ($vacunas as $vacuna)
            <tr>
                <td>{{ $vacuna->mascota->nombre }}</td>
                <td>{{ $vacuna->mascota->especie }}</td>
                <td>{{ $vacuna->nombre_vacuna }}</td>
                <td>{{ $vacuna->fecha_proxima_dosis->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>