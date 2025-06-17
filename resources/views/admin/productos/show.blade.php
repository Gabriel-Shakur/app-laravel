@extends('adminlte::page')

@section('content_header')
    <h1><b>Producto / Datos del producto</b></h1>
    <hr>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Datos registrados</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    {{-- DATOS PRINCIPALES --}}
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="categoria_id">Categoría</label>
                            <p>{{$producto->categoria->nombre}}</p>
                        </div>

                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <p>{{$producto->codigo}}</p>
                        </div>

                        <div class="form-group">
                            <label for="nombre">Nombre del producto</label>
                            <p>{{$producto->nombre}}</p>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <p>{{$producto->descripcion}}</p>
                        </div>
                    </div>

                    {{-- IMAGEN --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="imagen">Imagen</label>
                            <br>
                            <img src="{{ asset('storage/'.$producto->imagen) }}" width="100%" class="img-thumbnail" alt="Imagen del producto">
                        </div>
                    </div>
                </div>

                {{-- INVENTARIO Y PRECIOS --}}
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <p>{{$producto->stock}}</p>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="stock_minimo">Stock mínimo</label>
                            <p>{{$producto->stock_minimo}}</p>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="stock_maximo">Stock máximo</label>
                            <p>{{$producto->stock_maximo}}</p>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="precio_compra">Precio compra</label>
                            <p>${{ number_format($producto->precio_compra, 2) }}</p>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="precio_venta">Precio venta</label>
                            <p>${{ number_format($producto->precio_venta, 2) }}</p>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_ingreso">Fecha ingreso</label>
                            <p>{{ \Carbon\Carbon::parse($producto->fecha_ingreso)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                {{-- BOTONES --}}
                <hr>
                <div class="form-group">
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
