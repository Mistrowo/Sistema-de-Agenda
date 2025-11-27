@php
use Carbon\Carbon;
@endphp

{{-- Alertas con Tailwind --}}
@if(session('warning'))
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle text-yellow-400 mr-3"></i>
            <p class="text-yellow-700 text-sm font-medium">{{ session('warning') }}</p>
        </div>
    </div>
@endif

@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4 rounded-r-lg shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-400 mr-3"></i>
            <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
        </div>
    </div>
@endif



{{-- Tabla con Tailwind --}}
<div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">N°</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Folio</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Descripción</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cliente</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Vend.</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Estado</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">F. Emisión</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">F. Entrega</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Estado Instalación</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            
            <tbody class="bg-white divide-y divide-gray-200">
                @php
                $counter = ($notasVentaSoftland->currentPage() - 1) * $notasVentaSoftland->perPage() + 1;
                @endphp
            
                @forelse ($notasVentaSoftland as $nota)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $counter++ }}</td>
                    <td class="px-4 py-3 text-sm font-bold text-blue-600">{{ $nota->nv_folio }}</td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        {{ Str::limit($nota->nv_descripcion, 40) }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700">
                        {{ Str::limit($nota->nv_cliente, 30) }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $nota->nv_vend ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            @if($nota->nv_estado == 'A') bg-green-100 text-green-700
                            @elseif($nota->nv_estado == 'P') bg-yellow-100 text-yellow-700
                            @elseif($nota->nv_estado == 'C') bg-blue-100 text-blue-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ $nota->nv_estado }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        @if($nota->nv_femision)
                            {{ Carbon::parse($nota->nv_femision)->format('d/m/Y') }}
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <div class="flex flex-col gap-1">
                            @if($nota->fecha_entrega_prioritaria)
                                <span class="text-gray-700 font-medium">
                                    {{ Carbon::parse($nota->fecha_entrega_prioritaria)->format('d/m/Y') }}
                                </span>
                                @if($nota->tieneFechaModificada())
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full" title="Fecha actualizada desde Nvgestion">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Modificada
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gray-100 text-gray-600 text-xs rounded-full" title="Fecha original de Softland">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Original
                                    </span>
                                @endif
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </div>
                    </td>
                    
                    {{-- Estado de Instalación --}}
                    <td class="px-4 py-3 text-center">
                        @if(isset($notasConAgenda[$nota->nv_folio]))
                            @php
                                $estados = $notasConAgenda[$nota->nv_folio];
                                $totalInstalaciones = $estados['total'];
                            @endphp
                            
                            {{-- Badge AGENDADO --}}
                            <div class="mb-2">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full inline-flex items-center gap-1">
                                    <i class="fas fa-calendar-check"></i>
                                    AGENDADO
                                </span>
                            </div>
                            
                            {{-- Detalles --}}
                            <div class="flex flex-wrap gap-1 justify-center">
                                @if($estados['calendarizado'] > 0)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full inline-flex items-center gap-1" title="Calendarizado">
                                        <i class="fas fa-check-circle text-xs"></i>
                                        {{ $estados['calendarizado'] }}
                                    </span>
                                @endif
                                
                                @if($estados['en_espera'] > 0)
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded-full inline-flex items-center gap-1" title="En espera">
                                        <i class="fas fa-clock text-xs"></i>
                                        {{ $estados['en_espera'] }}
                                    </span>
                                @endif
                                
                                @if($estados['post_venta'] > 0)
                                    <span class="px-2 py-1 bg-cyan-100 text-cyan-700 text-xs font-semibold rounded-full inline-flex items-center gap-1" title="Post-Venta">
                                        <i class="fas fa-tools text-xs"></i>
                                        {{ $estados['post_venta'] }}
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $totalInstalaciones }} {{ $totalInstalaciones == 1 ? 'instalación' : 'instalaciones' }}
                            </p>
                        @else
                            {{-- Badge SIN AGENDAR --}}
                            <span class="px-3 py-1.5 bg-red-100 text-red-700 text-xs font-bold rounded-full inline-flex items-center gap-1">
                                <i class="fas fa-calendar-times"></i>
                                SIN AGENDAR
                            </span>
                        @endif
                    </td>
                    
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('agenda3', ['folio' => $nota->nv_folio]) }}" 
                           class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                            <i class="fas fa-eye mr-1"></i>
                            Ver
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-4 py-12 text-center">
                        <i class="fas fa-inbox text-gray-300 text-5xl mb-4 block"></i>
                        <p class="text-gray-500 font-medium">No hay registros disponibles en Softland</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginación con Tailwind --}}
@if(method_exists($notasVentaSoftland, 'links'))
<div class="flex flex-col sm:flex-row justify-between items-center mt-4 gap-4">
    <div class="text-sm text-gray-600">
        Mostrando <span class="font-semibold">{{ $notasVentaSoftland->firstItem() ?? 0 }}</span> - 
        <span class="font-semibold">{{ $notasVentaSoftland->lastItem() ?? 0 }}</span> de 
        <span class="font-semibold">{{ $notasVentaSoftland->total() }}</span> registros
    </div>
    <div>
        {{ $notasVentaSoftland->links() }}
    </div>
</div>
@endif