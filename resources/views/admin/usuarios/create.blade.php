@extends('adminlte::page')



@section('content_header')
    <h1><b>Registro de un nuevo usuaio</b></h1>
    <hr>
@stop

@section('content')
  <div class="row">
  <div class="col-md-8">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Ingrese los datos</h3>
                

            
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{url('/admin/usuarios/create')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="role">Nombre del Rol</label>
                                <select name="role" id="" class="form-control">
                                    @foreach ($roles as $role)
                                     <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                  <label for="name">Nombre del Usuario</label>
                                  <input type="text" class="form-control" value="{{old('name')}}" name="name" required>
                                  @error('name')
                                 <small style="color: red;">{{$message}}</small>
                                  @enderror
                               </div>
                           </div>   


                           <div class="col-md-5">
                                <div class="form-group">
                                  <label for="email">Email</label>
                                  <input type="text" class="form-control" value="{{old('email')}}" name="email" required>
                                  @error('email')
                                 <small style="...">{{$message}}</small>
                                  @enderror
                               </div>
                           </div>   

                           <div class="row">
                              <div class="col-md-5">
                                  <div class="form-group">
                                     <label for="password">password</label>
                                     <input type="password" class="form-control" value="{{old('password')}}" name="password" required>
                                        @error('password')
                                          <small style="...">{{$message}}</small>
                                       @enderror
                                   </div>
                                </div>  
                                <div class="col-md-5">
                                  <div class="form-group">
                                     <label for="password_confirmation">Password Confirmacion</label>
                                     <input type="password" class="form-control" value="{{old('password_confirmation')}}" name="password_confirmation" required>
                                    </div>
                                </div>  
                            </div>
                        
                    </div>   
                    <hr>  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <a href="{{url('/admin/usuarios')}}" class="btn btn-secondary">Cancelar</a>
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