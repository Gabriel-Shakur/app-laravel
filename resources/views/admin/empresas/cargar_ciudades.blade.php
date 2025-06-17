<select name="ciudad" id="select_ciudades" class="form-control">
    <option value="">Seleccione una ciudad</option>
    @foreach($ciudades as $ciudad)
        <option value="{{ $ciudad->id }}">{{ $ciudad->name }}</option>
    @endforeach
</select>
