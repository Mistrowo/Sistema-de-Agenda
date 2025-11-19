
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="YvTnNtBVWcNwIxNywhEsV9D7d9Dt5Ix1VlJL2WFM">

    <title>Plataforma Instalaciones Ohffice</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://clientes.ohffice.cl/css/coreui.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">        
    </head>

<body class="header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page">
    <div class="c-app flex-row align-items-center">
        <div class="container">
            <style>
    .logo-welcome{
        width:400px;
    }

 
          </style>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mx-4">
             <div class="card-body p-4" style="text-align:center">
                <img src="https://clientes.ohffice.cl/storage/logo-ohffice-azul.jpeg" class="logo-welcome">
                <h5>Plataforma de Instalaciones</h5>
                <form method="POST" action="{{ url('/login') }}">
    @csrf 
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-user"></i></span>
        </div>
        <input id="EMAIL" name="EMAIL" type="text" class="form-control" required autocomplete="EMAIL" autofocus placeholder="Correo">
    </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>


<input id="CONTRASENA" name="CONTRASENA" type="password" class="form-control" required placeholder="Contraseña">


                                                    </div>

                        

                        <center>
                        <div class="row">
                            <div class="col-2">
                                <center>
                                <button type="submit" class="btn btn-primary px-4">
                                    Ingresar
                                </button>
                            </center>
                            </div>
                        
                          
                        </div>
                       
                    </form>
                 
                
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
    </body>

</html>


