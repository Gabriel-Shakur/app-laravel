@extends('adminlte::page')



@section('content_header')
    <h1><b>Detalles del Rol</b></h1>
    <hr>
@stop

@section('content')
  <div class="row">
  <div class="col-md-4">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Datos registrados</h3>
                

            
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
               
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nombre del Rol</label>
                                <p>{{$role->name}}</p>

                                
                        </div>    
                    </div>   
                    <hr>  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                               <a href="{{url('/admin/roles')}}" class="btn btn-secondary">volver</a>
                            </div>
                        </div>    
                    </div>   


               



     

  
@stop

@section('css')
   
@stop

@section('js')
 
  

@stop