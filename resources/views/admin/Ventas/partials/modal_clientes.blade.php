<!-- Modal para seleccionar cliente -->
<div class="modal fade" id="modalClientes" tabindex="-1" role="dialog" aria-labelledby="modalClientesLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content border-primary">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="modalClientesLabel">Seleccionar cliente</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-sm table-hover" id="tabla_clientes">
          <thead class="thead-dark">
            <tr>
              <th>Nombre</th>
              <th>CI/NIT</th>
              <th>Teléfono</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($clientes as $cliente)
              <tr>
                <td>{{ $cliente->nombre_cliente }}</td>
                <td>{{ $cliente->nit_codigo }}</td>
                <td>{{ $cliente->telefono }}</td>
                <td class="text-center">
                  <button class="btn btn-sm btn-primary seleccionar-cliente-btn"
                          data-id="{{ $cliente->id }}"
                          data-nombre="{{ $cliente->nombre_cliente }}">
                    Seleccionar
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
