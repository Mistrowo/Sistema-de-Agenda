<!-- Header PREMIUM - Mismo tamaño, mismo color, 1000% más elegante -->
<header class="bg-white shadow-sm sticky top-0 z-50">

    <!-- Barra Superior: Logo + Usuario + Acciones -->
    <div class="bg-gradient-to-r from-white-50/70 via-cyan-50/70 to-sky-50/70 border-b border-blue-100/80 backdrop-blur-sm">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14">

                <!-- Logo + Título -->
                <div class="flex items-center gap-3">
                  
                    <div>
                        <h1 class="text-lg font-black text-gray-800 tracking-tight">Calendario Instalaciones</h1>
                    </div>
                </div>

                <!-- Acciones Derecha -->
                <div class="flex items-center gap-3">

                    <!-- Info Usuario y Fecha (solo desktop) -->
                    <div class="hidden md:flex items-center gap-3 text-xs">
                        <div class="flex items-center gap-2 bg-white/80 backdrop-blur border border-blue-100 px-3 py-1.5 rounded-xl shadow-sm hover:shadow transition">
                            <i class="fas fa-calendar-day text-blue-500"></i>
                            <span class="font-semibold text-gray-700">{{ session('fecha', now()->format('d-m-Y')) }}</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/80 backdrop-blur border border-blue-100 px-3 py-1.5 rounded-xl shadow-sm hover:shadow transition">
                            <i class="fas fa-user-circle text-blue-500"></i>
                            <span class="font-semibold text-gray-700 truncate max-w-32">
                                {{ session('usuario') ? session('usuario')->NOMBRE : 'Usuario' }}
                            </span>
                        </div>
                    </div>

                    <!-- Botón Volver -->
                    <a href="{{ route('calendario') }}"
                       class="group flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-gray-100 to-gray-50 hover:from-gray-200 hover:to-gray-100 border border-gray-300 rounded-xl shadow-sm hover:shadow transition-all duration-200 font-medium text-gray-700 text-xs">
                        <i class="fas fa-arrow-left text-gray-600 group-hover:-translate-x-0.5 transition"></i>
                        <span class="hidden sm:inline">Volver</span>
                    </a>

                    <!-- Cerrar Sesión -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="group flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 font-medium text-xs">
                            <i class="fas fa-sign-out-alt group-hover:rotate-12 transition"></i>
                            <span class="hidden sm:inline">Cerrar Sesión</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros / Información de la NV -->
    <div class="bg-white border-b border-gray-100">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">

                <!-- Nota de Venta -->
                <div class="group relative bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-2xl p-4 border border-blue-200 hover:border-blue-400 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-file-invoice text-blue-600 text-sm"></i>
                        <span class="text-[10px] font-black text-blue-700 uppercase tracking-wider">Nota de Venta</span>
                    </div>
                    <p class="text-lg font-black text-gray-800 truncate">
                        {{ $calendarioDef->nota_venta ?? '—' }}
                    </p>
                </div>

                <!-- Cliente -->
                <div class="group relative bg-gradient-to-br from-emerald-50 to-emerald-100/50 rounded-2xl p-4 border border-emerald-200 hover:border-emerald-400 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-user text-emerald-600 text-sm"></i>
                        <span class="text-[10px] font-black text-emerald-700 uppercase tracking-wider">Cliente</span>
                    </div>
                    <p class="text-base font-bold text-gray-800 truncate">
                        {{ $calendarioDef->cliente ?? 'Sin cliente' }}
                    </p>
                </div>

                <!-- ✅ NUEVO: Zona -->
                <div class="group relative bg-gradient-to-br from-pink-50 to-pink-100/50 rounded-2xl p-4 border border-pink-200 hover:border-pink-400 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-map-marker-alt text-pink-600 text-sm"></i>
                        <span class="text-[10px] font-black text-pink-700 uppercase tracking-wider">Zona</span>
                    </div>
                    <div class="flex gap-1.5">
                        <input 
                            type="text" 
                            id="zonaInput"
                            placeholder="Zona..."
                            class="flex-1 min-w-0 bg-white/90 backdrop-blur border border-pink-300 rounded-lg px-2 py-1.5 text-xs font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-pink-200 focus:border-pink-500 transition-all placeholder:text-gray-400 placeholder:font-normal"
                        >
                        <button 
                            onclick="guardarZonaManual()"
                            id="btnGuardarZona"
                            class="flex-shrink-0 w-8 h-8 bg-pink-500 hover:bg-pink-600 text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow-md flex items-center justify-center"
                            title="Guardar zona">
                            <i class="fas fa-save text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="group relative bg-gradient-to-br from-purple-50 to-purple-100/50 rounded-2xl p-4 border border-purple-200 hover:border-purple-400 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-align-left text-purple-600 text-sm"></i>
                        <span class="text-[10px] font-black text-purple-700 uppercase tracking-wider">Descripción</span>
                    </div>
                    <p class="text-sm font-medium text-gray-700 line-clamp-2">
                        {{ $calendarioDef->descripcion ?? 'Sin descripción' }}
                    </p>
                </div>

                <!-- Fecha Entrega -->
                <div class="group relative bg-gradient-to-br from-orange-50 to-orange-100/50 rounded-2xl p-4 border border-orange-200 hover:border-orange-400 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-truck text-orange-600 text-sm"></i>
                        <span class="text-[10px] font-black text-orange-700 uppercase tracking-wider">Fecha Entrega</span>
                    </div>
                    <p class="text-base font-bold text-gray-800">
                        {{ $calendarioDef->fecha_fabril ? \Carbon\Carbon::parse($calendarioDef->fecha_fabril)->format('d/m/Y') : '—' }}
                    </p>
                </div>

                <!-- Fecha Instalación (Selector) -->
                <div class="group relative bg-gradient-to-br from-cyan-50 to-cyan-100/50 rounded-2xl p-4 border border-cyan-200 hover:border-cyan-400 hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-tools text-cyan-600 text-sm"></i>
                        <span class="text-[10px] font-black text-cyan-700 uppercase tracking-wider">Fecha Instalación</span>
                    </div>
                    <select id="fechaInstalacion2" onchange="mostrarInformacion(this.value)"
                            class="w-full bg-white/90 backdrop-blur border border-cyan-300 rounded-xl px-3 py-2 text-sm font-bold text-gray-800 focus:outline-none focus:ring-4 focus:ring-cyan-200 focus:border-cyan-500 cursor-pointer transition-all">
                        @foreach ($fechasInstalacion2 as $fecha)
                            <option value="{{ $fecha }}" {{ $loop->first ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>


    <!-- Inputs ocultos para JavaScript -->
    <input type="hidden" id="notaVentaNum" value="{{ $calendarioDef->nota_venta ?? '' }}">
    <input type="hidden" id="clienteNombre" value="{{ $calendarioDef->cliente ?? '' }}">
    <input type="hidden" id="descripcion" value="{{ $calendarioDef->descripcion ?? '' }}">
</header>

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const primeraFecha = document.getElementById('fechaInstalacion2').value;
        if (primeraFecha) mostrarInformacion(primeraFecha);
        
        // ✅ Cargar zona guardada al iniciar
        cargarZonaGuardada();
        
        // ✅ Cargar zona cuando cambie la fecha
        document.getElementById('fechaInstalacion2').addEventListener('change', function() {
            cargarZonaGuardada();
        });
        
        // ✅ Guardar con Enter en el input
        const zonaInput = document.getElementById('zonaInput');
        if (zonaInput) {
            zonaInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    guardarZonaManual();
                }
            });
        }
    });
    
    // ✅ Función para cargar zona guardada
    function cargarZonaGuardada() {
        const notaVenta = document.getElementById('notaVentaNum')?.value;
        const fechaInstalacion = document.getElementById('fechaInstalacion2')?.value;
        
        if (!notaVenta || !fechaInstalacion) return;
        
        fetch('/agenda-def/obtener-zona', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                nota_venta: notaVenta,
                fecha_instalacion2: fechaInstalacion
            })
        })
        .then(response => response.json())
        .then(data => {
            const zonaInput = document.getElementById('zonaInput');
            const btnGuardar = document.getElementById('btnGuardarZona');
            
            // ✅ Si hay bloques guardados, habilitar el campo
            if (data.existe_bloque) {
                zonaInput.disabled = false;
                btnGuardar.disabled = false;
                zonaInput.value = data.zona || '';
                zonaInput.classList.remove('opacity-50', 'cursor-not-allowed');
                btnGuardar.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                // ❌ Si NO hay bloques, deshabilitar el campo
                zonaInput.disabled = true;
                btnGuardar.disabled = true;
                zonaInput.value = '';
                zonaInput.placeholder = 'Primero guarde un bloque...';
                zonaInput.classList.add('opacity-50', 'cursor-not-allowed');
                btnGuardar.classList.add('opacity-50', 'cursor-not-allowed');
            }
        })
        .catch(error => console.error('Error al cargar zona:', error));
    }
    
    // ✅ Función para guardar zona manualmente
    function guardarZonaManual() {
        const notaVenta = document.getElementById('notaVentaNum')?.value;
        const fechaInstalacion = document.getElementById('fechaInstalacion2')?.value;
        const zona = document.getElementById('zonaInput')?.value;
        const btn = document.getElementById('btnGuardarZona');
        
        if (!notaVenta || !fechaInstalacion) {
            Swal.fire({
                icon: 'warning',
                title: 'Datos incompletos',
                text: 'No se puede guardar la zona',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }
        
        // Cambiar ícono a loading
        const iconoOriginal = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin text-sm"></i>';
        btn.disabled = true;
        
        fetch('/agenda-def/guardar-zona', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                nota_venta: notaVenta,
                fecha_instalacion2: fechaInstalacion,
                zona: zona
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cambiar a check temporalmente
                btn.innerHTML = '<i class="fas fa-check text-sm"></i>';
                btn.classList.remove('bg-pink-500', 'hover:bg-pink-600');
                btn.classList.add('bg-green-500');
                
                // Feedback visual en el input
                const zonaInput = document.getElementById('zonaInput');
                zonaInput.classList.add('ring-2', 'ring-green-400');
                
                // Volver al estado normal después de 1.5 segundos
                setTimeout(() => {
                    btn.innerHTML = iconoOriginal;
                    btn.classList.remove('bg-green-500');
                    btn.classList.add('bg-pink-500', 'hover:bg-pink-600');
                    btn.disabled = false;
                    zonaInput.classList.remove('ring-2', 'ring-green-400');
                }, 1500);
                
                console.log('✅ Zona guardada:', zona);
            }
        })
        .catch(error => {
            console.error('Error al guardar zona:', error);
            btn.innerHTML = iconoOriginal;
            btn.disabled = false;
            
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo guardar la zona',
                timer: 2000,
                showConfirmButton: false
            });
        });
    }
</script>