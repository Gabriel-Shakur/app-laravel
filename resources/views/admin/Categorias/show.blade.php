@extends('adminlte::page')



@section('content_header')
    <h1><b>Categorias/Categorias registradas</b></h1>
    <hr>
@stop

@section('content')
  <div class="row">
  <div class="col-md-8">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Datos registrados</h3>
                

            
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="role">Nombre de la categoria</label>
                                <p>{{$categoria->nombre}}</p>
                                
                            </div>
                        </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                  <label for="descripcion">Descripcion </label>
                                  <p>{{$categoria->descripcion}}</p>
                               </div>
                           </div>   

                           <div class="col-md-5">
                                <div class="form-group">
                                  <label for="descripcion">Fecha y hora de registro</label>
                                  <p>{{$categoria->created_at}}</p>
                               </div>
                           </div>   



                           
                           
                        
                    </div>   
                    <hr>  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('/admin/categorias')}}" class="btn btn-secondary">Volver</a>
                                
                            </div>
                        </div>    
                    </div>   


                



     

  
@stop