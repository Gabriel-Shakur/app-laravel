@extends('adminlte::page')

@section('title', 'Editar Compra #'.$compra->id)

@section('content_header')
    <h1>Editar Compra #{{ $compra->id }}</h1>
@stop


@section('content')
<form action="{{ url('/admin/compras', $compra->id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Información de la Compra --}}
    <div class="card">
        <div class="card-header bg-primary text-white">
            <strong>Información de la Compra</strong>
        </div>
        <div class="card-body">
            {{-- Proveedor --}}
            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-control">
                    <option value="">Seleccione un proveedor</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" 
                            {{ $compra->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                            {{ $proveedor->empresa }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Fecha --}}
            <div class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" 
                    value="{{ $compra->fecha ? \Carbon\Carbon::parse($compra->fecha)->format('Y-m-d') : '' }}">
            </div>

            {{-- Comprobante --}}
            <div class="form-group">
                <label for="comprobante">Comprobante</label>
                <input type="text" name="comprobante" id="comprobante" class="form-control" 
                    value="{{ old('comprobante', $compra->comprobante) }}">
            </div>
        </div>
    </div>

    {{-- Detalles de Productos --}}
    <div class="card mt-3">
        <div class="card-header bg-secondary text-white">
            <strong>Productos Comprados</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tablaDetalle">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Código</th>
                        <th>Cantidad</th>
                        <th>Precio Compra</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total_compra = 0; @endphp

                    @foreach ($compra->detalles as $detalle)
                        @php $total_compra += $detalle->producto->precio_compra; @endphp
                        <tr>
                            <td>{{ optional($detalle->producto)->nombre ?? '[Producto eliminado]' }}</td>
                            <td>{{ optional($detalle->producto)->codigo ?? '-' }}</td>
                            <td>
                                <input type="number" min="1" name="detalles[{{ $detalle->id }}][cantidad]" 
                                    value="{{ $detalle->cantidad }}" class="form-control">
                            </td>
                            <td>
                                <input type="text" name="detalles[{{ $detalle->id }}][precio_compra]" 
                                    value="{{ number_format($detalle->producto->precio_compra, 2) }}" class="form-control">
                            </td>
                            <td>
                                <form action="{{ route('admin.compras.detalle.destroy', $detalle->id) }}" method="POST"
                                      onsubmit="return confirm('¿Deseas eliminar este producto de la compra?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total de la compra:</th>
                        <th>${{ number_format($total_compra, 2) }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Botones --}}
    <div class="mt-3">
        <a href="{{ route('admin.compras.index') }}" class="btn btn-secondary">Volver</a>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </div>
</form>
@stop

@section('js')
<script>
    $(document).ready(function () {
        $('#tablaDetalle').DataTable({
            paging: true,
            searching: false,
            ordering: false
        });
    });
</script>
@stop
