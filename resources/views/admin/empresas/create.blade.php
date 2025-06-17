@extends('adminlte::master')

@php
    $authType = $authType ?? 'login';
    $dashboardUrl = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home');

    if (config('adminlte.use_route_url', false)) {
        $dashboardUrl = $dashboardUrl ? route($dashboardUrl) : '';
    } else {
        $dashboardUrl = $dashboardUrl ? url($dashboardUrl) : '';
    }

    $bodyClasses = "{$authType}-page";

    if (! empty(config('adminlte.layout_dark_mode', null))) {
        $bodyClasses .= ' dark-mode';
    }
@endphp

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body'){{ $bodyClasses }}@stop

@section('body')
    <div class="container">

    <center>
 <img src="{{asset('images/logo.jpg')}}" width="30%" alt="">
</center>
<br>

<div class="row">
    <div class="col-md-12">
    {{-- Card Box --}}
        <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}">

       
                <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                    <h3 class="card-title float-none text-center">
                    <b>Registro de una nueva empresa</b>
                    </h3>
                </div>
         

            {{-- Card Body --}}
            <div class="card-body {{ $authType }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                <form action="{{url('/crear-empresa/create') }}"  method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" id="file" name="logo" accept=".jpg,.png" class="form-control" required>
                                @error('logo')
                                <small style="color: red;">{{$message}}</small>
                                @enderror
                                <br>
                                <center><output id="list"></output></center>
                               <script>
                                            function archivo(evt){
                                               var files = evt.target.files; 
                                               
                                               for(var i = 0, f; f = files[i]; i++ ){
                                                  
                                                  if(!f.type.match('image.*')){
                                                    continue;
                                                  }
                                                  var reader = new FileReader();
                                                  reader.onload = (function (theFile){
                                                    return function (e) {
                                                        
                                                        document.getElementById("list").innerHTML = ['<img class="thumb thumbail" src="',e.target.result,'" widtch="5%" title="',escape(theFile.name),'"/>'].join('');
                                                    };
                                                  })(f);
                                                  reader.readAsDataURL(f);

                                               }

                                            }
                                            document.getElementById('file').addEventListener('change', archivo, false);
                                       </script>
</div>

</div>
<div class="col-md-9">
<div class="row">
    <div class="col-md-4">
    <div class="form-group">
        <label for="select_pais">pais</label>
        <select name="pais" id="select_pais" class="form-control"> 
            @foreach($paises as $paise)
            <option value="{{$paise->id}}">{{$paise->name}}</option>
            @endforeach
           
            
</select>
                                        </div>

</div>
<div class="col-md-4">
    <div class="form-group">
        <label for="departamento">Estado/Provincia/Región</label>
        <div id="respuesta_pais">
            <!-- Aquí se cargará el select por AJAX -->
        </div>
    </div>
</div>




<div class="col-md-4">
    <div class="form-group">
        <label for="ciudad">Ciudad</label>
        <div id="respuesta_estado">
            <!-- Aquí se cargará el select por AJAX -->
        </div>
                                        </div>    
</div>

<div class="col-md-3">
    <div class="form-group">
        <label for="nombre_empresa">Nombre de la empresa</label>
        <input type="text" value="{{old('nombre_empresa')}}" class="form-control" id="nombre_empresa" name="nombre_empresa" placeholder="Ingresa el nombre" required>
        @error('nombre_empresa')
        <small style="color: red;">{{$message}}</small>
        @enderror
    </div>
</div>
                                        
<div class="col-md-3">
    <div class="form-group">
        <label for="tipo_empresa">Tipo de la empresa</label>
        <input type="text" value="{{old('tipo_empresa')}}" class="form-control" id="tipo_empresa" name="tipo_empresa" placeholder="Ingresa el tipo de empresa" required>
        @error('tipo_empresa')
        <small style="color: red;">{{$message}}</small>
        @enderror
    </div>
</div>


<div class="row">
    <div class="col-md-11">
        <div class="form-group">
            <label for="rfc">RFC</label>
            <input type="text" value="{{old('rfc')}}"class="form-control" id="rfc" name="rfc" placeholder="Ingresa el RFC" required>
            @error('rfc')
           <small style="color: red;">{{$message}}</small>
           @enderror
        </div>
    </div>
</div>


<div class="col-md-2">
    <div class="form-group">
        <label for="moneda">Moneda</label>
        <select name="moneda" id="moneda" class="form-control" required>
            @foreach($monedas as $moneda)
                <option value="{{ $moneda->symbol }}">
                    {{ $moneda->code }} - {{ $moneda->symbol }}
                </option>
            @endforeach
        </select>
    </div>
</div>


<div class="row">
    <div class="col-md-11">
        <div class="form-group">
            <label for="cantidad_impuesto">Cantidad de impuesto</label>
            <input type="number" value="{{old('cantidad_impuesto')}}" class="form-control" id="cantidad_impuesto" name="cantidad_impuesto" placeholder="Ej: 16" required>
            @error('cantidad_impuesto')
          <small style="color: red;">{{$message}}</small>
            @enderror 
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="nombre_impuesto">Nombre del impuesto</label>
        <input type="text" value="{{old('nombre_impuesto')}}" class="form-control" id="nombre_impuesto" name="nombre_impuesto" placeholder="Ej: IVA, ISR, etc." required>
        @error('nombre_impuesto')
        <small style="color: red;">{{$message}}</small>
        @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="telefono">Teléfonos de la empresa</label>
        <input type="text" value="{{old('telefono')}}" class="form-control" id="telefono" name="telefono" placeholder="Ej: 55 1234 5678" required>
        @error('telefono')
        <small style="color: red;">{{$message}}</small>
        @enderror
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        <label for="correo">Correo de la empresa</label>
        <input type="email" class="form-control" id="correo" name="correo" value="{{old('correo')}}" placeholder="correo@empresa.com" required>
        @error('correo')
        <small style="color: red;">{{$message}}</small>
        @enderror
    </div>
</div>


<div class="row">
    <div class="col-md-10">
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{old('direccion')}}" placeholder="Ingresa la dirección" required>
            @error('direccion')
            <small style="color: red;">{{$message}}</small>
            @enderror
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="codigo_postal">Código Postal</label>
            <input type="number" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="Ej: 12345" required>
        </div>
    </div>
</div>
 
<div class="row">
    <div class="col-md-4">
        <button type="submit" class="btn btn-primary">
            Crear empresa
        </button>
    </div>
</div>


</form>
            </div>

            {{-- Card Footer --}}
            @hasSection('auth_footer')
                <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                    @yield('auth_footer')
                </div>
            @endif

        </div>
</div>
</div>
       

       

    </div>




</form>
            </div>

            {{-- Card Footer --}}
            @hasSection('auth_footer')
                <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                    @yield('auth_footer')
                </div>
            @endif

        </div>
</div>
</div>
       

       

    </div>

@stop




@section('adminlte_js')
    @stack('js')
    @yield('js')

    <script>
    $('#select_pais').on('change', function() {
        var id_pais = $('#select_pais').val();
        if (id_pais) {
            $.ajax({
                url: "{{ url('crear-empresa/pais/') }}/" + id_pais, // Añadida la barra
                type: "GET",
                success: function(data) {
                    $('#respuesta_pais').html(data); // Agregado el #
                }
            });
        } else {
            alert('Debe seleccionar un país');
        }
    });
     </script>



  <script>
    $(document).on('change', '#select_estado',function() {
        var id_estado = $(this).val();
        if (id_estado) {
            $.ajax({
                url: "{{ url('crear-empresa/estado/') }}/" + id_estado, // Añadida la barra
                type: "GET",
                success: function(data) {
                    $('#respuesta_estado').html(data); // Agregado el #
                }
            });
        } else {
            alert('Debe seleccionar un estado');
        }
    });
     </script>
   


    
@endsection







