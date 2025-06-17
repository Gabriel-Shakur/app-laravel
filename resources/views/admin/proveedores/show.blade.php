@extends('adminlte::page')



@section('content_header')
    <h1><b>Datos del Proveedor</b></h1>
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
                                <label for="name">Nombre de la Empresa</label>
                              <p>{{$proveedores->empresa}}</p>
                            </div>
                        </div>    

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Direccion</label>
                                <p>{{$proveedores->direccion}}</p>
                            </div>
                        </div>    

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Telefono</label>
                                <p>{{$proveedores->telefono}}</p>
                            </div>
                        </div>    

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Email</label>
                                <p>{{$proveedores->email}}</p>
                            </div>
                        </div>    

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nombre del Proveedor</label>
                             <p>{{$proveedores->nombre}}</p>
                            </div>
                        </div>    

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Celular del Proveedor</label>
                              <p>{{$proveedores->celular}}</p>
                            </div>
                        </div>    
                    </div>   
                    <hr>  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{'/admin/proveedores'}}"class="btn btn-secondary">Cancelar</a>
                                
                            </div>
                        </div>    
                    </div>   


               



     

  
@stop

@section('css')
   
@stop

@section('js')
 
  

@stop