@php
use Carbon\Carbon;
@endphp

{{-- Mostrar alertas --}}
@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Mostrar información de registros de Softland --}}
@if(isset($notasVentaSoftland) && $notasVentaSoftland->count() > 0)
    <div class="alert alert-info mb-3">
        <i class="fas fa-database"></i> <strong>Registros de Softland:</strong> {{ $notasVentaSoftland->count() }}
        @if($notasVentaSoftland->first() && isset($notasVentaSoftland->first()->nv_descripcion) && strpos($notasVentaSoftland->first()->nv_descripcion, 'PRUEBA') !== false)
            <span class="badge bg-warning text-dark ms-2">MODO PRUEBA</span>
        @else
            <span class="badge bg-success ms-2">CONECTADO</span>
        @endif
    </div>
@endif

<div class="table-responsive">
    <table class="table table-hover">
      <thead class="table-light">
        <tr>
          <th scope="col">N°</th>
          <th scope="col">Nota de Venta</th>
          <th scope="col">Estado Instalación</th>
          <th scope="col">Cliente</th>
          <th scope="col">Fecha Entrega</th>
          <th scope="col">Estado Softland</th>
          <th scope="col">Descripción Softland</th>
          <th scope="col">Vendedor</th>
          <th scope="col">Acciones</th> 
        </tr>
      </thead>
      
      <tbody>
        @php
        $counter = 1;
        @endphp
    
        @forelse ($calendario as $CalendarioDef1)
        @php
            $estados = $CalendarioDef1->agendaDefs->pluck('estado')->unique();
            $estadoInstalacion = 'Por Confirmar';

            if ($estados->contains('Calendarizado')) {
                $estadoInstalacion = 'Calendarizado';
            } elseif ($estados->count() == 1 && $estados->contains('Post-Venta')) {
                $estadoInstalacion = 'Post-Venta';
            }
            
            // Buscar datos relacionados en Softland por nota de venta
            $datoSoftland = isset($notasVentaSoftland) ? $notasVentaSoftland->firstWhere('nv_folio', $CalendarioDef1->nota_venta) : null;
        @endphp

        <tr>
            <th scope="row">{{ $counter++ }}</th>
            <td><strong>{{ $CalendarioDef1->nota_venta }}</strong></td>
            <td>
                <span class="badge 
                    @if($estadoInstalacion == 'Calendarizado') bg-success
                    @elseif($estadoInstalacion == 'Post-Venta') bg-info
                    @else bg-warning text-dark
                    @endif">
                    {{ $estadoInstalacion }}
                </span>
            </td>
            <td>{{ $CalendarioDef1->cliente ?? '-' }}</td>
            <td>
                @if($CalendarioDef1->fecha_instalacion)
                    {{ Carbon::parse($CalendarioDef1->fecha_instalacion)->format('d/m/Y') }}
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>
                @if($datoSoftland)
                    <span class="badge bg-primary">{{ $datoSoftland->nv_estado }}</span>
                @else
                    <span class="badge bg-secondary">No encontrado</span>
                @endif
            </td>
            <td>
                @if($datoSoftland)
                    <small class="text-muted">{{ Str::limit($datoSoftland->nv_descripcion, 50) }}</small>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>
                @if($datoSoftland)
                    <small>{{ $datoSoftland->nv_vend ?? '-' }}</small>
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('agenda3', ['id' => $CalendarioDef1->id]) }}" 
                       class="btn btn-outline-primary" 
                       title="Ver detalles">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('calendario_def.edit', $CalendarioDef1->id) }}" 
                       class="btn btn-outline-warning" 
                       title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center text-muted py-4">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>No hay registros disponibles</p>
            </td>
        </tr>
        @endforelse
      </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var fechaInicio = document.querySelector('input[name="fecha_inicio"]');
    var fechaFin = document.querySelector('input[name="fecha_fin"]');
    var boton = document.querySelector('.filtro-fechas button');

    if (fechaInicio && fechaFin && boton) {
        if (fechaInicio.value || fechaFin.value) {
            boton.textContent = 'Reestablecer';
        }
    
        boton.addEventListener('click', function(event) {
            if (fechaInicio.value || fechaFin.value) {
                event.preventDefault();
                window.location.href = '{{ route('calendario') }}'; 
            }
        });
    }
});
</script>