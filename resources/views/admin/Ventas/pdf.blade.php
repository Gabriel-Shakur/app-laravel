<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        header {
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header-left, .header-center, .header-right {
            display: inline-block;
            vertical-align: top;
        }
        .header-left {
            width: 35%;
            text-align: center;
        }
        .header-center {
            width: 30%;
            text-align: center;
        }
        .header-right {
            width: 30%;
            text-align: center;
            font-size: 12px;
        }
        .header-left img {
            max-width: 120px;
            max-height: 100px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        h1 {
            margin: 0;
            font-size: 28px;
            color: #1a1a1a;
        }
        h4 {
            margin: 5px 0 0;
            font-weight: normal;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #bbb;
            padding: 6px 10px;
            text-align: center;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            color: #444;
        }
        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
        .totals-row td {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .text-left {
            text-align: left !important;
        }
        .text-right {
            text-align: right !important;
        }
        .info-table td {
            border: none;
            padding: 3px 0;
            text-align: left;
        }
        .footer-note {
            font-size: 11px;
            color: #666;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            text-align: center;
        }
    </style>
</head>
<body>

<header>
    <div class="header-left">
        @php
           $path = storage_path('app/' . $empresa->logo);
           if (file_exists($path)) {
              $type = pathinfo($path, PATHINFO_EXTENSION);
             $data = file_get_contents($path);
             $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
           }        else {
              $base64 = null;
            }
        @endphp

        @if($base64)
          <img src="{{ $base64 }}" alt="Logo Empresa">
        @endif


        <div>
            <strong>{{ $empresa->nombre_empresa }}</strong><br>
            {{ $empresa->tipo_empresa }}<br>
            {{ $empresa->correo }}<br>
            Tel: {{ $empresa->telefono }}
        </div>
    </div>

    <div class="header-center">
        <h1>FACTURA</h1>
    </div>

    <div class="header-right">
        <div><strong>RFC:</strong> {{ $empresa->rfc }}</div>
        <div><strong>Nro Factura:</strong> {{ $venta->id }}</div>
        <h4>Original</h4>
    </div>
</header>

<section class="info-table">
    <table>
        <tr>
            <td><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
            <td><strong>NIT:</strong> {{ $venta->cliente->nit_codigo }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Cliente:</strong> {{ $venta->cliente->nombre_cliente }}</td>
        </tr>
    </table>
</section>

<section>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">Nro</th>
                <th style="width: 25%;">Producto</th>
                <th style="width: 35%;">Descripción</th>
                <th style="width: 10%;">Cantidad</th>
                <th style="width: 12%;">Precio Unitario</th>
                <th style="width: 13%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $contador = 1;
                $suma_cantidad = 0;
                $suma_subtotal = 0;
            @endphp

            @foreach($venta->detalleVenta as $detalle)
                @php
                    $subtotal = $detalle->cantidad * $detalle->producto->precio_venta;
                    $suma_cantidad += $detalle->cantidad;
                    $suma_subtotal += $subtotal;
                @endphp
                <tr>
                    <td>{{ $contador++ }}</td>
                    <td class="text-left">{{ $detalle->producto->nombre }}</td>
                    <td class="text-left">{{ $detalle->producto->descripcion }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td class="text-right">$ {{ number_format($detalle->producto->precio_venta, 2) }}</td>
                    <td class="text-right">$ {{ number_format($subtotal, 2) }}</td>
                </tr>
            @endforeach

            <tr class="totals-row">
                <td colspan="3" class="text-right">Total</td>
                <td>{{ $suma_cantidad }}</td>
                <td></td>
                <td class="text-right">$ {{ number_format($suma_subtotal, 2) }}</td>
            </tr>
        </tbody>
    </table>
</section>

<section>
    <p><strong>Monto a pagar:</strong> $ {{ number_format($venta->precio_total, 2) }}</p>
</section>

<footer class="footer-note">
    Gracias por su compra. ¡Vuelva pronto!
</footer>

</body>
</html>
