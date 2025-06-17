@extends('adminlte::page')



@section('content_header')
    <h1><b>Categorias/Modificara categoria</b></h1>
    <hr>
@stop

@section('content')
  <div class="row">
  <div class="col-md-8">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Ingrese los datos</h3>
                

            
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{url('/admin/categorias',$categoria->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="role">Nombre de la categoria</label>
                                <input type="text" class="form-control" value="{{$categoria->nombre}}" name="nombre" required>
                                  @error('nombre')
                                 <small style="color: red;">{{$message}}</small>
                                  @enderror
                                
                            </div>
                        </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                  <label for="descripcion">Descripcion </label>
                                  <input type="text" class="form-control" value="{{$categoria->descripcion}}" name="descripcion" required>
                                  @error('descripcion')
                                 <small style="color: red;">{{$message}}</small>
                                  @enderror
                               </div>
                           </div>   


                           
                           
                        
                    </div>   
                    <hr>  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('/admin/categorias')}}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Modificar</button>
                            </div>
                        </div>    
                    </div>   


                </form>



     

  
@stop