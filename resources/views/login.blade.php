<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Calendario Ohffice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/logo Oh_trans.png') }}">
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    
    <!-- Contenedor principal -->
    <div class="w-full max-w-md">
        
        <!-- Card de login -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            
            <!-- Header con logo -->
            <div class="p-8 pb-6 bg-gradient-to-r  to-cyan-50">
                <!-- Logo -->
                <div class="text-center mb-4">
                    <img src="https://clientes.ohffice.cl/storage/logo-ohffice-azul.jpeg" 
                         alt="Logo Ohffice"
                         class="mx-auto rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300" 
                         style="max-width: 160px;">
                </div>
                
                <!-- Título -->
                <div class="text-center">
                    <h1 class="text-2xl font-black text-gray-800 tracking-tight">
                        Calendario Ohffice
                    </h1>
                    <p class="text-sm text-gray-600 font-medium mt-1">
                        Sistema de Gestión de Instalaciones
                    </p>
                </div>
            </div>

            <!-- Formulario -->
            <div class="p-8">
                <form method="POST" action="/login" class="space-y-5">
                    @csrf
                    
                    <!-- Campo Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                            Correo Electrónico
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-blue-500"></i>
                            </div>
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                required 
                                autofocus 
                                placeholder="usuario@ohffice.cl"
                                class="w-full pl-10 pr-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-sm font-medium text-gray-800 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                            >
                        </div>
                    </div>

                    <!-- Campo Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                            Contraseña
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-blue-500"></i>
                            </div>
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                required 
                                placeholder="••••••••••"
                                class="w-full pl-10 pr-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-sm font-medium text-gray-800 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all"
                            >
                        </div>
                    </div>

                  

                    <button 
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-lg shadow-md hover:shadow-lg transform hover:scale-[1.01] transition-all duration-200 flex items-center justify-center gap-2"
                    >
                        <span>Iniciar Sesión</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>

            <div class="px-8 py-5 bg-gray-50 border-t border-gray-100">
                <div class="text-center">
                    <p class="text-xs text-gray-500 font-medium">
                        © 2025 Ohffice | Todos los derechos reservados
                    </p>
                </div>
            </div>
        </div>

    </div>

</body>
</html>