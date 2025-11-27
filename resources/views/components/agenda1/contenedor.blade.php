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
    @endphp
    
    {{-- ✅ BARRA DE HERRAMIENTAS CON BOTÓN DE ELIMINACIÓN --}}
    <div class="bg-white rounded-lg shadow-md p-4 mb-4 border border-gray-200" id="barraHerramientas" style="display: none;">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-3">
                <span class="text-sm font-semibold text-gray-700">
                    <i class="fas fa-check-square text-blue-500 mr-2"></i>
                    <span id="contadorSeleccionados">0</span> bloque(s) seleccionado(s)
                </span>
            </div>
            <div class="flex items-center gap-2">
                <button 
                    id="btnSeleccionarTodos"
                    class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                    <i class="fas fa-check-double"></i>
                    <span class="hidden sm:inline">Seleccionar Todo</span>
                </button>
                <button 
                    id="btnDeseleccionarTodos"
                    class="px-3 py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span class="hidden sm:inline">Deseleccionar</span>
                </button>
                <button 
                    id="btnEliminarSeleccionados"
                    class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2">
                    <i class="fas fa-trash-alt"></i>
                    <span class="hidden sm:inline">Eliminar Seleccionados</span>
                </button>
            </div>
        </div>
    </div>
    
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
                            <td class="data-block p-1 border-r border-gray-200 hover:bg-blue-50 transition-all align-top" 
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
                                            
                                            // ✅ Preparar datos para el atributo data-info
                                            $dataInfo = json_encode([
                                                'nota_venta' => $item->nota_venta,
                                                'instalador' => $item->instalador,
                                                'bloque' => $item->bloque,
                                                'fecha_instalacion2' => $item->fecha_instalacion2
                                            ]);
                                        @endphp
                                        
                                        {{-- ✅ WRAPPER CON CLASE PARA IDENTIFICAR Y EVITAR CONFLICTO --}}
                                        <div class="bloque-item-wrapper rounded p-1.5 border {{ $claseEstado }} shadow-sm hover:shadow-md transition-shadow mb-1 relative cursor-pointer"
                                             data-nota-venta="{{ $item->nota_venta }}"
                                             data-instalador="{{ $item->instalador }}"
                                             data-bloque="{{ $item->bloque }}"
                                             data-fecha="{{ $item->fecha_instalacion2 }}">
                                            
                                            {{-- ✅ CHECKBOX DE SELECCIÓN CON WRAPPER --}}
                                            <div class="checkbox-wrapper absolute top-1 right-1 z-20 p-1 bg-white rounded shadow-sm">
                                                <input 
                                                    type="checkbox" 
                                                    class="checkbox-item w-4 h-4 cursor-pointer accent-red-500"
                                                    data-info='{{ $dataInfo }}'
                                                    onclick="event.stopPropagation();">
                                            </div>
                                            
                                            {{-- CONTENIDO DEL BLOQUE --}}
                                            <div class="item-info text-[10px] leading-tight pr-6">
                                                <div class="font-bold mb-0.5 break-words" title="NV: {{ $item->nota_venta }}">
                                                    <i class="fas fa-file-alt mr-0.5"></i>{{ $item->nota_venta }}
                                                </div>
                                                <div class="mb-0.5 break-words" title="{{ $item->cliente }}">
                                                    <i class="fas fa-user mr-0.5"></i>{{ $item->cliente }}
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
                        <td class="data-block p-1 bg-red-50 hover:bg-red-100 transition-all align-top" 
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
                                        
                                        // ✅ Preparar datos para el atributo data-info
                                        $dataInfo = json_encode([
                                            'nota_venta' => $item->nota_venta,
                                            'instalador' => $item->instalador,
                                            'bloque' => $item->bloque,
                                            'fecha_instalacion2' => $item->fecha_instalacion2
                                        ]);
                                    @endphp
                                    
                                    {{-- ✅ WRAPPER CON CLASE PARA IDENTIFICAR Y EVITAR CONFLICTO --}}
                                    <div class="bloque-item-wrapper rounded p-1.5 border {{ $claseEstado }} shadow-sm hover:shadow-md transition-shadow mb-1 relative cursor-pointer"
                                         data-nota-venta="{{ $item->nota_venta }}"
                                         data-instalador="{{ $item->instalador }}"
                                         data-bloque="{{ $item->bloque }}"
                                         data-fecha="{{ $item->fecha_instalacion2 }}">
                                        
                                        {{-- ✅ CHECKBOX DE SELECCIÓN CON WRAPPER --}}
                                        <div class="checkbox-wrapper absolute top-1 right-1 z-20 p-1 bg-white rounded shadow-sm">
                                            <input 
                                                type="checkbox" 
                                                class="checkbox-item w-4 h-4 cursor-pointer accent-red-500"
                                                data-info='{{ $dataInfo }}'
                                                onclick="event.stopPropagation();">
                                        </div>
                                        
                                        {{-- CONTENIDO DEL BLOQUE --}}
                                        <div class="item-info text-[10px] leading-tight pr-6">
                                            <div class="font-bold mb-0.5 break-words" title="NV: {{ $item->nota_venta }}">
                                                <i class="fas fa-file-alt mr-0.5"></i>{{ $item->nota_venta }}
                                            </div>
                                            <div class="mb-0.5 break-words" title="{{ $item->cliente }}">
                                                <i class="fas fa-user mr-0.5"></i>{{ $item->cliente }}
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

{{-- ✅ SCRIPTS JAVASCRIPT --}}
<script>
(function() {
    'use strict';
    
    console.log('📅 Iniciando script de calendario con selección múltiple');
    
    let registrosSeleccionados = [];
    
    // ===== FUNCIONES DE SELECCIÓN =====
    function actualizarContador() {
        const cantidad = registrosSeleccionados.length;
        document.getElementById('contadorSeleccionados').textContent = cantidad;
        
        const barra = document.getElementById('barraHerramientas');
        if (cantidad > 0) {
            barra.style.display = 'block';
        } else {
            barra.style.display = 'none';
        }
    }
    
    function agregarRegistro(info) {
        const existe = registrosSeleccionados.some(r => 
            r.nota_venta === info.nota_venta && 
            r.instalador === info.instalador && 
            r.bloque === info.bloque &&
            r.fecha_instalacion2 === info.fecha_instalacion2
        );
        
        if (!existe) {
            registrosSeleccionados.push(info);
            console.log('✅ Registro agregado:', info);
        }
        actualizarContador();
    }
    
    function removerRegistro(info) {
        registrosSeleccionados = registrosSeleccionados.filter(r => 
            !(r.nota_venta === info.nota_venta && 
              r.instalador === info.instalador && 
              r.bloque === info.bloque &&
              r.fecha_instalacion2 === info.fecha_instalacion2)
        );
        console.log('❌ Registro removido:', info);
        actualizarContador();
    }
    
    // ===== EVENT LISTENERS =====
    function inicializarEventos() {
        // ✅ CHECKBOXES: Prevenir propagación y manejar selección
        document.querySelectorAll('.checkbox-item').forEach(checkbox => {
            checkbox.addEventListener('change', function(e) {
                e.stopPropagation();
                const info = JSON.parse(this.getAttribute('data-info'));
                
                if (this.checked) {
                    agregarRegistro(info);
                } else {
                    removerRegistro(info);
                }
            });
            
            // ✅ IMPORTANTE: Prevenir que el click en el checkbox dispare el modal
            checkbox.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
        
        // ✅ WRAPPER DEL CHECKBOX: También prevenir propagación
        document.querySelectorAll('.checkbox-wrapper').forEach(wrapper => {
            wrapper.addEventListener('click', function(e) {
                e.stopPropagation();
                // Toggle del checkbox cuando se hace click en el wrapper
                const checkbox = this.querySelector('.checkbox-item');
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            });
        });
        
        // Botón Seleccionar Todos
        document.getElementById('btnSeleccionarTodos').addEventListener('click', function() {
            document.querySelectorAll('.checkbox-item').forEach(checkbox => {
                if (!checkbox.checked) {
                    checkbox.checked = true;
                    const info = JSON.parse(checkbox.getAttribute('data-info'));
                    agregarRegistro(info);
                }
            });
        });
        
        // Botón Deseleccionar Todos
        document.getElementById('btnDeseleccionarTodos').addEventListener('click', function() {
            document.querySelectorAll('.checkbox-item').forEach(checkbox => {
                checkbox.checked = false;
            });
            registrosSeleccionados = [];
            actualizarContador();
        });
        
        // Botón Eliminar Seleccionados
        document.getElementById('btnEliminarSeleccionados').addEventListener('click', function() {
            if (registrosSeleccionados.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin selección',
                    text: 'No hay registros seleccionados para eliminar',
                    confirmButtonColor: '#3B82F6'
                });
                return;
            }
            
            confirmarEliminacion();
        });
    }
    
    // ===== FUNCIÓN DE CONFIRMACIÓN CON SWEETALERT =====
    window.confirmarEliminacion = function() {
        Swal.fire({
            title: '¿Eliminar bloques seleccionados?',
            html: `Está a punto de eliminar <strong>${registrosSeleccionados.length}</strong> bloque(s).<br><span style="color: #DC2626;">Esta acción no se puede deshacer.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#6B7280',
            confirmButtonText: '<i class="fas fa-trash-alt mr-2"></i>Sí, eliminar',
            cancelButtonText: '<i class="fas fa-times mr-2"></i>Cancelar',
            showLoaderOnConfirm: true,
            allowOutsideClick: () => !Swal.isLoading(),
            preConfirm: () => {
                console.log('🗑️ Enviando solicitud de eliminación:', registrosSeleccionados);
                
                return fetch('{{ route("eliminar-agenda-multiples") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        registros: registrosSeleccionados
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('✅ Respuesta del servidor:', data);
                    
                    if (!data.success) {
                        throw new Error(data.message || 'Error desconocido');
                    }
                    
                    return data;
                })
                .catch(error => {
                    console.error('❌ Error en la petición:', error);
                    Swal.showValidationMessage(`Error: ${error.message}`);
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const data = result.value;
                
                // Mostrar resultado con detalles
                let htmlContent = `<p class="text-lg mb-2">✅ Se eliminaron <strong>${data.eliminados}</strong> registro(s)</p>`;
                
                if (data.errores && data.errores.length > 0) {
                    htmlContent += `<p class="text-sm text-yellow-600 mt-2">⚠️ ${data.errores.length} advertencia(s)</p>`;
                }
                
                Swal.fire({
                    icon: 'success',
                    title: 'Eliminación completada',
                    html: htmlContent,
                    confirmButtonColor: '#10B981',
                    timer: 2000,
                    timerProgressBar: true
                }).then(() => {
                    // Recargar página
                    window.location.reload();
                });
            }
        });
    };
    
    // ===== INICIALIZACIÓN DEL SELECTOR DE FECHA =====
    function inicializarSelector() {
        var selector = document.getElementById('fechaInstalacion2') || 
                      document.querySelector('select[name="fecha_instalacion2"]') ||
                      document.querySelector('[id*="fecha"]');
        
        if (!selector) {
            console.error('❌ No se encontró el selector de fecha');
            return;
        }
        
        console.log('✅ Selector encontrado:', selector.id);
        
        var urlParams = new URLSearchParams(window.location.search);
        var fechaURL = urlParams.get('fecha');
        
        if (fechaURL) {
            var opciones = selector.options;
            for (var i = 0; i < opciones.length; i++) {
                var valorOpcion = opciones[i].value;
                if (valorOpcion.split(' ')[0] === fechaURL.split(' ')[0]) {
                    selector.selectedIndex = i;
                    console.log('✅ Selector actualizado a:', valorOpcion);
                    break;
                }
            }
        }
        
        selector.addEventListener('change', function() {
            var nuevaFecha = this.value;
            if (!nuevaFecha) return;
            
            var soloFecha = nuevaFecha.split(' ')[0];
            var url = new URL(window.location.href);
            url.searchParams.set('fecha', soloFecha);
            window.location.href = url.toString();
        });
    }
    
    // ===== INICIALIZACIÓN COMPLETA =====
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            inicializarSelector();
            inicializarEventos();
        });
    } else {
        inicializarSelector();
        inicializarEventos();
    }
})();
</script>