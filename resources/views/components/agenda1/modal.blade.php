<!-- Modal de Confirmación - Simple y Funcional -->
<div class="fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4 invisible" id="modalConfirmacionPersonalizado" style="visibility: hidden;">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md">
        
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-800">Confirmar Guardado</h3>
            <button onclick="cerrarModalConfirmacionPersonalizado()" 
                    class="text-gray-400 hover:text-gray-600 text-2xl leading-none">
                &times;
            </button>
        </div>
        
        <!-- Body -->
        <div class="px-6 py-6">
            <p class="text-gray-700 text-center">
                ¿Desea asignar fechas múltiples?
            </p>
        </div>
        
        <!-- Footer -->
        <div class="flex gap-3 px-6 py-4 bg-gray-50 rounded-b-xl">
            <button onclick="enviarFormularioPersonalizado()" 
                    class="flex-1 px-4 py-2.5 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors">
                No, guardar ahora
            </button>
            <button onclick="confirmacionYAbrirModalSeleccionDias()" 
                    class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                Sí, fechas múltiples
            </button>
        </div>
    </div>
</div>