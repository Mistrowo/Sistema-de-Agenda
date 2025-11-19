
@php
use Carbon\Carbon;
@endphp


    


  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
            <th scope="col">N°</th>
            <th scope="col">Nota Venta</th>
            <th scope="col">Descripción</th>
            <th scope="col">Cliente</th>
            <th scope="col">Ejecutivo</th>
            <th scope="col">Fecha Fabril</th>
            <th scope="col">Fecha Despacho</th>
            <th scope="col">Fecha Entrega</th>
            <th scope="col">Detalle</th>

            <th scope="col">Estado</th>

            <th colspan="2" scope="col" style="text-align: center;">Despacho</th>
            <th scope="col">Días para Entregar</th>
            <th scope="col"></th> 
        </tr>
        <tr>
            <th colspan="10"></th>
            <th scope="col">Estado</th>
            <th scope="col">Porcentaje</th>
            <th colspan="2"></th> 
        </tr>
    </thead>
    <tbody>
        @php $counter = 1; @endphp
        @foreach ($calendario as $CalendarioDef)
            @php
                $estadoClase = $CalendarioDef->calendarizado ? 'estado-calendarizado' : 'estado-en-espera';
                $diasParaEntregar = '-';
                foreach ($CalendarioDef->agendaDefs as $agendaDef) {
                    if (isset($agendaDef->fecha_entrega)) {
                        $fechaEntrega = Carbon::parse($agendaDef->fecha_entrega);
                        $diasParaEntregar = Carbon::now()->diffInDays($fechaEntrega, false);
                        $diasParaEntregar = $diasParaEntregar > 0 ? $diasParaEntregar . ' días restantes' : 'Fecha pasada';
                    }
                }
            @endphp
    
            <tr class="{{ $estadoClase }}">
                <th scope="row">{{ $counter }}</th>
                <td>{{ $CalendarioDef->nota_venta ?? '-' }}</td>
                <td>{{ $CalendarioDef->descripcion ?? '-' }}</td>
                <td>{{ $CalendarioDef->cliente ?? '-' }}</td>
                <td>{{ $CalendarioDef->ejecutivo ?? '-' }}</td>
                <td>{{ $CalendarioDef->fecha_fabril ?? '-' }}</td>
                <td>{{ $CalendarioDef->fecha_instalacion ?? '-' }}</td>
                <td>-</td>
                <td>{{ $CalendarioDef->detalle ?? '-' }}</td>

                <td>{{ $CalendarioDef->calendarizado ? 'Calendarizado' : 'En espera' }}</td>
                <td style="text-align: center;">
                  @if($CalendarioDef->estado_despacho == 'Pendiente')
                      <button type="button" class="btn btn-warning btn-sm filtro-pendiente" data-toggle="modal" data-target="#estadoDespachoModal{{ $CalendarioDef->id }}" style="padding: 0.15rem 0.3rem; font-size: 0.75rem; line-height: 1;"  data-estado="{{ $CalendarioDef->estado_despacho }}">
                          <i class="fas fa-exclamation-triangle"></i>
                      </button>
                  @else
                      <button type="button" class="btn btn-success btn-sm filtro-finalizado" data-toggle="modal" data-target="#estadoDespachoModal{{ $CalendarioDef->id }}" style="padding: 0.15rem 0.3rem; font-size: 0.75rem; line-height: 1;"  data-estado="{{ $CalendarioDef->estado_despacho }}">
                          <i class="fas fa-check"></i>
                      </button>
                  @endif
              </td>
                <td style="text-align: center;">
                  @if (isset($CalendarioDef->porcentajeDespachado))
                      {{ $CalendarioDef->porcentajeDespachado }}%
                  @else
                      0%
                  @endif
              </td>
                <td>{{ $diasParaEntregar }}</td>
                <td>
                    <a href="{{ route('agenda6', ['id' => $CalendarioDef->id]) }}" class="tooltip-container">
                        <i class="fas fa-edit"></i>
                        <span class="tooltip-text">Editar NV</span>
                    </a> 
                    <form id="delete-form-{{ $CalendarioDef->id }}" action="{{ route('calendario_def.destroy', $CalendarioDef->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <a href="#" onclick="event.preventDefault(); if(confirm('¿Estás seguro de que quieres eliminar esto?')){ document.getElementById('delete-form-{{ $CalendarioDef->id }}').submit(); }" class="tooltip-container">
                        <i class="fas fa-trash"></i>
                        <span class="tooltip-text">Eliminar NV</span>
                    </a>
                </td>
            </tr>
           
        














                @php $counter++; @endphp

                <div class="modal fade" id="estadoDespachoModal{{ $CalendarioDef->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $CalendarioDef->id }}" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel{{ $CalendarioDef->id }}">Editar Estado de Despacho</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                    <form method="POST" action="{{ route('actualizacion', ['calendario_def' => $CalendarioDef->id]) }}">
                        @csrf
                        @method('PUT')
                      <div class="modal-body">

                      

                          <div class="form-group d-flex align-items-center">
                            <div class="form-check mr-3">
                              <input class="form-check-input" type="radio" name="estado_despacho" value="Pendiente" data-calendario-def-id="{{ $CalendarioDef->id }}" onclick="toggleComentario('{{ $CalendarioDef->id }}')">
                              <label class="form-check-label" for="pendiente{{ $CalendarioDef->id }}">
                                Pendiente
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="estado_despacho" value="Finalizado" data-calendario-def-id="{{ $CalendarioDef->id }}" onclick="toggleComentario('{{ $CalendarioDef->id }}')">
                              <label class="form-check-label" for="finalizado{{ $CalendarioDef->id }}">
                                Finalizado
                              </label>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="comentario{{ $CalendarioDef->id }}">Comentario:</label>
                            <textarea class="form-control" id="comentario{{ $CalendarioDef->id }}" name="comentario" {{ $CalendarioDef->estado_despacho == 'Finalizado' ? 'disabled' : '' }}>{{ trim($CalendarioDef->comentario ?? '') }}</textarea>

                            </textarea>
                          </div>
                        
                          
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                      </div>
                    </form>
                    </div>
                  </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>

<script>
 document.addEventListener('DOMContentLoaded', function() {
    var fechaDesde = document.querySelector('input[name="fecha_desde"]');
    var fechaHasta = document.querySelector('input[name="fecha_hasta"]');

    var fechaDesdeGuardada = localStorage.getItem('fecha_desde');
    var fechaHastaGuardada = localStorage.getItem('fecha_hasta');

    if (fechaDesdeGuardada) {
        fechaDesde.value = fechaDesdeGuardada;
        fechaHasta.removeAttribute('disabled');
        fechaHasta.setAttribute('min', fechaDesdeGuardada);
    }

    if (fechaHastaGuardada) {
        fechaHasta.value = fechaHastaGuardada;
    }

    fechaDesde.addEventListener('change', function() {
        fechaHasta.setAttribute('min', fechaDesde.value);
        fechaHasta.removeAttribute('disabled');
        localStorage.setItem('fecha_desde', fechaDesde.value);
    });

    fechaHasta.addEventListener('change', function() {
        localStorage.setItem('fecha_hasta', fechaHasta.value);
    });

    var urlParams = new URLSearchParams(window.location.search);
    if ((fechaDesdeGuardada || fechaHastaGuardada) && (!urlParams.has('fecha_desde') || !urlParams.has('fecha_hasta'))) {
        var form = document.querySelector('.filtro-fechas form');
        form.submit();
    }

    // Omití la parte de los botonesGuardarProyecto ya que no parece relacionada con el problema de la URL.
});

 </script>
 