<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agenda Instalaciones</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('imagenes/descarga.png') }}" type="image/png">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FullCalendar CSS -->
    <link href="https://unpkg.com/fullcalendar@5/main.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- jQuery (necesario para FullCalendar) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <!-- Bootstrap JS (solo para modales legacy) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Configuración de Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-montserrat">
    
    <!-- Header Profesional -->
    @include('components.agenda1.header')
    
    @include('components.agenda1.contenedor')
    
    @include('components.agenda1.modal-principal')
    @include('components.agenda1.modal')
     @include('components.agenda1.modal-calendario') 
     @include('components.agenda1.modalaux') 
     @include('components.agenda1.modalauxcalendario') 

    <script src="{{ asset('js/calendario.js') }}"></script>
</body>
</html>