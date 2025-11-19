    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='utf-8' />
        <link href='https://unpkg.com/fullcalendar@5/main.min.css' rel='stylesheet' />
        <link href={{ asset('css/calendario.css') }} rel='stylesheet' />
        <link rel="icon" href="{{ asset('imagenes/descarga.png') }}" type="image/png">


        
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <link href="https://clientes.ohffice.cl/css/coreui.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
               <script src="https://cdn.tailwindcss.com"></script>   
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


            <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

                    <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
    
   
                    
                    @include('components.agenda1.header2')
                    @include('components.agenda1.header')
                    @include('components.agenda1.contenedor')
                    @include('components.agenda1.modal-principal')
                    @include('components.agenda1.modal')
                    @include('components.agenda1.modal-calendario')
                    @include('components.agenda1.modalaux')
                    @include('components.agenda1.modalauxcalendario')

                

                   
                        
    </body>


    <script src="/js/calendario.js"></script>

    </html>
