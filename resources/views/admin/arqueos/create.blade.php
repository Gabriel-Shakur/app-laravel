@extends('adminlte::page')

@section('title', 'Nuevo Arqueo de Caja')

@section('content_header')
    <h1>Nuevo Arqueo de Caja</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.arqueos.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="fecha_apertura">Fecha de Apertura</label>
                    <input type="datetime-local" name="fecha_apertura" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="monto_inicial">Monto Inicial</label>
                    <input type="number" name="monto_inicial" class="form-control" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('admin.arqueos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop
