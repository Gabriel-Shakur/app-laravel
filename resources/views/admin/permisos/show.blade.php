@extends('adminlte::page')

@section('title', 'Detalle del Permiso')

@section('content_header')
    <h1><b>Detalle del Permiso</b></h1>
    <hr>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Información del Permiso</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">ID:</dt>
                    <dd class="col-sm-8">{{ $permiso->id }}</dd>

                    <dt class="col-sm-4">Nombre:</dt>
                    <dd class="col-sm-8">{{ $permiso->name }}</dd>

                    <dt class="col-sm-4">Guard Name:</dt>
                    <dd class="col-sm-8">{{ $permiso->guard_name }}</dd>

                    <dt class="col-sm-4">Creado:</dt>
                    <dd class="col-sm-8">{{ $permiso->created_at->format('d/m/Y H:i') }}</dd>

                    <dt class="col-sm-4">Actualizado:</dt>
                    <dd class="col-sm-8">{{ $permiso->updated_at->format('d/m/Y H:i') }}</dd>
                </dl>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('admin.permisos.index') }}" class="btn btn-secondary">Volver</a>
                <a href="{{ route('admin.permisos.edit', $permiso->id) }}" class="btn btn-primary">Editar</a>
            </div>
        </div>
    </div>
</div>
@stop
