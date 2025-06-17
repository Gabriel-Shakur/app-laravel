@extends('adminlte::page')

@section('title', 'Arqueos de Caja')

@section('content_header')
    <h1>Arqueos de Caja</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.arqueos.create') }}" class="btn btn-primary">Nuevo Arqueo</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Fecha Apertura</th>
                    <th>Monto Inicial</th>
                    <th>Fecha Cierre</th>
                    <th>Monto Final</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($arqueos as $arqueo)
                    <tr>
                        <td>{{ $arqueo->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($arqueo->fecha_apertura)->format('d/m/Y H:i') }}</td>
                        <td>${{ number_format($arqueo->monto_inicial, 2) }}</td>
                        <td>
                            @if($arqueo->fecha_cierre)
                                {{ \Carbon\Carbon::parse($arqueo->fecha_cierre)->format('d/m/Y H:i') }}
                            @else
                                <span class="text-muted">Abierto</span>
                            @endif
                        </td>
                        <td>
                            @if($arqueo->monto_final)
                                ${{ number_format($arqueo->monto_final, 2) }}
                            @else
                                <span class="text-muted">Pendiente</span>
                            @endif
                        </td>
                        <td>{{ $arqueo->descripcion ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.arqueos.show', $arqueo->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('admin.arqueos.edit', $arqueo->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <a href="{{ route('admin.arqueos.ingresoegreso', $arqueo->id) }}" class="btn btn-success btn-sm">Ingresos/Egresos</a>

                            @if(!$arqueo->fecha_cierre)
                            <a href="{{ route('admin.arqueos.cerrar', $arqueo->id) }}" class="btn btn-danger btn-sm">Cerrar Caja</a>
                            @endif

                            <form action="{{ route('admin.arqueos.destroy', $arqueo->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este arqueo?')">Eliminar</button>
                            </form>
                            <a href="{{ route('admin.arqueos.reporte', $arqueo->id) }}" class="btn btn-secondary btn-sm">Reporte</a>

                        </td>
                    </tr>
                @endforeach

                @if($arqueos->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No hay arqueos registrados.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@stop
