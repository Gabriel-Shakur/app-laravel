@extends('adminlte::page')

@section('title', 'Asignar permisos')

@section('content_header')
    <h1><b>Asignar Permisos al Rol</b></h1>
    <hr>
@stop

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Permisos del Rol: <b>{{ $role->name }}</b></h3>
            </div>
            <form action="{{ route('admin.roles.asignar', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        @foreach ($permisos as $permiso)
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    name="permissions[]" 
                                    value="{{ $permiso->id }}"
                                    class="form-check-input"
                                    id="permiso{{ $permiso->id }}"
                                    {{ $role->permissions->contains($permiso->id) ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="permiso{{ $permiso->id }}">
                                    {{ $permiso->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
