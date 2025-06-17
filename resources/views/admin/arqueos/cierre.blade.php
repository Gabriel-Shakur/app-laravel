@extends('adminlte::page')

@section('title', 'Cerrar Caja')

@section('content_header')
    <h1>Cierre de Caja</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.arqueos.cerrar.store', $arqueo->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Fecha de Apertura:</label>
                    <input type="text" class="form-control" value="{{ $arqueo->fecha_apertura }}" readonly>
                </div>

                <div class="form-group">
                    <label>Monto Inicial:</label>
                    <input type="text" class="form-control" value="{{ number_format($arqueo->monto_inicial, 2) }}" readonly>
                </div>

                <div class="form-group">
                    <label for="monto_final">Monto Final en Caja</label>
                    <input type="number" name="monto_final" class="form-control" step="0.01" required>
                </div>

               

                <button type="submit" class="btn btn-danger">Cerrar Caja</button>
                <a href="{{ route('admin.arqueos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop
