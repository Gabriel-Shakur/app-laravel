@extends('adminlte::page')



@section('content_header')
    <h1><b>Productos/Listado de Productos</b></h1>
    <hr>
@stop

@section('content')
  <div class="row">
  <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Productos registrados</h3>
                <div class="card-tools">
                  <a href="{{url('/admin/productos/create')}}"class="btn btn-primary"><i class="fa fa-plus"></i>Crear nuevo</a>
                </div>

            
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
     

   <table id="mitabla" class="table table-striped table-bordered table-hover table-sm">
       <thead class="thead-light">
       <tr>
         <th scope="col">Nro</th>
         <th scope="col">Categoria</th>
         <th scope="col">Codigo</th>
         <th scope="col">Nombre</th>
         <th scope="col">Descripcion</th>
         <th scope="col">Stock</th>
          <th scope="col">Precio_compra</th>
          <th scope="col">Precio_venta</th>
          <th>Imagen</th>
         
         
         <th scope="col">acciones</th>
      
        </tr>
     </thead>
      <tbody>
        <?php $contador = 1;?>
        @foreach ($productos as $producto)
            <tr>
                <td style="...">{{$contador++}}</td>
                <td>{{$producto->categoria->nombre}}</td>
                <td>{{$producto->codigo}}</td>
                <td>{{$producto->nombre}}</td>
                <td>{{$producto->descripcion}}</td>
                <td style="text-align: center; background-color: blue;">{{$producto->stock}}</td>

                <td>{{$producto->precio_compra}}</td>
                <td>{{$producto->precio_venta}}</td>
                <td style="text-align: center">
                  <img src="{{asset('storage/'.$producto->imagen)}}"width="30px" alt="imagen">
                </td>
                
                <td style="text-align:center">
                 <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{url('/admin/productos/'.$producto->id)}}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button></a>
                    <a href="{{url('/admin/productos/'.$producto->id.'/edit')}}" class="btn btn-succes btn-sm"><i class="fas fa-pencil"></i></button></a>
                    <form action="{{url('/admin/productos',$producto->id)}}" method="post" 
                      onclik="preguntar{{$producto->id}}(event)" id="miFormulario{{$producto->id}}">
                      @csrf 
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 0px 4px 4px 0px"><i class="fas fa-trash"></i></button>
                    </form>
                    <script>
                      function preguntar{{$producto->id}}(event){
                        event.preventDefault();
                        Swal.fire({
                          title:'¿Desea eliminar este registro?',
                          text:'',
                          icon:'question',
                          showDenyButton: true,
                          confirmButtonText:'Eliminar',
                          confirmButtonColor:'#a5161d',
                          denyButtonColor:'#270a0a',
                          denyButtonText:'cancelar',


                        }).then((result) => {
                          if (result.isConfirmed){
                            var form = $('#miFormulario{{$producto->id}}');
                            form.submit();
                          }
                        });
                      }
                    </script>
                 </div>
                </td>
            </tr>
        @endforeach
     </tbody>
  
    </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>


  </div>
@stop

@section('css')
   
@stop

@section('js')
<script>
  $(function() {
    $('#mitabla').DataTable();
  });
</script>


 
  

@stop