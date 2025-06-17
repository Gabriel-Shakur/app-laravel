@extends('adminlte::page')

@section('title', 'Editar Arqueo de Caja')

@section('content_header')
    <h1>Editar Arqueo de Caja</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.arqueos.update', $arqueo->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="fecha_apertura">Fecha de Apertura</label>
                    <input 
                        type="datetime-local" 
                        name="fecha_apertura" 
                        class="form-control" 
                        required
                        value="{{ old('fecha_apertura', \Carbon\Carbon::parse($arqueo->fecha_apertura)->format('Y-m-d\TH:i')) }}"
                    >
                </div>

                <div class="form-group">
                    <label for="monto_inicial">Monto Inicial</label>
                    <input 
                        type="number" 
                        name="monto_inicial" 
                        class="form-control" 
                        step="0.01" 
                        required
                        value="{{ old('monto_inicial', $arqueo->monto_inicial) }}"
                    >
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea 
                        name="descripcion" 
                        class="form-control" 
                        rows="3"
                    >{{ old('descripcion', $arqueo->descripcion) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('admin.arqueos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop
