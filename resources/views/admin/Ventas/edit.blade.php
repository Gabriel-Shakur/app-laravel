@extends('adminlte::page')

@section('title', 'Editar Venta')

@section('content_header')
    <h1>Editar Venta #{{ $venta->id }}</h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Formulario de edición</h3>
    </div>
    <form action="{{ route('admin.ventas.update', $venta->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            {{-- Cliente --}}
            <div class="form-group">
                <label for="cliente_id">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="form-control" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ $cliente->id == $venta->cliente_id ? 'selected' : '' }}>
                            {{ $cliente->nombre_cliente }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Fecha --}}
            <div class="form-group">
                <label for="fecha">Fecha de la venta</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $venta->fecha }}" required>
            </div>

            {{-- Productos en la venta (solo mostrar, no editar directamente aquí) --}}
            <div class="form-group">
                <label>Productos vendidos</label>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Precio unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($venta->detalleventa as $detalle)
                            <tr>
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

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
            <a href="{{ route('admin.ventas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@stop
