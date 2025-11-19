<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('imagenes/descarga.png') }}" type="image/png">

    <title>Calendario de Instalaciones</title>

    {{-- Tailwind CSS - PRIMERO --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Font Awesome --}}
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    
    {{-- Bootstrap (solo para la tabla que aún lo necesita) --}}
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- SweetAlert2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    {{-- CSS Personalizado --}}
    <link rel="stylesheet" href="{{ asset('css/requerimientos.css') }}">

    <style>
        /* Reset para evitar conflictos entre Bootstrap y Tailwind */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f9fafb;
        }
        
        /* Asegurar que Tailwind tenga prioridad */
        .container {
            max-width: 100% !important;
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
        
        @media (min-width: 640px) {
            .container {
                max-width: 640px !important;
            }
        }
        
        @media (min-width: 768px) {
            .container {
                max-width: 768px !important;
            }
        }
        
        @media (min-width: 1024px) {
            .container {
                max-width: 1024px !important;
            }
        }
        
        @media (min-width: 1280px) {
            .container {
                max-width: 1280px !important;
            }
        }
        
        @media (min-width: 1536px) {
            .container {
                max-width: 1536px !important;
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    @php
        use Carbon\Carbon;
    @endphp

    @include('components.listado1.header')
    
        <div class="w-full px-6"></div>
        @include('components.listado1.tabla')
    </div>

    {{-- Scripts al final del body --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/listado.js') }}"></script>
</body>

</html>