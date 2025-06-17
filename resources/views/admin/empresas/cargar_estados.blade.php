<select name="departamento" id="select_estado" class="form-control">
    <option value="">Seleccione un estado</option>
    @foreach($estados as $estado)
        <option value="{{ $estado->id }}">{{ $estado->name }}</option>
    @endforeach
</select>
