{{-- Header Sticky con Tailwind --}}
<div class="bg-white shadow-md border-b border-gray-200 mb-6 sticky top-0 z-50">
    <div class="w-full px-6 py-4">
        
        {{-- Fila 1: Título y Usuario --}}
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg p-3 shadow-lg">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Calendario de Instalaciones</h1>
                    <p class="text-sm text-gray-500">Gestión de notas de venta</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="hidden md:block text-right">
                    <p class="text-sm text-gray-600 mb-1">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ session('fecha', now()->format('d/m/Y')) }}
                    </p>
                    <p class="text-sm text-gray-800 font-semibold">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ session('usuario') ? session('usuario')->NOMBRE : 'Usuario' }}
                    </p>
                </div>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="hidden sm:inline">Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>
        
        {{-- Fila 2: Filtros con Formulario --}}
        <form method="GET" action="{{ route('calendario') }}" class="flex flex-wrap gap-3 items-center">
            
            {{-- Búsqueda por Nota de Venta --}}
            <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 shadow-sm hover:shadow-md transition-shadow">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input 
                    type="text" 
                    name="nota_venta"
                    value="{{ request('nota_venta') }}"
                    class="bg-transparent border-0 focus:outline-none text-sm w-32 placeholder-gray-400" 
                    placeholder="Buscar NV..."
                >
                <button 
                    type="submit"
                    class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-md transition-all duration-200 shadow-sm hover:shadow">
                    Buscar
                </button>
            </div>
            
            {{-- Filtro por Fechas --}}
            <div class="flex flex-wrap items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 flex-grow shadow-sm hover:shadow-md transition-shadow">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                
                <select name="tipo_fecha" class="bg-white border border-gray-200 rounded px-3 py-1.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="emision" {{ request('tipo_fecha', 'emision') == 'emision' ? 'selected' : '' }}>F. Emisión</option>
                    <option value="entrega" {{ request('tipo_fecha') == 'entrega' ? 'selected' : '' }}>F. Entrega</option>
                </select>
                
                <span class="text-gray-300 hidden sm:inline">|</span>
                
                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-500 font-medium">Desde:</label>
                    <input 
                        type="date" 
                        name="fecha_desde"
                        value="{{ request('fecha_desde') }}"
                        class="bg-white border border-gray-200 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>
                
                <div class="flex items-center gap-2">
                    <label class="text-sm text-gray-500 font-medium">Hasta:</label>
                    <input 
                        type="date" 
                        name="fecha_hasta"
                        value="{{ request('fecha_hasta') }}"
                        class="bg-white border border-gray-200 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                </div>
                
                <button 
                    type="submit"
                    class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-md transition-all duration-200 shadow-sm hover:shadow flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Filtrar
                </button>
            </div>
            
            {{-- Botones de Acción --}}
            <div class="flex items-center gap-2 flex-shrink-0">
                {{-- Agenda Diaria --}}
                <a href="{{ route('calendariodia') }}" 
                   class="p-2.5 border border-blue-200 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition-all duration-200 group relative shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50">
                        Agenda Diaria
                    </span>
                </a>
                
                {{-- Agenda Semanal --}}
                <a href="{{ route('calendariosemana') }}" 
                   class="p-2.5 border border-purple-200 bg-purple-50 hover:bg-purple-100 text-purple-600 rounded-lg transition-all duration-200 group relative shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50">
                        Agenda Semanal
                    </span>
                </a>
                
             
                
                {{-- Limpiar Filtros --}}
                <a 
                    href="{{ route('calendario') }}"
                    class="p-2.5 border border-orange-200 bg-orange-50 hover:bg-orange-100 text-orange-600 rounded-lg transition-all duration-200 group relative shadow-sm hover:shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-white text-xs rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50">
                        Limpiar Filtros
                    </span>
                </a>
            </div>
        </form>
    </div>
</div>