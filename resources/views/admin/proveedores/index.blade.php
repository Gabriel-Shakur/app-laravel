@extends('adminlte::page')



@section('content_header')
    <h1><b>Proveedores/Listado de Proveedores</b></h1>
    <hr>
@stop

@section('content')
  <div class="row">
  <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Proveedoresregistrados</h3>
                <div class="card-tools">
                  <a href="{{url('/admin/proveedores/create')}}"class="btn btn-primary"><i class="fa fa-plus"></i>Crear nuevo</a>
                </div>

            
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
     

   <table id="mitabla" class="table table-striped table-bordered table-hover table-sm">
       <thead class="thead-light">
       <tr>
         <th scope="col">Nro</th>
         <th scope="col">Empresa</th>
         <th scope="col">Direccion</th>
         <th scope="col">Telefono</th>
         <th scope="col">Email</th>
         <th scope="col">Nombre del proveedor</th>
         <th scope="col">Celular</th>
         <th scope="col">acciones</th>
      
        </tr>
     </thead>
      <tbody>
        <?php $contador = 1;?>
        @foreach ($proveedores as $proveedore)
            <tr>
                <td style="...">{{$contador++}}</td>
                <td>{{$proveedore->empresa}}</td>
                <td>{{$proveedore->direccion}}</td>
                <td>{{$proveedore->telefono}}</td>
                <td>{{$proveedore->email}}</td>
                <td>{{$proveedore->nombre}}</td>
               <td>
                         <a href="https://wa.me/{{$empresa->codigo_postal . $proveedore->celular}}" class="btn btn-success">
                           <i class="fas fa-whatsapp"></i>
                           {{$empresa->codigo_postal . $proveedore->celular}}
                        </a>
               </td>

                

               
                
                
                <td style="text-align:center">
                 <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{url('/admin/proveedores/'.$proveedore->id)}}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button></a>
                    <a href="{{url('/admin/proveedores/'.$proveedore->id.'/edit')}}" class="btn btn-succes btn-sm"><i class="fas fa-pencil"></i></button></a>
                    <form action="{{url('/admin/proveedores',$proveedore->id)}}" method="post" 
                      onclik="preguntar{{$proveedore->id}}(event)" id="miFormulario{{$proveedore->id}}">
                      @csrf 
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 0px 4px 4px 0px"><i class="fas fa-trash"></i></button>
                    </form>
                    <script>
                      function preguntar{{$proveedore->id}}(event){
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
                            var form = $('#miFormulario{{$proveedore->id}}');
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