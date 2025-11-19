

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <link href={{ asset('css/calendario-semana.css') }} rel='stylesheet' />
    <link rel="icon" href="{{ asset('imagenes/descarga.png') }}" type="image/png">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://clientes.ohffice.cl/css/coreui.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</head>
<body>




    <div class="container">
        <div class="main-title">
          Calendario Instalaciones Semanal
          <div class="date-and-button">
            <button id="prev-week-button" class="week-button1">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div id="week-dates" class="week-dates"></div>
            <button id="next-week-button" class="week-button">
                <i class="fas fa-arrow-right"></i>
            </button>



            <a href="{{ route('calendario') }}" class="back-button" title="Volver">
                <i class="fas fa-home"></i>
                <span class="tooltip-text">Volver al Inicio</span>
            </a>
            
            <a href="{{ route('calendariodia') }}">
                <button id="day-button" class="day-button"> Por Día</button>
            </a>
        </div>
        
        
        
        </div>
      </div>
      
      
        


       



  
        
      

        <div class="schedule-container">
            <div class="schedule-header">
                <div class="header-item">BLOQUE</div>
                @foreach ($weekDates as $index => $date)
                    @php
                        $dayName = explode(', ', $date)[0]; 
                    @endphp
                    <div class="header-item" data-fecha="{{ $date }}">{{ strtoupper($dayName) }}</div>
                @endforeach
            </div>
            
            
            
            <div class="schedule-row">
                <div class="time-block"> 08:00-10:00</div>
                @for ($i = 1; $i <= 6; $i++)
                <div class="data-block" id="bloque-A1-dia-{{ $i }}">
                </div>
                @endfor
            </div>
            
        
      
            <div class="schedule-row">
                <div class="time-block"> 10:00-12:00</div>
                @for ($i = 1; $i <= 6; $i++)
                <div class="data-block" id="bloque-A2-dia-{{ $i }}">

                    </div>
                @endfor
            </div>
            
            <div class="schedule-row">
                <div class="time-block"> 12:00-14:00</div>
                @for ($i = 1; $i <= 6; $i++)
                <div class="data-block" id="bloque-A3-dia-{{ $i }}">

                    </div>
                @endfor
            </div>
            
            <div class="schedule-row">
                <div class="time-block"> 14:00-16:00</div>
                @for ($i = 1; $i <= 6; $i++)
                <div class="data-block" id="bloque-A4-dia-{{ $i }}">

                    </div>
                @endfor
            </div>
            
            <div class="schedule-row">
                <div class="time-block"> 16:00-18:00</div>
                @for ($i = 1; $i <= 6; $i++)
                <div class="data-block" id="bloque-A5-dia-{{ $i }}">

                    </div>
                @endfor
            </div>
            
            <div class="schedule-row">
                <div class="time-block"> 18:00-20:00</div>
                @for ($i = 1; $i <= 6; $i++)
                <div class="data-block" id="bloque-A6-dia-{{ $i }}">

                    </div>
                @endfor
            </div>
            
            <div class="schedule-row">
                <div class="time-block"> 20:00-22:00</div>
                @for ($i = 1; $i <= 6; $i++)
                <div class="data-block" id="bloque-A7-dia-{{ $i }}">

                    </div>
                @endfor
            </div>
            
            <div class="schedule-row">
                <div class="time-block"> 22:00-24:00</div>
                @for ($i = 1; $i <= 6; $i++)
                <div class="data-block" id="bloque-A8-dia-{{ $i }}">

                    </div>
                @endfor
            </div>
            
        </div>
      



      




<div class="modal fade" id="notasVentaModal" tabindex="-1" aria-labelledby="notasVentaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notasVentaModalLabel">Notas de ventas asociadas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nota de Venta</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Fecha Instalación</th>
                            <th scope="col">Instalador</th>
                            <th scope="col">Bloque</th>
                            <th scope="col">Estado</th>
                            <th scope="col"> </th>




                        </tr>
                    </thead>
                    <tbody id="modalContent">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



        <script>
            var instaladoresPorFecha = @json($instaladoresPorFecha);
        </script>
        

 <script src="/js/calendario-semana.js"></script>
 
</body>
</html>



