<!-- Modal Selección de Días 1 - MODERNO -->
<div class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden items-center justify-center p-4" id="modalSeleccionDias1">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-cyan-100 to-blue-100 px-6 py-4 border-b border-blue-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-white rounded-lg p-2">
                        <i class="fas fa-calendar-alt text-blue-500 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800">Seleccione los días a asignar</h2>
                </div>
                <button onclick="cerrarModalSeleccionDias1()" 
                        class="text-gray-600 hover:text-gray-800 hover:bg-white hover:bg-opacity-50 rounded-lg w-8 h-8 flex items-center justify-center transition-all">
                    <span class="text-2xl leading-none">&times;</span>
                </button>
            </div>
        </div>
        
        <!-- Controles de Navegación del Mes -->
        <div class="bg-slate-50 border-b border-slate-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <button onclick="cambiarMes1(-1)" 
                        class="w-10 h-10 flex items-center justify-center bg-white hover:bg-gray-100 border border-gray-300 rounded-lg transition-colors shadow-sm">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                
                <span id="mesAnio1" class="text-lg font-bold text-gray-800 capitalize"></span>
                
                <button onclick="cambiarMes1(1)" 
                        class="w-10 h-10 flex items-center justify-center bg-white hover:bg-gray-100 border border-gray-300 rounded-lg transition-colors shadow-sm">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>
            </div>
        </div>
        
        <!-- Calendario -->
        <div class="p-6 overflow-y-auto max-h-[50vh]" id="calendarioContainer1">
            <!-- El calendario se genera dinámicamente con JavaScript -->
        </div>
        
        <!-- Fechas Seleccionadas -->
        <div class="px-6 pb-4">
            <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">
                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                Fechas Seleccionadas
            </label>
            <input type="text" 
                   id="fechasSeleccionadas1" 
                   readonly
                   placeholder="Haga clic en los días del calendario..."
                   class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-lg text-sm text-gray-700 font-medium focus:outline-none focus:ring-2 focus:ring-blue-200">
        </div>
        
        <!-- Footer -->
        <div class="bg-slate-50 border-t border-slate-200 px-6 py-4 flex items-center justify-end gap-3 rounded-b-2xl">
            <button onclick="cerrarModalSeleccionDias1()" 
                    class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-colors">
                Cancelar
            </button>
            <button onclick="guardarCambios1()" 
                    class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-medium transition-all shadow-lg hover:shadow-xl">
                <i class="fas fa-save mr-2"></i>
                Guardar Cambios
            </button>
        </div>
    </div>
</div>


<style>
/* Estilos para ambos calendarios generados dinámicamente */
#calendario, #calendario1 {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 8px;
    margin-top: 12px;
}

#calendario .dia, #calendario1 .dia {
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    color: #475569;
    transition: all 0.2s;
    user-select: none;
}

#calendario .dia:hover, #calendario1 .dia:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

#calendario .dia.seleccionado, #calendario1 .dia.seleccionado {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border-color: #2563eb;
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

#calendario .dia.seleccionado:hover, #calendario1 .dia.seleccionado:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    transform: translateY(-2px);
}
</style>