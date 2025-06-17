@extends('adminlte::page')

@section('title', 'Detalle del Cliente')

@section('content_header')
    <h1>Detalle del Cliente</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Nombre del Cliente</th>
                        <td>{{ $cliente->nombre_cliente }}</td>
                    </tr>
                    <tr>
                        <th>NIT / Código</th>
                        <td>{{ $cliente->nit_codigo }}</td>
                    </tr>
                    <tr>
                        <th>Teléfono</th>
                        <td>{{ $cliente->telefono }}</td>
                    </tr>
                    <tr>
                        <th>Correo Electrónico</th>
                        <td>{{ $cliente->email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
