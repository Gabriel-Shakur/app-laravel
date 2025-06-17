<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Roles</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 6px; }
        th { background-color: #eee; }
        .header-table { width: 100%; margin-bottom: 10px; }
        .header-table td { vertical-align: top; }
        .logo { width: 150px; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="logo">
                @php
                    $path = storage_path('app/' . $empresa->logo);
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                @endphp
                <img src="{{ $base64 }}" alt="Logo empresa" width="150">
            </td>
            <td>
                <h2>{{ $empresa->nombre_empresa }}</h2>
                <p><strong>Teléfono:</strong> {{ $empresa->telefono }}</p>
                <p><strong>Correo:</strong> {{ $empresa->correo }}</p>
                <p><strong>Dirección:</strong> {{ $empresa->direccion }}</p>
            </td>
        </tr>
    </table>

    <h1>Listado de Roles</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre del Rol</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $i => $role)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $role->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
