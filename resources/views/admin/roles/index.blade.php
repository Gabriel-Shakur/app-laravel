
@extends('adminlte::page')

@section('title', 'Listado de Roles')

@section('content_header')
    <h1><b>Listado de Roles</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Roles registrados</h3>
                <div class="card-tools">
                    <a href="{{ url('/admin/roles/create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Crear nuevo
                    </a>
                    <a href="{{ route('admin.roles.reporte') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf"></i> Descargar PDF
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped table-bordered table-hover table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Nro</th>
                            <th scope="col">Nombre del rol</th>
                            <th scope="col" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $contador = 1; @endphp
                        @foreach ($roles as $role)
                        <tr>
                            <td>{{ $contador++ }}</td>
                            <td>{{ $role->name }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ url('/admin/roles', $role->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/admin/roles/' . $role->id . '/edit') }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a href="{{ url('/admin/roles/' . $role->id . '/asignar') }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <form action="{{ url('/admin/roles', $role->id) }}" method="POST" id="formDelete{{ $role->id }}" onsubmit="return confirmarEliminar(event, {{ $role->id }})">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>

                                <script>
                                    function confirmarEliminar(event, id) {
                                        event.preventDefault();
                                        Swal.fire({
                                            title: '¿Desea eliminar este rol?',
                                            icon: 'question',
                                            showDenyButton: true,
                                            confirmButtonText: 'Eliminar',
                                            confirmButtonColor: '#a5161d',
                                            denyButtonText: 'Cancelar',
                                            denyButtonColor: '#6c757d',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                document.getElementById('formDelete' + id).submit();
                                            }
                                        });
                                    }
                                </script>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<!-- Puedes agregar estilos personalizados aquí si es necesario -->
@stop

@section('js')
<!-- SweetAlert2 (asegúrate de incluirlo si no está ya cargado) -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stop



