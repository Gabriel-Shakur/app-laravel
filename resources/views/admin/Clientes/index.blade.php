@extends('adminlte::page')

@section('title', 'Lista de Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')

    {{-- Botón para agregar cliente --}}
    <div class="mb-3">
        <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Agregar Cliente
        </a>
    </div>

    {{-- Tabla de clientes --}}
    <table id="mitabla" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>NIT / Código</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @php $contador = 1; @endphp
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $contador++ }}</td>
                    <td>{{ $cliente->nombre_cliente }}</td>
                    <td>{{ $cliente->nit_codigo }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ url('/admin/clientes', $cliente->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ url('/admin/clientes/'.$cliente->id.'/edit') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ url('/admin/clientes/'.$cliente->id) }}" method="POST"
                                  onsubmit="return confirmarEliminacion(event, {{ $cliente->id }})"
                                  id="formEliminar{{ $cliente->id }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@stop

@section('css')
    {{-- DataTables CSS --}}
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
@stop

@section('js')
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function () {
            $('#mitabla').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });

        function confirmarEliminacion(event, id) {
            event.preventDefault();
            Swal.fire({
                title: '¿Desea eliminar este cliente?',
                icon: 'question',
                showDenyButton: true,
                confirmButtonText: 'Eliminar',
                confirmButtonColor: '#a5161d',
                denyButtonColor: '#270a0a',
                denyButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formEliminar' + id).submit();
                }
            });
        }
    </script>
@stop


