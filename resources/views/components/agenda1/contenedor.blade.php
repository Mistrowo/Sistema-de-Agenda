<!-- Contenedor Principal - Calendario de Instalaciones (Ancho Completo) -->
<div class="w-full px-4 sm:px-6 lg:px-8 py-4">
    
    @php
        // ✅ Obtener fecha seleccionada desde URL o usar la primera disponible
        $fechaActualSeleccionada = request()->query('fecha');
        
        // Si no hay fecha en URL, usar la primera fecha disponible
        if (!$fechaActualSeleccionada && isset($fechasInstalacion2) && count($fechasInstalacion2) > 0) {
            $fechaActualSeleccionada = $fechasInstalacion2[0];
        }
        
        // Limpiar la fecha (quitar hora si existe)
        if ($fechaActualSeleccionada && strpos($fechaActualSeleccionada, ' ') !== false) {
            $fechaActualSeleccionada = explode(' ', $fechaActualSeleccionada)[0];
        }
        
        // Debug
        // dd('Fecha seleccionada: ' . $fechaActualSeleccionada, 'Fechas disponibles:', $fechasInstalacion2, 'Items:', $agendaItems->count());
    @endphp
    
    <!-- Tabla de Calendario - Ancho Completo -->
    <div class="bg-white rounded-lg shadow-lg overflow-x-auto border border-gray-200">
        
        <!-- Tabla con ancho fijo para que se adapte -->
        <table class="w-full table-fixed border-collapse">
            
            <!-- Header de la Tabla -->
            <thead class="bg-gradient-to-r from-gray-100 to-gray-200 border-b-2 border-gray-300">
                <tr>
                    <th class="w-[10%] px-2 py-3 text-center font-bold text-gray-700 text-xs border-r border-gray-300">
                        BLOQUE
                    </th>
                    <th class="w-[11.25%] px-2 py-3 text-center font-bold text-gray-700 text-xs border-r border-gray-300">
                        DIEGO
                    </th>
                    <th class="w-[11.25%] px-2 py-3 text-center font-bold text-gray-700 text-xs border-r border-gray-300">
                        FRANCO
                    </th>
                    <th class="w-[11.25%] px-2 py-3 text-center font-bold text-gray-700 text-xs border-r border-gray-300">
                        GABRIEL
                    </th>
                    <th class="w-[11.25%] px-2 py-3 text-center font-bold text-gray-700 text-xs border-r border-gray-300">
                        JONATHAN
                    </th>
                    <th class="w-[11.25%] px-2 py-3 text-center font-bold text-gray-700 text-xs border-r border-gray-300">
                        VOLANTE
                    </th>
                    <th class="w-[11.25%] px-2 py-3 text-center font-bold text-gray-700 text-xs border-r border-gray-300">
                        ILESA
                    </th>
                    <th class="w-[11.25%] px-2 py-3 text-center font-bold text-gray-700 text-xs border-r border-gray-300">
                        BODEGA
                    </th>
                    <th class="w-[11.25%] px-2 py-3 text-center font-bold text-white text-xs bg-red-500">
                        POR CONFIRMAR
                    </th>
                </tr>
            </thead>

            <!-- Body de la Tabla -->
            <tbody>
                @foreach ([
                    ['bloque' => 'A-1', 'horario' => '08:00-10:00'],
                    ['bloque' => 'A-2', 'horario' => '10:00-12:00'],
                    ['bloque' => 'A-3', 'horario' => '12:00-14:00'],
                    ['bloque' => 'A-4', 'horario' => '14:00-16:00'],
                    ['bloque' => 'A-5', 'horario' => '16:00-18:00'],
                    ['bloque' => 'A-6', 'horario' => '18:00-20:00'],
                    ['bloque' => 'A-7', 'horario' => '20:00-22:00'],
                    ['bloque' => 'A-8', 'horario' => '22:00-24:00']
                ] as $bloqueInfo)
                    
                    @php
                        $instaladoresPorBloque = [];
                        
                        // Recorrer todos los items de la agenda
                        foreach ($agendaItems as $item) {
                            // Extraer fecha del item (sin hora)
                            $itemFecha = null;
                            if ($item->fecha_instalacion2) {
                                $itemFecha = explode(' ', $item->fecha_instalacion2)[0];
                            }
                            
                            // Verificar si coincide el bloque y la fecha
                            if ($item->bloque == $bloqueInfo['bloque'] && $itemFecha == $fechaActualSeleccionada) {
                                // Agrupar por instalador
                                if (!isset($instaladoresPorBloque[$item->instalador])) {
                                    $instaladoresPorBloque[$item->instalador] = [];
                                }
                                $instaladoresPorBloque[$item->instalador][] = $item;
                            }
                        }
                    @endphp

                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        
                        <!-- Columna de Horario -->
                        <td class="px-2 py-2 bg-gray-100 font-semibold text-gray-700 text-[11px] text-center border-r border-gray-300">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-clock text-blue-500 text-xs mb-1"></i>
                                <span>{{ $bloqueInfo['horario'] }}</span>
                            </div>
                        </td>

                        <!-- Columnas de Instaladores -->
                        @foreach (['DIEGO', 'FRANCO', 'GABRIEL', 'JONATHAN', 'VOLANTE', 'ILESA', 'BODEGA'] as $index => $instalador)
                            <td class="data-block p-1 border-r border-gray-200 hover:bg-blue-50 cursor-pointer transition-all align-top" 
                                id="bloque-{{ strtolower(str_replace('-', '-', $bloqueInfo['bloque'])) }}-{{ $index + 1 }}">
                                
                                @if (isset($instaladoresPorBloque[$instalador]) && count($instaladoresPorBloque[$instalador]) > 0)
                                    @foreach ($instaladoresPorBloque[$instalador] as $item)
                                        @php
                                            $clasesEstado = [
                                                'Calendarizado' => 'bg-blue-100 border-blue-300 text-blue-800',
                                                'En espera' => 'bg-red-100 border-red-300 text-red-800',
                                                'Post-Venta' => 'bg-green-100 border-green-300 text-green-800'
                                            ];
                                            $claseEstado = $clasesEstado[$item->estado] ?? 'bg-gray-100 border-gray-300 text-gray-800';
                                        @endphp
                                        
                                        <div class="rounded p-1.5 border {{ $claseEstado }} shadow-sm hover:shadow-md transition-shadow mb-1">
                                            <div class="item-info text-[10px] leading-tight">
                                                <div class="font-bold mb-0.5 break-words" title="NV: {{ $item->nota_venta }}">
                                                    <i class="fas fa-file-alt mr-0.5"></i>{{ $item->nota_venta }}
                                                </div>
                                                <div class="mb-0.5 break-words" title="{{ $item->calendarioDef->cliente ?? 'Sin cliente' }}">
                                                    <i class="fas fa-user mr-0.5"></i>{{ $item->calendarioDef->cliente ?? 'Sin cliente' }}
                                                </div>
                                                @if($item->nota_resumida2 && $item->nota_resumida2 != 'Completar Campo')
                                                    <div class="text-[9px] italic break-words" title="{{ $item->nota_resumida2 }}">
                                                        {{ $item->nota_resumida2 }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </td>
                        @endforeach

                        <!-- Columna POR CONFIRMAR -->
                        <td class="data-block p-1 bg-red-50 hover:bg-red-100 cursor-pointer transition-all align-top" 
                            id="bloque-{{ strtolower(str_replace('-', '-', $bloqueInfo['bloque'])) }}-confirmar">
                            
                            @if (isset($instaladoresPorBloque['POR CONFIRMAR']) && count($instaladoresPorBloque['POR CONFIRMAR']) > 0)
                                @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
                                    @php
                                        $clasesEstado = [
                                            'Calendarizado' => 'bg-blue-100 border-blue-300 text-blue-800',
                                            'En espera' => 'bg-red-100 border-red-300 text-red-800',
                                            'Post-Venta' => 'bg-green-100 border-green-300 text-green-800'
                                        ];
                                        $claseEstado = $clasesEstado[$item->estado] ?? 'bg-gray-100 border-gray-300 text-gray-800';
                                    @endphp
                                    
                                    <div class="rounded p-1.5 border {{ $claseEstado }} shadow-sm hover:shadow-md transition-shadow mb-1">
                                        <div class="item-info text-[10px] leading-tight">
                                            <div class="font-bold mb-0.5 break-words" title="NV: {{ $item->nota_venta }}">
                                                <i class="fas fa-file-alt mr-0.5"></i>{{ $item->nota_venta }}
                                            </div>
                                            <div class="mb-0.5 break-words" title="{{ $item->calendarioDef->cliente ?? 'Sin cliente' }}">
                                                <i class="fas fa-user mr-0.5"></i>{{ $item->calendarioDef->cliente ?? 'Sin cliente' }}
                                            </div>
                                            @if($item->nota_resumida2 && $item->nota_resumida2 != 'Completar Campo')
                                                <div class="text-[9px] italic break-words" title="{{ $item->nota_resumida2 }}">
                                                    {{ $item->nota_resumida2 }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Leyenda de Estados -->
    <div class="mt-3 bg-white rounded-lg shadow-sm p-3 border border-gray-200">
        <div class="flex flex-wrap items-center gap-3 justify-center text-xs">
            <span class="font-semibold text-gray-700">
                <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                Leyenda:
            </span>
            
            <div class="flex items-center gap-1.5 bg-blue-100 px-2 py-1 rounded border border-blue-300">
                <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                <span class="font-medium text-blue-800">Calendarizado</span>
            </div>
            
            <div class="flex items-center gap-1.5 bg-red-100 px-2 py-1 rounded border border-red-300">
                <div class="w-2 h-2 rounded-full bg-red-400"></div>
                <span class="font-medium text-red-800">En Espera</span>
            </div>
            
            <div class="flex items-center gap-1.5 bg-green-100 px-2 py-1 rounded border border-green-300">
                <div class="w-2 h-2 rounded-full bg-green-400"></div>
                <span class="font-medium text-green-800">Post Venta</span>
            </div>
        </div>
    </div>
</div>

{{-- Script para sincronizar el selector con la URL --}}
<script>
(function() {
    'use strict';
    
    console.log('📅 Iniciando script de calendario');
    
    function inicializarSelector() {
        // Buscar el selector
        var selector = document.getElementById('fechaInstalacion2') || 
                      document.querySelector('select[name="fecha_instalacion2"]') ||
                      document.querySelector('[id*="fecha"]');
        
        if (!selector) {
            console.error('❌ No se encontró el selector de fecha');
            return;
        }
        
        console.log('✅ Selector encontrado:', selector.id);
        
        // Obtener fecha de la URL
        var urlParams = new URLSearchParams(window.location.search);
        var fechaURL = urlParams.get('fecha');
        
        console.log('📅 Fecha en URL:', fechaURL);
        console.log('📅 Valor actual del selector:', selector.value);
        
        // Si hay fecha en URL, actualizar el selector
        if (fechaURL) {
            // Buscar la opción correcta
            var opciones = selector.options;
            for (var i = 0; i < opciones.length; i++) {
                var valorOpcion = opciones[i].value;
                // Comparar solo la fecha (sin hora)
                if (valorOpcion.split(' ')[0] === fechaURL.split(' ')[0]) {
                    selector.selectedIndex = i;
                    console.log('✅ Selector actualizado a:', valorOpcion);
                    break;
                }
            }
        }
        
        // Agregar evento de cambio
        selector.addEventListener('change', function() {
            var nuevaFecha = this.value;
            console.log('🔄 Fecha cambiada a:', nuevaFecha);
            
            if (!nuevaFecha) {
                console.log('⚠️ No hay fecha seleccionada');
                return;
            }
            
            // Extraer solo la fecha (sin hora)
            var soloFecha = nuevaFecha.split(' ')[0];
            
            // Crear nueva URL
            var url = new URL(window.location.href);
            url.searchParams.set('fecha', soloFecha);
            
            console.log('🔄 Recargando con:', url.toString());
            
            // Recargar
            window.location.href = url.toString();
        });
        
        console.log('✅ Listener de cambio agregado');
    }
    
    // Ejecutar cuando cargue el DOM
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', inicializarSelector);
    } else {
        inicializarSelector();
    }
})();
</script>


