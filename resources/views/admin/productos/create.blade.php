@extends('adminlte::page')

@section('content_header')
    <h1><b>Producto / Registro de un nuevo producto</b></h1>
    <hr>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Ingrese los datos</h3>
            </div>

            <div class="card-body">
                <form action="{{ url('/admin/productos/create') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        {{-- DATOS PRINCIPALES --}}
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="categoria_id">Categoría</label>
                                <select name="categoria_id" id="categoria_id" class="form-control" required>
                                    <option value="">Seleccione una categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <input type="text" class="form-control" name="codigo" id="codigo" value="{{ old('codigo') }}" required>
                                @error('codigo')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nombre">Nombre del producto</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
                                @error('nombre')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- IMAGEN --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="imagen">Imagen</label>
                                <input type="file" name="imagen" id="imagen" accept=".jpg,.jpeg,.png" class="form-control-file">
                                @error('imagen')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                                <div class="mt-2 text-center">
                                    <output id="preview"></output>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- INVENTARIO Y PRECIOS --}}
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control" name="stock" id="stock" value="{{ old('stock', 0) }}" required>
                                @error('stock')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="stock_minimo">Stock mínimo</label>
                                <input type="number" class="form-control" name="stock_minimo" id="stock_minimo" value="{{ old('stock_minimo', 0) }}" required>
                                @error('stock_minimo')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="stock_maximo">Stock máximo</label>
                                <input type="number" class="form-control" name="stock_maximo" id="stock_maximo" value="{{ old('stock_maximo', 0) }}" required>
                                @error('stock_maximo')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="precio_compra">Precio compra</label>
                                <input type="text" class="form-control" name="precio_compra" id="precio_compra" value="{{ old('precio_compra') }}" required>
                                @error('precio_compra')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="precio_venta">Precio venta</label>
                                <input type="text" class="form-control" name="precio_venta" id="precio_venta" value="{{ old('precio_venta') }}" required>
                                @error('precio_venta')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha_ingreso">Fecha ingreso</label>
                                <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso" value="{{ old('fecha_ingreso') }}" required>
                                @error('fecha_ingreso')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- BOTONES --}}
                    <hr>
                    <div class="form-group">
                        <a href="{{ url('/admin/categorias') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- VISTA PREVIA DE IMAGEN --}}
<script>
    document.getElementById('imagen').addEventListener('change', function(evt) {
        const files = evt.target.files;
        const preview = document.getElementById('preview');
        preview.innerHTML = '';

        for (const file of files) {
            if (!file.type.match('image.*')) continue;

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = "img-thumbnail";
                img.style.maxWidth = "120px";
                img.style.marginTop = "10px";
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
