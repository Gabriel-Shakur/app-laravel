@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
    <h1>Editar Cliente</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-body">

            {{-- Mostrar errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>¡Ups! Hay algunos errores:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.clientes.update', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre_cliente">Nombre del Cliente:</label>
                    <input type="text" name="nombre_cliente" id="nombre_cliente"
                           class="form-control @error('nombre_cliente') is-invalid @enderror"
                           value="{{ old('nombre_cliente', $cliente->nombre_cliente) }}" placeholder="Ingrese el nombre">
                    @error('nombre_cliente')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nit_codigo">NIT / Código:</label>
                    <input type="text" name="nit_codigo" id="nit_codigo"
                           class="form-control @error('nit_codigo') is-invalid @enderror"
                           value="{{ old('nit_codigo', $cliente->nit_codigo) }}" placeholder="Ingrese NIT o código">
                    @error('nit_codigo')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" name="telefono" id="telefono"
                           class="form-control @error('telefono') is-invalid @enderror"
                           value="{{ old('telefono', $cliente->telefono) }}" placeholder="Ingrese teléfono">
                    @error('telefono')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" name="email" id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $cliente->email) }}" placeholder="Ingrese email">
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Cliente
                </button>

            </form>
        </div>
    </div>

@stop
