@extends('adminlte::page')

@section('content_header')
    <h1>Configuraciones/Editar</h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}">

            <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                <h3 class="card-title float-none text-center">
                    <b>Datos registrados</b>
                </h3>
            </div>

            <div class="card-body {{ $authType ?? 'default' }}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                <form action="{{ url('/admin/configuracion', $empresa->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Logo -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" id="file" name="logo" accept=".jpg,.png" class="form-control">
                                @error('logo')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                                <br>
                                
                                <!-- Nueva imagen previsualizada -->
                                <div id="list"></div>
                                
                                <!-- Imagen actual -->
                                <center>
                                    <img id="logo_actual" src="{{ asset('storage/' . $empresa->logo) }}" width="30%" alt="logo">
                                </center>
                            </div>
                        </div>

                        <!-- País -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="select_pais">País</label>
                                <select name="pais" id="select_pais" class="form-control">
                                    @foreach($paises as $paise)
                                        <option value="{{ $paise->id }}" {{ $empresa->pais == $paise->id ? 'selected' : '' }}>{{ $paise->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Departamento -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="departamento">Estado/Provincia/Región</label>
                                <select name="departamento" id="select_departamento_2" class="form-control">
                                    @foreach($departamentos as $departamento)
                                        <option value="{{ $departamento->id }}" {{ $empresa->departamento == $departamento->id ? 'selected' : '' }}>{{ $departamento->name }}</option>
                                    @endforeach
                                </select>
                                <div id="respuesta_pais"></div>
                            </div>
                        </div>

                        <!-- Ciudad -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ciudad">Ciudad</label>
                                <select name="ciudad" id="select_ciudad_2" class="form-control">
                                    @foreach($ciudades as $ciudade)
                                        <option value="{{ $ciudade->id }}" {{ $empresa->ciudad == $ciudade->id ? 'selected' : '' }}>{{ $ciudade->name }}</option>
                                    @endforeach
                                </select>
                                <div id="respuesta_estado"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Datos empresa -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre_empresa">Nombre de la empresa</label>
                                <input type="text" value="{{ $empresa->nombre_empresa }}" class="form-control" name="nombre_empresa" required>
                                @error('nombre_empresa') <small style="color: red;">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tipo_empresa">Tipo de la empresa</label>
                                <input type="text" value="{{ $empresa->tipo_empresa }}" class="form-control" name="tipo_empresa" required>
                                @error('tipo_empresa') <small style="color: red;">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="rfc">RFC</label>
                                <input type="text" value="{{ $empresa->rfc }}" class="form-control" name="rfc" required>
                                @error('rfc') <small style="color: red;">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="moneda">Moneda</label>
                                <select name="moneda" class="form-control" required>
                                    @foreach($monedas as $moneda)
                                        <option value="{{ $moneda->symbol }}" {{ $empresa->moneda == $moneda->symbol ? 'selected' : '' }}>{{ $moneda->symbol }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Impuestos y contacto -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="cantidad_impuesto">Cantidad de impuesto</label>
                                <input type="number" value="{{ $empresa->cantidad_impuesto }}" class="form-control" name="cantidad_impuesto" required>
                                @error('cantidad_impuesto') <small style="color: red;">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre_impuesto">Nombre del impuesto</label>
                                <input type="text" value="{{ $empresa->nombre_impuesto }}" class="form-control" name="nombre_impuesto" required>
                                @error('nombre_impuesto') <small style="color: red;">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" value="{{ $empresa->telefono }}" class="form-control" name="telefono" required>
                                @error('telefono') <small style="color: red;">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" value="{{ $empresa->correo }}" class="form-control" name="correo" required>
                                @error('correo') <small style="color: red;">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Dirección y CP -->
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" value="{{ $empresa->direccion }}" class="form-control" name="direccion" required>
                                @error('direccion') <small style="color: red;">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="codigo_postal">Código Postal</label>
                                <input type="number" value="{{ $empresa->codigo_postal }}" class="form-control" name="codigo_postal" required>
                            </div>
                        </div>
                    </div>

                    <!-- Botón -->
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success">Actualizar datos</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    // Previsualizar nueva imagen seleccionada
    function archivo(evt) {
        var files = evt.target.files;
        for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*')) continue;

            var reader = new FileReader();
            reader.onload = (function(theFile) {
                return function(e) {
                    document.getElementById("logo_actual").style.display = "none";
                    document.getElementById("list").innerHTML =
                        '<img class="img-fluid rounded shadow" src="' + e.target.result + '" width="30%" />';
                };
            })(f);
            reader.readAsDataURL(f);
        }
    }
    document.getElementById('file').addEventListener('change', archivo, false);

    // AJAX para cargar departamentos al seleccionar país
    $('#select_pais').on('change', function() {
        var id_pais = $(this).val();
        if (id_pais) {
            $.ajax({
                url: "{{ url('admin/configuracion/pais/') }}/" + id_pais,
                type: "GET",
                success: function(data) {
                    $('#select_departamento_2').hide();
                    $('#respuesta_pais').html(data);
                }
            });
        } else {
            alert('Debe seleccionar un país');
        }
    });

    // AJAX para cargar ciudades al seleccionar departamento
    $(document).on('change', '#select_estado', function() {
        var id_estado = $(this).val();
        if (id_estado) {
            $.ajax({
                url: "{{ url('admin/configuracion/estado/') }}/" + id_estado,
                type: "GET",
                success: function(data) {
                    $('#select_ciudad_2').hide();
                    $('#respuesta_estado').html(data);
                }
            });
        } else {
            alert('Debe seleccionar un estado');
        }
    });
</script>
@stop
