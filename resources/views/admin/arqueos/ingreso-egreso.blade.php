@extends('adminlte::page')

@section('title', 'Ingresos y Egresos')

@section('content_header')
    <h1>Movimientos de Caja - Arqueo #{{ $arqueo->id }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.arqueos.index') }}" class="btn btn-secondary btn-sm">← Volver</a>
            <span><strong>Fecha de Apertura:</strong> {{ \Carbon\Carbon::parse($arqueo->fecha_apertura)->format('d/m/Y H:i') }}</span>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabla de movimientos --}}
            <h4 class="mb-3">Movimientos</h4>

            @if($arqueo->movimientos->isEmpty())
                <p>No hay movimientos registrados aún.</p>
            @else
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
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
                                <td>{{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <span class="badge badge-{{ $mov->tipo === 'ingreso' ? 'success' : 'danger' }}">
                                        {{ ucfirst($mov->tipo) }}
                                    </span>
                                </td>
                                <td>{{ number_format($mov->monto, 2) }}</td>
                                <td>{{ $mov->descripcion ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @php
    $totalIngresos = $arqueo->movimientos->where('tipo', 'ingreso')->sum('monto');
    $totalEgresos = $arqueo->movimientos->where('tipo', 'egreso')->sum('monto');
    $totalCaja = $arqueo->monto_inicial + $totalIngresos - $totalEgresos;
@endphp

<div class="mt-4">
    <h5><strong>Resumen:</strong></h5>
    <ul>
        <li><strong>Monto Inicial:</strong> ${{ number_format($arqueo->monto_inicial, 2) }}</li>
        <li><strong>Total Ingresos:</strong> ${{ number_format($totalIngresos, 2) }}</li>
        <li><strong>Total Egresos:</strong> ${{ number_format($totalEgresos, 2) }}</li>
        <li><strong>Total en Caja:</strong> ${{ number_format($totalCaja, 2) }}</li>
    </ul>
</div>

            @endif

            <hr>

            {{-- Formulario de registro --}}
            <h4 class="mt-4">Registrar Nuevo Movimiento</h4>

            <form action="{{ route('admin.arqueos.movimientos.store', $arqueo->id) }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="fecha">Fecha</label>
                        <input type="datetime-local" name="fecha" class="form-control" required value="{{ old('fecha') }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="tipo">Tipo</label>
                        <select name="tipo" class="form-control" required>
                            <option value="">Seleccione</option>
                            <option value="ingreso" {{ old('tipo') == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
                            <option value="egreso" {{ old('tipo') == 'egreso' ? 'selected' : '' }}>Egreso</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="monto">Monto</label>
                        <input type="number" step="0.01" name="monto" class="form-control" required value="{{ old('monto') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="2">{{ old('descripcion') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Guardar Movimiento</button>
            </form>
        </div>
    </div>
@stop
