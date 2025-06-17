@extends('adminlte::page')

@section('title', 'Lista de Ventas')

@section('content_header')
    <h1>Ventas Registradas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            @if($arqueoAbierto)
              <a href="{{ route('admin.ventas.create') }}" class="btn btn-primary btn-sm">
                 <i class="fas fa-plus"></i> Crear Nueva Venta
              </a>
              @else
              <a href="{{ route('admin.arqueos.create') }}" class="btn btn-danger btn-sm">
                 <i class="fas fa-plus"></i> Abrir caja
              </a>
            @endif
            
        </div>
        <div class="card-body">
            <table id="tablaVentas" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Productos</th>
                        <th>Precio Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $venta)
                        <tr>
                            <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $venta->cliente->nombre_cliente ?? 'Sin cliente' }}</td>
                            <td>
                                <ul>
                                    @foreach ($venta->detalleventa as $detalle)
                                       <li>{{ $detalle->producto->nombre ?? 'Producto eliminado' }} - x{{ $detalle->cantidad }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>Bs {{ number_format($venta->precio_total, 2) }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.ventas.show', $venta->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.ventas.edit', $venta->id) }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('admin.ventas.pdf', $venta->id) }}" target="_blank" class="btn btn-warning btn-sm"><i class="fas fa-print"></i></a>
                                    <form action="{{ route('admin.ventas.destroy', $venta->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirmarEliminacion(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('#tablaVentas').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json'
                }
            });
        });

        function confirmarEliminacion(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Esta acción no se puede deshacer!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        }
    </script>
@stop
