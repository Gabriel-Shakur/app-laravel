@extends('adminlte::page')

@section('title', 'Detalle de Venta')

@section('content_header')
    <h1>Detalle de Venta #{{ $venta->id }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Datos de la venta</strong>
        </div>
        <div class="card-body">
            <p><b>Cliente:</b> {{ $venta->cliente->nombre_cliente ?? 'Sin cliente' }}</p>
            <p><b>Fecha:</b> {{ $venta->fecha }}</p>
            <p><b>Precio total:</b> ${{ number_format($venta->precio_total, 2) }}</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <strong>Detalle de productos</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio Venta</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $nro = 1; @endphp
                    @foreach($venta->detalleventa as $detalle)
                        <tr>
                            <td>{{ $nro++ }}</td>
                            <td>{{ $detalle->producto->codigo ?? 'N/A' }}</td>
                            <td>{{ $detalle->producto->nombre ?? 'N/A' }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>${{ number_format($detalle->precio_venta, 2) }}</td>
                            <td>${{ number_format($detalle->cantidad * $detalle->precio_venta, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
