<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8' />
    <link href='https://unpkg.com/fullcalendar@5/main.min.css' rel='stylesheet' />
    <link href={{ asset('css/khemglobal.css') }} rel='stylesheet' />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://clientes.ohffice.cl/css/coreui.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
</head>
<body>

  <div class="container">
    <div class="side-content">
        <button id="prevDayButton" class="date-nav-button"><i class="fas fa-arrow-left"></i></button>

        <div class="info">FECHA DE INSTALACIÓN: <span id="todayDate">{{ $fechasInstalacion->first() }}</span></div>
        
        <button id="nextDayButton" class="date-nav-button"><i class="fas fa-arrow-right"></i></button>
      
    </div>
    <div class="main-title">AGENDA INSTALACIONES GLOBAL KHEMNOVA</div>
    <div class="side-content">
      <div class="info">Fecha: <span>{{ session('fecha', 'Fecha no disponible') }}</span></div>
      <div class="info">Usuario: <span>{{ session('usuario') ? session('usuario')->NOMBRE : 'Usuario no autenticado' }}</span></div>
      <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit">Cerrar Sesión</button>
      </form>
  </div>
  </div>

    


 
      <div class="section-container">
       
            <div class="comandos-container">
            
              <button class="comando-btn" onclick="window.location.href='{{ route('calendario4') }}';">
                <i class="fa fa-calendar-alt"></i>
                <span class="tooltip-text">Volver al calendario</span>
            </button>
           
            </div>

    
        </div>
      
      
      
  
        
      
      

        <div class="schedule-container">
          <div class="schedule-header">
              <div class="header-item">BLOQUE</div>
              <div class="header-item ">KHEMNOVA</div>
              <div class="header-item ">SANJOAQUIN</div>
              <div class="header-item ">STORETEK</div>
              <div class="header-item ">POR CONFIRMAR</div>




          </div>
          <div class="schedule-row">
            <div class="time-block">BLOQUE A-1 (08:00-10:00)</div>
            @php
                $instaladoresPorBloque = [];
                foreach ($agendaItems as $item) {
                    if ($item->bloque == 'A-1') {
                        $instaladoresPorBloque[$item->instalador][] = $item;
                    }
                }
            @endphp
            @foreach (['KHEMNOVA', 'SAN JOAQUIN', 'STORETEK'] as $index => $instalador)
                <div class="data-block"  id="bloque-a1-{{ $index + 1 }}">
                    @if (isset($instaladoresPorBloque[$instalador]))
                        @foreach ($instaladoresPorBloque[$instalador] as $item)
                            @php
                             $primerItem = $instaladoresPorBloque[$instalador][0];
                                $clasesEstado = [
                                'Calendarizado' => 'estado-calendarizado',
                                'En espera' => 'estado-en-espera',
                                'Post-Venta' => 'estado-post-venta'
                            ];

                             $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                            @endphp
                            
                            <div class="{{ $claseEstado }}" data-fecha-instalacion="{{ $item->calendarioDef->fecha_instalacion }}">
                                NV:{{ $item->nota_venta }}<br>
                                Cliente:{{ $item->calendarioDef->cliente }}<br>

                              </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
            <div class="data-block red-column" id="bloque-a1-confirmar">
                @if (isset($instaladoresPorBloque['POR CONFIRMAR']))
                    @php
                        $primerItemConfirmar = $instaladoresPorBloque['POR CONFIRMAR'][0];
                        $claseEstado = $primerItemConfirmar->estado == 'Calendarizado' ? 'estado-calendarizado' : 'estado-en-espera';
                    @endphp
                    <div class="{{ $claseEstado }}" data-fecha-instalacion="{{ $item->calendarioDef->fecha_instalacion }}">
                        @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
                            {{ $item->instalador }}<br>
                            {{ $item->nota_resumida ?? '-' }}<br>
                        @endforeach
                    </div>
                @endif
            </div>
           
        </div>
        
        <div class="schedule-row">
            <div class="time-block">BLOQUE A-2 (10:00-12:00)</div>
            @php
                $instaladoresPorBloque = [];
                foreach ($agendaItems as $item) {
                    if ($item->bloque == 'A-2') {
                        $instaladoresPorBloque[$item->instalador][] = $item;
                    }
                }
            @endphp
            @foreach (['KHEMNOVA', 'SAN JOAQUIN', 'STORETEK'] as $index => $instalador)

                <div class="data-block"  id="bloque-a2-{{ $index + 1 }}">
                    @if (isset($instaladoresPorBloque[$instalador]))
                        @foreach ($instaladoresPorBloque[$instalador] as $item)
                            @php
                             $primerItem = $instaladoresPorBloque[$instalador][0];
                                $clasesEstado = [
                                'Calendarizado' => 'estado-calendarizado',
                                'En espera' => 'estado-en-espera',
                                'Post-Venta' => 'estado-post-venta'
                            ];

                             $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                            @endphp
                            
                            <div class="{{ $claseEstado }}" data-fecha-instalacion="{{ $item->calendarioDef->fecha_instalacion }}">
                                NV:{{ $item->nota_venta }}<br>
                                Cliente:{{ $item->calendarioDef->cliente }}<br>

                              </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
            <div class="data-block red-column" id="bloque-a2-confirmar">
                @if (isset($instaladoresPorBloque['POR CONFIRMAR']))
                    @php
                        $primerItemConfirmar = $instaladoresPorBloque['POR CONFIRMAR'][0];
                        $claseEstado = $primerItemConfirmar->estado == 'Calendarizado' ? 'estado-calendarizado' : 'estado-en-espera';
                    @endphp
                    <div class="{{ $claseEstado }}">
                        @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
                            {{ $item->instalador }}<br>
                            {{ $item->nota_resumida ?? '-' }}<br>
                        @endforeach
                    </div>
                @endif
            </div>
          
        </div>
      <div class="schedule-row">
        <div class="time-block">BLOQUE A-3 (12:00-14:00)</div>
        @php
            $instaladoresPorBloque = [];
            foreach ($agendaItems as $item) {
                if ($item->bloque == 'A-3') {
                    $instaladoresPorBloque[$item->instalador][] = $item;
                }
            }
        @endphp
        @foreach (['KHEMNOVA', 'SAN JOAQUIN', 'STORETEK'] as $index => $instalador)

            <div class="data-block"  id="bloque-a3-{{ $index + 1 }}">
                @if (isset($instaladoresPorBloque[$instalador]))
                    @foreach ($instaladoresPorBloque[$instalador] as $item)
                        @php
                         $primerItem = $instaladoresPorBloque[$instalador][0];
                                $clasesEstado = [
                                'Calendarizado' => 'estado-calendarizado',
                                'En espera' => 'estado-en-espera',
                                'Post-Venta' => 'estado-post-venta'
                            ];

                             $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                        @endphp
                        
                        <div class="{{ $claseEstado }}" data-fecha-instalacion="{{ $item->calendarioDef->fecha_instalacion }}">
                            NV:{{ $item->nota_venta }}<br>
                            Cliente:{{ $item->calendarioDef->cliente }}<br>

                          </div>
                    @endforeach
                @endif
            </div>
        @endforeach
        <div class="data-block red-column" id="bloque-a3-confirmar">
            @if (isset($instaladoresPorBloque['POR CONFIRMAR']))
                @php
                    $primerItemConfirmar = $instaladoresPorBloque['POR CONFIRMAR'][0];
                    $claseEstado = $primerItemConfirmar->estado == 'Calendarizado' ? 'estado-calendarizado' : 'estado-en-espera';
                @endphp
                <div class="{{ $claseEstado }}">
                    @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
                        {{ $item->instalador }}<br>
                        {{ $item->nota_resumida ?? '-' }}<br>
                    @endforeach
                </div>
            @endif
        </div>
        
    </div>
              
    <div class="schedule-row">
        <div class="time-block">BLOQUE A-4 (14:00-16:00)</div>
        @php
            $instaladoresPorBloque = [];
            foreach ($agendaItems as $item) {
                if ($item->bloque == 'A-4') {
                    $instaladoresPorBloque[$item->instalador][] = $item;
                }
            }
        @endphp
        @foreach (['KHEMNOVA', 'SAN JOAQUIN', 'STORETEK'] as $index => $instalador)

            <div class="data-block"  id="bloque-a4-{{ $index + 1 }}">
                @if (isset($instaladoresPorBloque[$instalador]))
                    @foreach ($instaladoresPorBloque[$instalador] as $item)
                        @php
                         $primerItem = $instaladoresPorBloque[$instalador][0];
                                $clasesEstado = [
                                'Calendarizado' => 'estado-calendarizado',
                                'En espera' => 'estado-en-espera',
                                'Post-Venta' => 'estado-post-venta'
                            ];

                             $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                        @endphp
                        
                        <div class="{{ $claseEstado }}" data-fecha-instalacion="{{ $item->calendarioDef->fecha_instalacion }}">
                            NV:{{ $item->nota_venta }}<br>
                            Cliente:{{ $item->calendarioDef->cliente }}<br>

                          </div>
                    @endforeach
                @endif
            </div>
        @endforeach
        <div class="data-block red-column" id="bloque-a4-confirmar">
            @if (isset($instaladoresPorBloque['POR CONFIRMAR']))
                @php
                    $primerItemConfirmar = $instaladoresPorBloque['POR CONFIRMAR'][0];
                    $claseEstado = $primerItemConfirmar->estado == 'Calendarizado' ? 'estado-calendarizado' : 'estado-en-espera';
                @endphp
                <div class="{{ $claseEstado }}"  data-fecha-instalacion="{{ $item->calendarioDef->fecha_instalacion }}">
                    @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
                        {{ $item->instalador }}<br>
                        {{ $item->nota_resumida ?? '-' }}<br>
                    @endforeach
                </div>
            @endif
        </div>
      
    </div>
              
  <div class="schedule-row">
    <div class="time-block">BLOQUE A-5 (16:00-18:00)</div>
    @php
        $instaladoresPorBloque = [];
        foreach ($agendaItems as $item) {
            if ($item->bloque == 'A-5') {
                $instaladoresPorBloque[$item->instalador][] = $item;
            }
        }
    @endphp
     @foreach (['KHEMNOVA', 'SAN JOAQUIN', 'STORETEK'] as $index => $instalador)

        <div class="data-block"  id="bloque-a5-{{ $index + 1 }}">
            @if (isset($instaladoresPorBloque[$instalador]))
                @foreach ($instaladoresPorBloque[$instalador] as $item)
                    @php
                     $primerItem = $instaladoresPorBloque[$instalador][0];
                                $clasesEstado = [
                                'Calendarizado' => 'estado-calendarizado',
                                'En espera' => 'estado-en-espera',
                                'Post-Venta' => 'estado-post-venta'
                            ];

                             $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                    @endphp
                    
                    <div class="{{ $claseEstado }}" data-fecha-instalacion="{{ $item->calendarioDef->fecha_instalacion }}">
                        NV:{{ $item->nota_venta }}<br>
                        Cliente:{{ $item->calendarioDef->cliente }}<br>
                      </div>
                @endforeach
            @endif
        </div>
    @endforeach
    <div class="data-block red-column" id="bloque-a5-confirmar">
        @if (isset($instaladoresPorBloque['POR CONFIRMAR']))
            @php
                $primerItemConfirmar = $instaladoresPorBloque['POR CONFIRMAR'][0];
                $claseEstado = $primerItemConfirmar->estado == 'Calendarizado' ? 'estado-calendarizado' : 'estado-en-espera';
            @endphp
            <div class="{{ $claseEstado }}" data-fecha-instalacion="{{ $item->calendarioDef->fecha_instalacion }}">
                @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
                    {{ $item->instalador }}<br>
                    {{ $item->nota_resumida ?? '-' }}<br>
                @endforeach
            </div>
        @endif
    </div>
  
</div>
      
          <div class="schedule-row">
            <div class="time-block">BLOQUE A-6 (18:00-20:00)</div>
            @php
                $instaladoresPorBloque = [];
                foreach ($agendaItems as $item) {
                    if ($item->bloque == 'A-6') {
                        $instaladoresPorBloque[$item->instalador][] = $item;
                    }
                }
            @endphp
            @foreach (['KHEMNOVA', 'SAN JOAQUIN', 'STORETEK'] as $index => $instalador)

                <div class="data-block"  id="bloque-a6-{{ $index + 1 }}">
                    @if (isset($instaladoresPorBloque[$instalador]))
                        @foreach ($instaladoresPorBloque[$instalador] as $item)
                            @php
                             $primerItem = $instaladoresPorBloque[$instalador][0];
                                $clasesEstado = [
                                'Calendarizado' => 'estado-calendarizado',
                                'En espera' => 'estado-en-espera',
                                'Post-Venta' => 'estado-post-venta'
                            ];

                             $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                            @endphp
                            
                            <div class="{{ $claseEstado }}" data-fecha-instalacion="{{ $item->calendarioDef->fecha_instalacion }}">
                                NV:{{ $item->nota_venta }}<br>
                                Cliente:{{ $item->calendarioDef->cliente }}<br>

                              </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
            <div class="data-block red-column" id="bloque-a6-confirmar">
                @if (isset($instaladoresPorBloque['POR CONFIRMAR']))
                    @php
                        $primerItemConfirmar = $instaladoresPorBloque['POR CONFIRMAR'][0];
                        $claseEstado = $primerItemConfirmar->estado == 'Calendarizado' ? 'estado-calendarizado' : 'estado-en-espera';
                    @endphp
                    <div class="{{ $claseEstado }}" data-fecha-instalacion="{{ $item->calendarioDef->fecha_instalacion }}">
                        @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
                            {{ $item->instalador }}<br>
                            {{ $item->nota_resumida ?? '-' }}<br>
                        @endforeach
                    </div>
                @endif
            </div>
           
        </div>


    <div class="schedule-row">
        <div class="time-block">BLOQUE A-7 (20:00-22:00)</div>
        @php
            $instaladoresPorBloque = [];
            foreach ($agendaItems as $item) {
                if ($item->bloque == 'A-7') {
                    $instaladoresPorBloque[$item->instalador][] = $item;
                }
            }
        @endphp

@foreach (['KHEMNOVA', 'SAN JOAQUIN', 'STORETEK'] as $index => $instalador)

            <div class="data-block"  id="bloque-a7-{{ $index + 1 }}">
                @if (isset($instaladoresPorBloque[$instalador]))
                    @foreach ($instaladoresPorBloque[$instalador] as $item)
                        @php
                         $primerItem = $instaladoresPorBloque[$instalador][0];
                                $clasesEstado = [
                                'Calendarizado' => 'estado-calendarizado',
                                'En espera' => 'estado-en-espera',
                                'Post-Venta' => 'estado-post-venta'
                            ];

                             $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                        @endphp
                        
                        <div class="{{ $claseEstado }}" data-fecha-instalacion="{{ $item->calendarioDef->fecha_instalacion }}">
                            NV:{{ $item->nota_venta }}<br>
                            Cliente:{{ $item->calendarioDef->cliente }}<br>


                          </div>
                    @endforeach
                @endif
            </div>
        @endforeach
        <div class="data-block red-column" id="bloque-a7-confirmar">
            @if (isset($instaladoresPorBloque['POR CONFIRMAR']))
                @php
                    $primerItemConfirmar = $instaladoresPorBloque['POR CONFIRMAR'][0];
                    $claseEstado = $primerItemConfirmar->estado == 'Calendarizado' ? 'estado-calendarizado' : 'estado-en-espera';
                @endphp
                <div class="{{ $claseEstado }}" data-fecha-instalacion="{{ $item->calendarioDef->fecha_instalacion }}">
                    @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
                        {{ $item->instalador }}<br>
                        {{ $item->nota_resumida ?? '-' }}<br>
                    @endforeach
                </div>
            @endif
        </div>
       
    </div>
    
    
    <div class="schedule-row">
        <div class="time-block">BLOQUE A-8 (22:00-24:00)</div>
        @php
            $instaladoresPorBloque = [];
            foreach ($agendaItems as $item) {
                if ($item->bloque == 'A-8') {
                    $instaladoresPorBloque[$item->instalador][] = $item;
                }
            }
        @endphp
        @foreach (['KHEMNOVA', 'SAN JOAQUIN', 'STORETEK'] as $index => $instalador)

            <div class="data-block"  id="bloque-a8-{{ $index + 1 }}">
                @if (isset($instaladoresPorBloque[$instalador]))
                    @foreach ($instaladoresPorBloque[$instalador] as $item)
                        @php
                         $primerItem = $instaladoresPorBloque[$instalador][0];
                                $clasesEstado = [
                                'Calendarizado' => 'estado-calendarizado',
                                'En espera' => 'estado-en-espera',
                                'Post-Venta' => 'estado-post-venta'
                            ];

                             $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                        @endphp
                        
                        <div class="{{ $claseEstado }}" data-fecha-instalacion="{{ $item->calendarioDef->fecha_instalacion }}">
                            NV:{{ $item->nota_venta }}<br>
                            Cliente:{{ $item->calendarioDef->cliente }}<br>

                          </div>
                    @endforeach
                @endif
            </div>
        @endforeach
        <div class="data-block red-column" id="bloque-a8-confirmar">
            @if (isset($instaladoresPorBloque['POR CONFIRMAR']))
                @php
                    $primerItemConfirmar = $instaladoresPorBloque['POR CONFIRMAR'][0];
                    $claseEstado = $primerItemConfirmar->estado == 'Calendarizado' ? 'estado-calendarizado' : 'estado-en-espera';
                @endphp
                <div class="{{ $claseEstado }}" data-fecha-instalacion="{{ $item->calendarioDef->fecha_instalacion }}">
                    @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
                        {{ $item->instalador }}<br>
                        {{ $item->nota_resumida ?? '-' }}<br>
                    @endforeach
                </div>
            @endif
        </div>
        
    </div>
    
        </div>
      

        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', (event) => {
                let fechasInstalacion = @json($fechasInstalacion);
                console.log(fechasInstalacion);
                let indiceActual = 0;
            
                document.getElementById('nextDayButton').addEventListener('click', function() {
                    if (indiceActual < fechasInstalacion.length - 1) {
                        indiceActual++;
                        actualizarFecha();
                    }
                });
            
                document.getElementById('prevDayButton').addEventListener('click', function() {
                    if (indiceActual > 0) {
                        indiceActual--;
                        actualizarFecha();
                    }
                });
            
                function actualizarFecha() {
                    let fechaSeleccionada = fechasInstalacion[indiceActual];
                    document.getElementById('todayDate').innerText = fechaSeleccionada;
            
                    document.querySelectorAll('[data-fecha-instalacion]').forEach(function(notaVenta) {
                        if (notaVenta.getAttribute('data-fecha-instalacion') === fechaSeleccionada) {
                            notaVenta.style.display = ''; 
                        } else {
                            notaVenta.style.display = 'none'; 
                        }
                    });
                }
            
                actualizarFecha();
            });
            </script>

   
 
      
</body>
<script src="/js/calendarioglobal.js"></script>

</html>
