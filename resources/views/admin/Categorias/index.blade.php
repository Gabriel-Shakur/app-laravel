@extends('adminlte::page')



@section('content_header')
    <h1><b>Categorias/Listado de Categorias</b></h1>
    <hr>
@stop

@section('content')
  <div class="row">
  <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Categorias registradas</h3>
                <div class="card-tools">
                  <a href="{{url('/admin/categorias/create')}}"class="btn btn-primary"><i class="fa fa-plus"></i>Crear nuevo</a>
                </div>

            
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
     

   <table class="table table-striped table-bordered table-hover table-sm">
       <thead class="thead-light">
       <tr>
         <th scope="col">Nro</th>
         <th scope="col">Nombre de la categoria</th>
         <th scope="col">Descrpcion</th>
         
         <th scope="col">acciones</th>
      
        </tr>
     </thead>
      <tbody>
        <?php $contador = 1;?>
        @foreach ($categorias as $categoria)
            <tr>
                <td style="...">{{$contador++}}</td>
                <td>{{$categoria->nombre}}</td>
                <td>{{$categoria->descripcion}}</td>
                
                <td style="text-align:center">
                 <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{url('/admin/categorias/'.$categoria->id)}}"  class="btn btn-info btn-sm"><i class="fas fa-eye"></i></button></a>
                    <a href="{{url('/admin/categorias/'.$categoria->id.'/edit')}}" class="btn btn-succes btn-sm"><i class="fas fa-pencil"></i></button></a>
                    <form action="{{url('/admin/categorias',$categoria->id)}}" method="post" 
                      onclik="preguntar{{$categoria->id}}(event)" id="miFormulario{{$categoria->id}}">
                      @csrf 
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 0px 4px 4px 0px"><i class="fas fa-trash"></i></button>
                    </form>
                    <script>
                      function preguntar{{$categoria->id}}(event){
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
                            var form = $('#miFormulario{{$categoria->id}}');
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
 
  

@stop