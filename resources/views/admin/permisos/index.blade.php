@extends('adminlte::page')

@section('title', 'Listado de Permisos')

@section('content_header')
    <h1><b>Listado de Permisos</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Permisos registrados</h3>
                <div class="card-tools">
                    <a href="{{ url('/admin/permisos/create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Crear nuevo
                    </a>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped table-bordered table-hover table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>Nro</th>
                            <th>Nombre del Permiso</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $contador = 1; @endphp
                        @foreach ($permisos as $permiso)
                        <tr>
                            <td>{{ $contador++ }}</td>
                            <td>{{ $permiso->name }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ url('/admin/permisos', $permiso->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('/admin/permisos/'.$permiso->id.'/edit') }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ url('/admin/permisos', $permiso->id) }}" method="POST" id="miFormulario{{ $permiso->id }}" style="display:inline;">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="preguntar{{ $permiso->id }}(event)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>

                                <script>
                                    function preguntar{{ $permiso->id }}(event){
                                        event.preventDefault();
                                        Swal.fire({
                                            title: '¿Desea eliminar este registro?',
                                            icon: 'question',
                                            showDenyButton: true,
                                            confirmButtonText: 'Eliminar',
                                            confirmButtonColor: '#a5161d',
                                            denyButtonText: 'Cancelar',
                                            denyButtonColor: '#6c757d',
                                        }).then((result) => {
                                            if (result.isConfirmed){
                                                document.getElementById('miFormulario{{ $permiso->id }}').submit();
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
    {{-- Puedes incluir CSS adicional aquí si lo necesitas --}}
@stop

@section('js')
    {{-- SweetAlert2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stop
