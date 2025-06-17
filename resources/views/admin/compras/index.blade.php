@extends('adminlte::page')



@section('content_header')
    <h1><b>Compras/Listado de Compras</b></h1>
    <hr>
@stop

@section('content')
  <div class="row">
  <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Compras registradas</h3>
                <div class="card-tools">
                  
                  @if($arqueo)
                      <a href="{{ route('admin.compras.create') }}" class="btn btn-primary btn-sm">
                       <i class="fas fa-plus"></i> Crear Nueva Venta
                      </a>
                      
                      @else
                        <a href="{{ route('admin.arqueos.create') }}" class="btn btn-danger btn-sm">
                          <i class="fas fa-plus"></i> Abrir caja
                        </a>
                  @endif
               </div>

            
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
     

   <table id="mitabla" class="table table-striped table-bordered table-hover table-sm">
       <thead class="thead-light">
       <tr>
         <th scope="col">Nro</th>
         <th scope="col">Fecha</th>
         <th scope="col">Comprobante</th>
         <th scope="col">Precio total</th>
         <th scope="col">Productos</th>
         <th scope="col">acciones</th>
      
        </tr>
     </thead>
      <tbody>
        <?php $contador = 1;?>
        @foreach ($compras as $compra)
            <tr>
                <td style="...">{{$contador++}}</td>
                <td>{{$compra->fecha}}</td>
                <td>{{$compra->comprobante}}</td>
                <td>{{$compra->precio_total}}</td>
                <td style="vertical-align: middle">
                  <ul>
                    @foreach($compra->detalles as $detalle)
                     <li>{{$detalle->producto->nombre.'-'.$detalle->cantidad. ' Unidades'}}</l>
                    @endforeach
                  </ul>
                </td>
               

                

               
                
                
                <td style="text-align:center">
                 <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{url('/admin/compras/'.$compra->id)}}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button></a>
                    <a href="{{url('/admin/compras/'.$compra->id.'/edit')}}" class="btn btn-succes btn-sm"><i class="fas fa-pencil"></i></button></a>
                    <form action="{{url('/admin/compras',$compra->id)}}" method="post" 
                      onclik="preguntar{{$compra->id}}(event)" id="miFormulario{{$compra->id}}">
                      @csrf 
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 0px 4px 4px 0px"><i class="fas fa-trash"></i></button>
                    </form>
                    <script>
                      function preguntar{{$compra->id}}(event){
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
                            var form = $('#miFormulario{{$compra->id}}');
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