<!-- Modal Principal - Lectura Agenda Instalaciones -->
<div class="modal fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center overflow-y-auto p-4" id="miModal" style="display: none;">
<div class="w-full max-w-6xl">       
        <!-- Contenedor del Modal -->
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl max-h-[90vh] overflow-hidden">
        
            <!-- Header del Modal -->
            <div class="bg-gradient-to-r from-blue-800 to-white-700 text-white px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 rounded-lg p-2">
                            <i class="fas fa-clipboard-list text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">Agenda de Instalaciones</h2>
                            <p class="text-sm text-slate-300">{{ \Carbon\Carbon::now()->format('d-m-Y') }} • {{ session('usuario') ? session('usuario')->NOMBRE : 'Usuario' }}</p>
                        </div>
                    </div>
                    
                    <!-- Botón Cerrar -->
                    <button onclick="cerrarModal()" 
                            class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg w-10 h-10 flex items-center justify-center transition-all text-2xl">
                        ×
                    </button>
                </div>
            </div>

            <!-- Barra de Acciones -->
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-3">
                <form id="miFormulario" method="POST" action="{{ route('agenda_def.store') }}">
                    @csrf
                    <div class="flex flex-wrap items-center gap-2">
                        
                        <!-- Botón Guardar -->
                        <button type="button" id="guardarBtn" 
                                class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-all shadow-sm hover:shadow-md font-medium text-sm">
                            <i class="fa fa-save" id="iconoGuardar"></i>
                            <span>Guardar</span>
                        </button>

                       

                        <!-- Botón Eliminar -->
                        <button type="button" id="botonEliminar"
                                class="flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-all shadow-sm hover:shadow-md font-medium text-sm">
                            <i class="fas fa-trash"></i>
                            <span>Eliminar</span>
                        </button>

                        <!-- Botón Múltiple -->
                        <button type="button" id="botonmultiple"
                                class="flex items-center gap-2 px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-lg transition-all shadow-sm hover:shadow-md font-medium text-sm">
                            <i class="fa fa-tasks"></i>
                            <span>Asignación Múltiple</span>
                        </button>

                        <div id="selectedDates"></div>
                    </div>
                </form>
            </div>

            <!-- Contenido del Modal -->
            <div class="p-6 space-y-5 overflow-y-auto max-h-[calc(90vh-180px)]">
                
                <!-- Sección 1: Información Principal -->
                <div class="bg-white border border-slate-200 rounded-xl p-4">
                    <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                        <div class="w-1 h-5 bg-slate-700 rounded-full"></div>
                        Información General
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        
                        <!-- Hora/Bloque -->
                        <div>
                            <label for="horaBloque" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                Hora/Bloque
                            </label>
                            <select name="bloque" id="horaBloque"
                                    class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all outline-none text-sm">
                                <option value="" selected></option>
                            </select>
                            <input type="hidden" id="bloqueAntiguo" name="bloque_antiguo">
                        </div>

                     

                        <!-- Nota Venta -->
                        <div>
                            <label for="notaVenta" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                Nota de Venta
                            </label>
                            <input type="text" id="notaVenta" name="nota_venta" placeholder="N°"
                                   class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all outline-none text-sm">
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="descripcionModal" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                Descripción
                            </label>
                            <input type="text" id="descripcionModal"
                                   class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all outline-none text-sm">
                        </div>
                    </div>
                </div>

                <!-- Sección 2: Instalador y Fechas -->
                <div class="bg-white border border-slate-200 rounded-xl p-4">
                    <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                        <div class="w-1 h-5 bg-slate-700 rounded-full"></div>
                        Instalador y Fechas
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        
                        <!-- Instalador -->
                        <div>
                            <label for="instalador" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                Instalador
                            </label>
                            <select name="instalador" id="instalador"
                                    class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all outline-none text-sm">
                                <option value="" selected></option>
                            </select>
                            <input type="hidden" id="instaladorAntiguo" name="instalador_antiguo">
                        </div>

                        <!-- Fecha Instalación -->
                        <div>
                            <label for="fechaInstalacionModal" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                Fecha Instalación
                            </label>
                            <input type="date" id="fechaInstalacionModal"
                                   class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all outline-none text-sm">
                        </div>

                        <!-- Fecha Entrega -->
                        <div>
                            <label for="fechaEntregaModal" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                Fecha Entrega
                            </label>
                            <input type="text" name="fecha_entrega" id="fechaEntregaModal" 
                                   value="{{ $calendarioDef->fecha_fabril ?? 'No definido' }}"
                                   class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all outline-none text-sm">
                        </div>

                        <!-- Cliente -->
                        <div>
                            <label for="cliente" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                Cliente
                            </label>
                            <input type="text" name="cliente" id="cliente"
                                   class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all outline-none text-sm">
                        </div>
                    </div>
                </div>

                <!-- Sección 3: Notas -->
                <div class="bg-white border border-slate-200 rounded-xl p-4">
                    <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                        <div class="w-1 h-5 bg-slate-700 rounded-full"></div>
                        Notas y Observaciones
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <!-- Nota Resumida Visible -->
                        <div>
                            <label for="observaciones3" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                Nota Resumida (Visible en Agenda)
                            </label>
                            <textarea id="observaciones3" name="nota_resumida2" maxlength="60" rows="2"
                                      class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all outline-none text-sm resize-none"
                                      placeholder="Máximo 60 caracteres"></textarea>
                        </div>

                        <!-- Nota Resumida -->
                        <div>
                            <label for="observaciones2" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                Nota Resumida Completa
                            </label>
                            <textarea id="observaciones2" name="nota_resumida" rows="2"
                                      class="w-full px-3 py-2.5 bg-white border border-slate-300 rounded-lg focus:border-slate-500 focus:ring-2 focus:ring-slate-200 transition-all outline-none text-sm resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Sección 4: Estado de la Instalación -->
                <div class="bg-white border border-slate-200 rounded-xl p-4">
                    <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                        <div class="w-1 h-5 bg-slate-700 rounded-full"></div>
                        Estado de la Instalación
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        
                        <!-- Despacho Confirmado -->
                        <label class="flex items-center gap-3 px-4 py-3 bg-blue-50 border-2 border-blue-200 rounded-lg hover:bg-blue-100 cursor-pointer transition-all min-w-[160px]">
                            <input type="checkbox" class="status-checkbox w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500" 
                                   id="confirmedCheckbox" name="estado" value="Calendarizado">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                <span class="text-sm font-medium text-slate-700">Confirmado</span>
                            </div>
                        </label>

                        <!-- Post Venta -->
                        <label class="flex items-center gap-3 px-4 py-3 bg-emerald-50 border-2 border-emerald-200 rounded-lg hover:bg-emerald-100 cursor-pointer transition-all min-w-[160px]">
                            <input type="checkbox" class="status-checkbox w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" 
                                   id="postSaleCheckbox" name="estado" value="Post-Venta">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                <span class="text-sm font-medium text-slate-700">Post Venta</span>
                            </div>
                        </label>

                        <!-- Por Confirmar -->
                        <label class="flex items-center gap-3 px-4 py-3 bg-red-50 border-2 border-red-200 rounded-lg hover:bg-red-100 cursor-pointer transition-all min-w-[160px]">
                            <input type="checkbox" class="status-checkbox w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-red-500" 
                                   id="pendingCheckbox" name="estado" value="En espera">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <span class="text-sm font-medium text-slate-700">Por Confirmar</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Sección 5: Asignación Múltiple -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                            <div class="w-1 h-5 bg-slate-700 rounded-full"></div>
                            Asignación Múltiple
                        </h3>
                        <div class="flex items-center gap-3 bg-white px-3 py-2 rounded-lg border border-slate-200">
                            <span class="text-xs font-semibold text-slate-600">Activar:</span>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="asignacion_multiple" value="si" id="asignacion_si"
                                       class="w-4 h-4 text-slate-600 focus:ring-slate-500">
                                <span class="text-sm font-medium text-slate-700">Sí</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="asignacion_multiple" value="no" id="asignacion_no"
                                       class="w-4 h-4 text-slate-600 focus:ring-slate-500">
                                <span class="text-sm font-medium text-slate-700">No</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        
                        <!-- Bloques -->
                        <div class="bg-white rounded-lg p-4 border border-slate-200">
                            <h4 class="text-xs font-bold text-slate-600 mb-3 uppercase tracking-wide">Bloques Horarios</h4>
                            <div class="grid grid-cols-2 gap-2 bloques-container">
                                @foreach([
                                    ['id' => 'A-1', 'label' => 'A-1 (08-10)', 'value' => 'BLOQUE A-1 (8:00-10:00)'],
                                    ['id' => 'A-2', 'label' => 'A-2 (10-12)', 'value' => 'BLOQUE A-2 (10:00-12:00)'],
                                    ['id' => 'A-3', 'label' => 'A-3 (12-14)', 'value' => 'BLOQUE A-3 (12:00-14:00)'],
                                    ['id' => 'A-4', 'label' => 'A-4 (14-16)', 'value' => 'BLOQUE A-4 (14:00-16:00)'],
                                    ['id' => 'A-5', 'label' => 'A-5 (16-18)', 'value' => 'BLOQUE A-5 (16:00-18:00)'],
                                    ['id' => 'A-6', 'label' => 'A-6 (18-20)', 'value' => 'BLOQUE A-6 (18:00-20:00)'],
                                    ['id' => 'A-7', 'label' => 'A-7 (20-22)', 'value' => 'BLOQUE A-7 (20:00-22:00)'],
                                    ['id' => 'A-8', 'label' => 'A-8 (22-24)', 'value' => 'BLOQUE A-8 (22:00-24:00)']
                                ] as $bloque)
                                <label class="flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg hover:bg-slate-100 hover:border-slate-300 cursor-pointer transition-all">
                                    <input type="checkbox" name="bloque" value="{{ $bloque['value'] }}" data-id="{{ $bloque['id'] }}"
                                           class="w-3.5 h-3.5 rounded border-slate-300 text-slate-600">
                                    <span class="text-xs font-medium text-slate-700">{{ $bloque['label'] }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Instaladores -->
                        <div class="bg-white rounded-lg p-4 border border-slate-200">
                            <h4 class="text-xs font-bold text-slate-600 mb-3 uppercase tracking-wide">Instaladores</h4>
                            <div class="grid grid-cols-2 gap-2 instaladores-container">
                                @foreach(['DIEGO', 'FRANCO', 'GABRIEL', 'JONATHAN', 'ILESA', 'BODEGA', 'VOLANTE'] as $instalador)
                                <label class="flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg hover:bg-slate-100 hover:border-slate-300 cursor-pointer transition-all">
                                    <input type="checkbox" name="instalador" value="{{ $instalador }}"
                                           class="w-3.5 h-3.5 rounded border-slate-300 text-slate-600">
                                    <span class="text-xs font-medium text-slate-700">{{ $instalador }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Campo hidden para observaciones (mantener compatibilidad) -->
                <textarea id="observaciones1" name="observacion_bloque" class="hidden">{{ $observacion ?? 'No definido' }}</textarea>

            </div>
        </div>
    </div>
</div>