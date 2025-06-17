@extends('adminlte::page')

@section('title', 'Editar Permiso')

@section('content_header')
    <h1><b>Editar Permiso</b></h1>
    <hr>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Formulario de Edición</h3>
            </div>
            <form action="{{ route('admin.permisos.update', $permiso->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Método PUT para actualizar -->
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nombre del Permiso:</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $permiso->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('admin.permisos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-warning">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
