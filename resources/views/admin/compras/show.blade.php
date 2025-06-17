@extends('adminlte::page')

@section('title', 'Detalle de Compra')

@section('content_header')
    <h1>Detalle de Compra #{{ $compra->id }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <strong>Información de la Compra</strong>
    </div>
    <div class="card-body">
        <p><strong>Proveedor:</strong> {{ optional($compra->proveedores)->empresa}}</p>
        <p><strong>Fecha:</strong> 
            {{ $compra->fecha ? \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') : '[Sin fecha]' }}
        </p>
        <p><strong>Comprobante:</strong> {{ $compra->comprobante}}</p>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header bg-secondary text-white">
        <strong>Productos Comprados</strong>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="tablaDetalle">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Código</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cont = 1; $total_cantidad =0; $total_compra =0
                @endphp
                @foreach ($compra->detalles as $detalle)
                    <tr>
                        <td>{{ optional($detalle->producto)->nombre ?? '[Producto eliminado]' }}</td>
                        <td>{{ optional($detalle->producto)->codigo ?? '-' }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>${{ $detalle->producto->precio_compra }}</td>
                    </tr>
                    @php
                        $total_cantidad += $detalle->producto->precio_compra;
                       
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total de la compra:</th>
                    <th>${{ number_format($total_cantidad, 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
  <a href="{{ route('admin.compras.index') }}" class="btn btn-secondary">Volver</a>

@stop

@section('js')
<script>
    $(document).ready(function () {
        $('#tablaDetalle').DataTable({
            paging: true,
            searching: false,
            ordering: false
        });
    });
</script>
@stop

