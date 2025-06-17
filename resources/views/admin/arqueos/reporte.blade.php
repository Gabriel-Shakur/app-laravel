<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Arqueo</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        .resumen td { font-weight: bold; }
    </style>
</head>
<body>
    <h2>Reporte de Arqueo #{{ $arqueo->id }}</h2>
    <p><strong>Fecha de apertura:</strong> {{ $arqueo->fecha_apertura }}</p>
    <p><strong>Fecha de cierre:</strong> {{ $arqueo->fecha_cierre ?? 'Pendiente' }}</p>
    <p><strong>Descripción:</strong> {{ $arqueo->descripcion }}</p>

    <h3>Movimientos</h3>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Monto</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($arqueo->movimientos as $mov)
                <tr>
                    <td>{{ $mov->created_at }}</td>
                    <td>{{ ucfirst($mov->tipo) }}</td>
                    <td>${{ number_format($mov->monto, 2) }}</td>
                    <td>{{ $mov->descripcion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="resumen">
        <tr><td>Monto inicial:</td><td>${{ number_format($arqueo->monto_inicial, 2) }}</td></tr>
        <tr><td>Total ingresos:</td><td>${{ number_format($ingresos, 2) }}</td></tr>
        <tr><td>Total egresos:</td><td>${{ number_format($egresos, 2) }}</td></tr>
        <tr><td><strong>Total final:</strong></td><td><strong>${{ number_format($total, 2) }}</strong></td></tr>
    </table>
</body>
</html>
