@extends('adminlte::page')

@section('content_header')
    <h1><b>Registro de una nueva compra</b></h1>
    <hr>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Ingrese los datos</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.compras.store') }}" method="POST">
            @csrf

            {{-- Primera fila: Cantidad, Código con botones, Fecha --}}
            <div class="row">
                {{-- Cantidad --}}
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" class="form-control" name="cantidad" id="cantidad" value="1" required style="background-color: rgb(29, 177, 41); color: white;">
                        @error('cantidad')
                            <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Código --}}
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            </div>
                            <input id="codigo" type="text" class="form-control" name="codigo" placeholder="Ingrese código">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ url('/admin/productos/create') }}" class="btn btn-success"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Fecha, Comprobante y Buscar proveedor --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>&nbsp;</label><br>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalProveedores">Buscar proveedor</button>
                        <input type="hidden" name="proveedor_id" id="proveedor_id">
                             <div class="form-group">
                               <label>Proveedor seleccionado:</label>
                                <input type="text" class="form-control" id="proveedor_nombre" readonly>
                             </div>

                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha de compra</label>
                        <input type="date" class="form-control" name="fecha" value="{{ old('fecha') }}">
                        @error('fecha')
                            <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="comprobante">Comprobante</label>
                        <input type="text" class="form-control" name="comprobante" value="{{ old('comprobante') }}" >
                        @error('comprobante')
                            <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Precio total --}}
            @php
                $total_compra = 0;
                foreach ($tmp_compras as $tmp_compra) {
                    $total_compra += $tmp_compra->cantidad * $tmp_compra->producto->precio_compra;
                }
            @endphp

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="precio_total">Precio total</label>
                        <input type="text" class="form-control" name="precio_total" value="{{ $total_compra }}" readonly>
                        @error('precio_total')
                            <small style="color: red;">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Tabla resumen de compra --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <thead class="thead-light">
                            <tr>
                                <th>Nro</th>
                                <th>Código</th>
                                <th>Cantidad</th>
                                <th>Nombre</th>
                                <th>Costo</th>
                                <th>Total</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 1;
                                $total_cantidad = 0;
                            @endphp
                            @foreach ($tmp_compras as $tmp_compra)
                                @php
                                    $costo = $tmp_compra->cantidad * $tmp_compra->producto->precio_compra;
                                    $total_cantidad += $tmp_compra->cantidad;
                                @endphp
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td class="text-center">{{ $tmp_compra->producto->codigo }}</td>
                                    <td class="text-center">{{ $tmp_compra->cantidad }}</td>
                                    <td>{{ $tmp_compra->producto->nombre }}</td>
                                    <td class="text-center">{{ $tmp_compra->producto->precio_compra }}</td>
                                    <td class="text-center">{{ $costo }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $tmp_compra->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-right"><b>Total cantidad</b></td>
                                <td class="text-right"><b>{{ $total_cantidad }}</b></td>
                                <td colspan="2" class="text-right"><b>Total compra</b></td>
                                <td class="text-center"><b>{{ $total_compra }}</b></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Botones finales --}}
            <div class="row mt-3">
                <div class="col-md-12">
                    
                    <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fas fa-save"></i> Registrar compra</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal de productos --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Listado de productos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="mitabla" class="table table-striped table-bordered table-hover table-sm table-responsive">
            <thead class="thead-light">
                <tr>
                    <th>Nro</th>
                    <th>Acción</th>
                    <th>Categoría</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Stock</th>
                    <th>Precio Compra</th>
                    <th>Precio Venta</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                @php $contador = 1; @endphp
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $contador++ }}</td>
                        <td>
                            <button type="button" class="btn btn-info seleccionar-btn" data-id="{{ $producto->codigo }}">Seleccionar</button>
                        </td>
                        <td>{{ $producto->categoria->nombre }}</td>
                        <td>{{ $producto->codigo }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td style="text-align: center; background-color: blue; color: white;">{{ $producto->stock }}</td>
                        <td>{{ $producto->precio_compra }}</td>
                        <td>{{ $producto->precio_venta }}</td>
                        <td style="text-align: center">
                            <img src="{{ asset('storage/'.$producto->imagen) }}" width="30px" alt="imagen">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal de proveedores --}}
<div class="modal fade" id="modalProveedores" tabindex="-1" role="dialog" aria-labelledby="modalProveedoresLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Listado de proveedores</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tablaProveedores" class="table table-striped table-bordered table-hover table-sm">
            <thead class="thead-light">
                <tr>
                    <th>Nro</th>
                    <th>Acción</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Dirección</th>
                </tr>
            </thead>
            <tbody>
                @php $nro = 1; @endphp
                @foreach ($proveedores as $proveedor)
                    <tr>
                        <td>{{ $nro++ }}</td>
                        <td>
                            <button type="button" class="btn btn-info seleccionar-proveedor-btn"
                                data-id="{{ $proveedor->id }}"
                                data-nombre="{{ $proveedor->nombre }}">
                                Seleccionar
                            </button>
                        </td>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td>{{ $proveedor->email }}</td>
                        <td>{{ $proveedor->direccion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>




@stop




@section('css')
@stop

@section('js')

<script>
    // Seleccionar proveedor
    $(document).on('click', '.seleccionar-proveedor-btn', function () {
        let id = $(this).data('id');
        let nombre = $(this).data('nombre');

        $('#proveedor_id').val(id);
        $('#proveedor_nombre').val(nombre);

        $('#modalProveedores').modal('hide');
    });
</script>


<script>
  $(function() {
    $('#mitabla').DataTable();
  });
</script>

<script>
    $('.seleccionar-btn').click(function (){
        var id_producto = $(this).data('id');
        $('#codigo').val(id_producto);
        $('#exampleModal').modal('hide');
        $('#exampleModal').on('hidden.bs.modal',function(){
            $('#codigo').focus();
        });
    }); 
  





  $('.delete-btn').click(function () {
    var id = $(this).data('id');
    
    if (id) {
        $.ajax({
            url: "{{ url('admin/compras/create/tmp') }}/" + id,
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                _method: 'DELETE'
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Se eliminó el producto",
                        showConfirmButton: false,
                        timer: 1000
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'No se pudo eliminar',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                alert('Ocurrió un error: ' + error);
            }
        });
    }
 });


  

   
   // Manejo de Enter en el campo #codigo
  $(document).ready(function () {
  // Inicialización de DataTable (solo una vez al cargar la página)
  $('#mitabla').DataTable();

  // Prevenir envío del formulario al presionar Enter
    $('#form_compra').on('keypress', function(e) {
      if (e.keyCode === 13) {
        e.preventDefault();
      }
    });

  $('#codigo').on('keyup', function (e) {
    if (e.which === 13) { // Enter
      let codigo = $(this).val();
      let cantidad = $('#cantidad').val();

      if (codigo.length > 0) {
        $.ajax({
          url: "{{ route('admin.compras.tmp_compras') }}",
          method: 'POST',
          data: {
            _token: "{{ csrf_token() }}",
            codigo: codigo,
            cantidad: cantidad
          },
          success: function (response) {
  if (response.success) {
    Swal.fire({
      position: "top-end",
      icon: "success",
      title: "Se registró el producto",
      showConfirmButton: false,
      timer: 10
    }).then(() => {
      setTimeout(() => {
        location.reload(); // Espera 300 ms antes de recargar la página
      }, 300);
    });
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Producto no encontrado',
      text: response.message
    });
  }
 },

          error: function (xhr, status, error) {
            alert('Ocurrió un error: ' + error);
          }
        });
      }
    }
  });
 });

</script>
@stop
