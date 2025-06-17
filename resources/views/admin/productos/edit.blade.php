@extends('adminlte::page')

@section('content_header')
    <h1><b>Producto / Modificar datos del producto</b></h1>
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
                <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- DATOS PRINCIPALES --}}
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="categoria_id">Categoría</label>
                                <select name="categoria_id" id="categoria_id" class="form-control" required>
                                    <option value="">Seleccione una categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ $categoria->id == $producto->categoria_id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <input type="text" class="form-control" name="codigo" value="{{ $producto->codigo }}" required>
                                @error('codigo')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nombre">Nombre del producto</label>
                                <input type="text" class="form-control" name="nombre" value="{{ $producto->nombre }}" required>
                                @error('nombre')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{ $producto->descripcion }}</textarea>
                                @error('descripcion')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- IMAGEN --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="imagen">Imagen</label>
                                <input type="file" name="imagen" id="imagen" accept="image/*" class="form-control-file">
                                @error('imagen')
                                    <small style="color: red;">{{ $message }}</small>
                                @enderror

                                @if($producto->imagen)
                                    <img id="imagen-actual" src="{{ asset('storage/'.$producto->imagen) }}" class="img-thumbnail mt-2" width="100%">

                                @endif

                                <div class="mt-2 text-center">
                                    <output id="preview"></output>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- INVENTARIO Y PRECIOS --}}
                    <div class="row">
                        @foreach ([
                            ['stock', 'Stock'],
                            ['stock_minimo', 'Stock mínimo'],
                            ['stock_maximo', 'Stock máximo'],
                            ['precio_compra', 'Precio compra'],
                            ['precio_venta', 'Precio venta'],
                            ['fecha_ingreso', 'Fecha ingreso']
                        ] as [$field, $label])
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="{{ $field }}">{{ $label }}</label>
                                    <input type="{{ $field == 'fecha_ingreso' ? 'date' : 'text' }}"
                                           class="form-control"
                                           name="{{ $field }}"
                                           id="{{ $field }}"
                                           value="{{ old($field, $producto->$field) }}"
                                           required>
                                    @error($field)
                                        <small style="color: red;">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- BOTONES --}}
                    <hr>
                    <div class="form-group">
                        <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Actualizar
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
        const imagenActual = document.getElementById('imagen-actual');

        // Oculta la imagen anterior si existe
        if (imagenActual) {
            imagenActual.style.display = 'none';
        }

        // Elimina cualquier preview anterior
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

