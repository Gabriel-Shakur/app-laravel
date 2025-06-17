@extends('adminlte::page')

@section('title', 'Detalle Arqueo de Caja')

@section('content_header')
    <h1>Detalle Arqueo de Caja</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.arqueos.index') }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Fecha de Apertura</th>
                        <td>{{ $arqueo->fecha_apertura }}</td>
                    </tr>
                    <tr>
                        <th>Monto Inicial</th>
                        <td>{{ number_format($arqueo->monto_inicial, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Descripción</th>
                        <td>{{ $arqueo->descripcion ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Empresa</th>
                        <td>{{ optional($arqueo->empresa)->nombre ?? 'No asignada' }}</td>
                    </tr>
                    <tr>
                        <th>Creado en</th>
                        <td>{{ $arqueo->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Actualizado en</th>
                        <td>{{ $arqueo->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
