@extends('adminlte::page')



@section('content_header')
    <h1><b>Registro de un nuevo Proveedor</b></h1>
    <hr>
@stop

@section('content')
  <div class="row">
  <div class="col-md-4">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ingrese los datos</h3>
                

            
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{url('/admin/proveedores/create')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nombre de la Empresa</label>
                                <input type="text" class="form-control" value="{{old('empresa')}}" name="empresa" required>
                                @error('empresa')
                                 <small style="color: red;">{{$message}}</small>
                                @enderror
                            </div>
                        </div>    

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Direccion</label>
                                <input type="text" class="form-control" value="{{old('direccion')}}" name="direccion" required>
                                @error('direccion')
                                 <small style="color: red;">{{$message}}</small>
                                @enderror
                            </div>
                        </div>    

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Telefono</label>
                                <input type="text" class="form-control" value="{{old('telefono')}}" name="telefono" required>
                                @error('telefono')
                                 <small style="color: red;">{{$message}}</small>
                                @enderror
                            </div>
                        </div>    

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="email" class="form-control" value="{{old('email')}}" name="email" required>
                                @error('empresa')
                                 <small style="color: red;">{{$message}}</small>
                                @enderror
                            </div>
                        </div>    

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nombre del Proveedor</label>
                                <input type="text" class="form-control" value="{{old('nombre')}}" name="nombre" required>
                                @error('nombre')
                                 <small style="color: red;">{{$message}}</small>
                                @enderror
                            </div>
                        </div>    

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Celular del Proveedor</label>
                                <input type="text" class="form-control" value="{{old('celular')}}" name="celular" required>
                                @error('celular')
                                 <small style="color: red;">{{$message}}</small>
                                @enderror
                            </div>
                        </div>    
                    </div>   
                    <hr>  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{'/admin/proveedores'}}"class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar</button>
                            </div>
                        </div>    
                    </div>   


                </form>



     

  
@stop

@section('css')
   
@stop

@section('js')
 
  

@stop