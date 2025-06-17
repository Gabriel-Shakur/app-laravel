@extends('adminlte::page')

@section('content_header')
    <h1><b>Registro de una nueva venta</b></h1>
    <hr>
@stop

@section('content')
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Ingrese los datos</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.ventas.store') }}" method="POST" id="form_venta">
            @csrf

            {{-- Cliente y Fecha --}}
            <div class="row">
                <div class="col-md-6">
                    <label>Buscar cliente</label>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalClientes">
                        Buscar cliente
                    </button>
                    <input type="hidden" name="cliente_id" id="cliente_id">
                    <div class="form-group mt-2">
                        <label>Cliente seleccionado:</label>
                        <input type="text" class="form-control" id="nombre_cliente" readonly>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="fecha">Fecha de venta</label>
                    <input type="date" class="form-control" name="fecha" value="{{ date('Y-m-d') }}">
                </div>
            </div>

            {{-- Productos: Cantidad, Código, botones --}}
            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" id="cantidad" name="cantidad" class="form-control" value="1" style="background-color: green; color: white;">
                </div>
                <div class="col-md-5">
                    <label for="codigo">Código del producto</label>
                    <div class="input-group">
                        <input id="codigo" type="text" class="form-control" name="codigo" placeholder="Ingrese código">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalProductos">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabla resumen de productos --}}
            @php
                $total = 0;
                foreach ($tmp_ventas as $tmp) {
                    $total += $tmp->cantidad * $tmp->producto->precio_venta;
                }
            @endphp

            <div class="row mt-4">
                <div class="col-md-12">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Precio Venta</th>
                                <th>Total</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $nro = 1; @endphp
                            @foreach ($tmp_ventas as $tmp)
                                <tr>
                                    <td>{{ $nro++ }}</td>
                                    <td>{{ $tmp->producto->codigo }}</td>
                                    <td>{{ $tmp->producto->nombre }}</td>
                                    <td>{{ $tmp->cantidad }}</td>
                                    <td>{{ $tmp->producto->precio_venta }}</td>
                                    <td>{{ $tmp->cantidad * $tmp->producto->precio_venta }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm delete-tmp" data-id="{{ $tmp->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right"><b>Total</b></td>
                                <td colspan="2"><b>{{ $total }}</b></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Botón registrar --}}
            <div class="row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success btn-lg btn-block"><i class="fas fa-save"></i> Registrar venta</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal de productos --}}
@include('admin.ventas.partials.modal_productos', ['productos' => $productos])

{{-- Modal de clientes --}}
@include('admin.ventas.partials.modal_clientes', ['clientes' => $clientes])
@stop

@section('js')
<script>
    // Seleccionar producto desde modal
    $('.seleccionar-producto-btn').click(function () {
        let codigo = $(this).data('codigo');
        $('#codigo').val(codigo);
        $('#modalProductos').modal('hide');
        $('#codigo').focus();
    });

    // Seleccionar cliente desde modal
    $('.seleccionar-cliente-btn').click(function () {
        let id = $(this).data('id');
        let nombre = $(this).data('nombre');
        $('#cliente_id').val(id);
        $('#nombre_cliente').val(nombre);
        $('#modalClientes').modal('hide');
    });

    // Agregar producto con Enter
    // Agregar producto con Enter
    
  
    let contador = $('#tabla-productos tr').length + 1;

    $('#codigo').on('keyup', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();

        let codigo = $(this).val();
        let cantidad = $('#cantidad').val();

        $.ajax({
            url: "{{ route('admin.ventas.tmp_ventas') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                codigo: codigo,
                cantidad: cantidad
            },
            success: function (response) {
                if (response.success) {
                    let p = response.producto;

                    let fila = `
                        <tr>
                            <td>${contador++}</td>
                            <td>${p.codigo}</td>
                            <td>${p.nombre}</td>
                            <td>${p.cantidad}</td>
                            <td>${p.precio_venta}</td>
                            <td>${p.total}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm delete-tmp" data-id="${p.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    $('#tabla-productos').append(fila);
                    $('#codigo').val('');
                    $('#cantidad').val(1);
                    $('#codigo').focus();

                    Swal.fire({
                        icon: 'success',
                        title: 'Producto agregado',
                        timer: 800,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }
        });
    }
 });
 


    // Eliminar producto temporal
    $('.delete-tmp').click(function () {
        let id = $(this).data('id');
        $.ajax({
            url:"{{ route('tmpventa.eliminar', ':id') }}".replace(':id', id),
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                _method: "DELETE"
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Producto eliminado',
                        timer: 800,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }
        });
    });
</script>
@stop



