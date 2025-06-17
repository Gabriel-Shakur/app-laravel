@extends('adminlte::page')

@section('title', 'Crear Permiso')

@section('content_header')
    <h1><b>Crear nuevo permiso</b></h1>
    <hr>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Nuevo Permiso</h3>
            </div>
            <form action="{{ url('/admin/permisos') }}" method="POST">
                @csrf
                <div class="card-body">
                    {{-- Nombre del permiso --}}
                    <div class="form-group">
                        <label for="name">Nombre del Permiso:</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Ej: editar usuarios" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ url('/admin/permisos') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- CSS adicional opcional --}}
@stop

@section('js')
    {{-- JS adicional opcional --}}
@stop
