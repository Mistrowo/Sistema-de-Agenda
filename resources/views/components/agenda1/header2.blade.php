<div class="bg-gradient-to-r from-blue-50 via-cyan-50 to-sky-50 border-b-2 border-blue-100 shadow-sm">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            
            <!-- Left Side - Logo/Icon (opcional) -->
            <div class="flex items-center gap-4">
                <!-- Puedes agregar un logo aquí si lo necesitas -->
            </div>
            
            <!-- Center - Title -->
            <div class="flex-1 flex justify-center">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-700 tracking-wide">AGENDA INSTALACIONES</h1>
            </div>
            
            <!-- Right Side - User Info -->
            <div class="flex items-center gap-4">
                <div class="hidden md:flex flex-col items-end gap-1">
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-calendar-day text-blue-400"></i>
                        <span class="font-medium">{{ session('fecha', 'Fecha no disponible') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-user text-blue-400"></i>
                        <span class="font-medium">{{ session('usuario') ? session('usuario')->NOMBRE : 'Usuario no autenticado' }}</span>
                    </div>
                </div>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="flex items-center gap-2 px-5 py-2.5 bg-white hover:bg-blue-50 border-2 border-blue-200 hover:border-blue-300 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md group">
                        <i class="fas fa-sign-out-alt text-blue-500 group-hover:text-blue-600 transition-colors"></i>
                        <span class="text-sm font-semibold text-gray-700 hidden sm:inline">Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Mobile Info (se muestra solo en móvil) -->
        <div class="md:hidden mt-3 pt-3 border-t border-blue-100 flex items-center justify-center gap-4 text-xs text-gray-600">
            <div class="flex items-center gap-1">
                <i class="fas fa-calendar-day text-blue-400"></i>
                <span>{{ session('fecha', 'Fecha no disponible') }}</span>
            </div>
            <div class="flex items-center gap-1">
                <i class="fas fa-user text-blue-400"></i>
                <span>{{ session('usuario') ? session('usuario')->NOMBRE : 'Usuario' }}</span>
            </div>
        </div>
    </div>
</div>