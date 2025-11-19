
@php
$usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
@endphp

<div class="schedule-container">
  <div class="schedule-header">
      <div class="header-item">BLOQUE</div>
      <div class="header-item" >{{$usuarioEnSesion}}</div>  
      <div class="header-item">ILESA</div>
      <div class="header-item">BODEGA</div>
    



  </div>
  <div class="schedule-row">
    <div class="time-block"> 08:00-10:00</div>
    @php
        $notaVenta = $calendarioDef1->nota_venta ?? '';
        $instaladoresPorBloque = [];
        foreach ($agendaItems1 as $item) {
            if ($item->bloque == 'A-1' && $item->nota_venta == $notaVenta) {
                $instaladoresPorBloque[$item->instalador][] = $item;
            }
        }
    @endphp
    @php
        $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
    @endphp
    @if (isset($instaladoresPorBloque[$usuarioEnSesion]))
        @php
            $primerItem = $instaladoresPorBloque[$usuarioEnSesion][0];
            $clasesEstado = [
                          'Calendarizado' => 'estado-calendarizado',
                          'En espera' => 'estado-en-espera',
                          'Post-Venta' => 'estado-post-venta'
                      ];

                       $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';


                    

        @endphp

       
      
       
    @endif


    @php
    $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
@endphp

<div class="data-block" id="bloque-a1-2">
    @if(isset($instaladoresPorBloque[$usuarioEnSesion]))
    @forelse ($instaladoresPorBloque[$usuarioEnSesion] as $item)
        @php
            $clasesEstado = [
                'Calendarizado' => 'estado-calendarizado',
                'En espera' => 'estado-en-espera',
                'Post-Venta' => 'estado-post-venta'
            ];
            $claseEstado = $clasesEstado[$item->estado] ?? 'alguna-clase-default';
        @endphp

        <div class="{{ $claseEstado }}">
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}<br>
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
        </div>
    @empty
        <div class="clase-estado-default"></div>
    @endforelse
@else
    <div class="clase-estado-default"></div>
@endif

</div>
  
    <div class="data-block" id="bloque-a1-3"></div>
    <div class="data-block" id="bloque-a1-4"></div> 



  
  </div>
        <div class="schedule-row">
          <div class="time-block"> 10:00-12:00</div>
          @php
              $notaVenta = $calendarioDef1->nota_venta ?? '';
              $instaladoresPorBloque = [];
              foreach ($agendaItems1 as $item) {
                  if ($item->bloque == 'A-2' && $item->nota_venta == $notaVenta) {
                      $instaladoresPorBloque[$item->instalador][] = $item;
                  }
              }
          @endphp
          @php
              $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
          @endphp
          @if (isset($instaladoresPorBloque[$usuarioEnSesion]))
              @php
                  $primerItem = $instaladoresPorBloque[$usuarioEnSesion][0];
            $clasesEstado = [
                          'Calendarizado' => 'estado-calendarizado',
                          'En espera' => 'estado-en-espera',
                          'Post-Venta' => 'estado-post-venta'
                      ];

                       $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

              @endphp


             
          @endif


          @php
          $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
      @endphp
      
      <div class="data-block" id="bloque-a2-2">
        @if(isset($instaladoresPorBloque[$usuarioEnSesion]))
        @forelse ($instaladoresPorBloque[$usuarioEnSesion] as $item)
            @php
                $clasesEstado = [
                    'Calendarizado' => 'estado-calendarizado',
                    'En espera' => 'estado-en-espera',
                    'Post-Venta' => 'estado-post-venta'
                ];
                $claseEstado = $clasesEstado[$item->estado] ?? 'alguna-clase-default';
            @endphp
    
            <div class="{{ $claseEstado }}">
                <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                    @if ($item->fecha_instalacion2)
                        NV:{{ $item->nota_venta }}<br>
                        Cliente:{{ $item->calendarioDef->cliente }}<br>
                        {{ $item->nota_resumida2 ?? '-' }}
                    @endif
                </div>
            </div>
        @empty
            <div class="clase-estado-default"></div>
        @endforelse
    @else
        <div class="clase-estado-default"></div>
    @endif
      </div>
        
          <div class="data-block" id="bloque-a2-3"></div> 
          <div class="data-block" id="bloque-a2-4"></div> 



        
        </div>
        
        <div class="schedule-row">
          <div class="time-block">12:00-14:00</div>
          @php
              $notaVenta = $calendarioDef1->nota_venta ?? '';
              $instaladoresPorBloque = [];
              foreach ($agendaItems1 as $item) {
                  if ($item->bloque == 'A-3' && $item->nota_venta == $notaVenta) {
                      $instaladoresPorBloque[$item->instalador][] = $item;
                  }
              }
          @endphp
          @php
              $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
          @endphp
          @if (isset($instaladoresPorBloque[$usuarioEnSesion]))
              @php
                  $primerItem = $instaladoresPorBloque[$usuarioEnSesion][0];
                  $clasesEstado = [
                          'Calendarizado' => 'estado-calendarizado',
                          'En espera' => 'estado-en-espera',
                          'Post-Venta' => 'estado-post-venta'
                      ];

                   $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

              @endphp



              
          @endif

          @php
$usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
@endphp

<div class="data-block" id="bloque-a3-2">
    @if(isset($instaladoresPorBloque[$usuarioEnSesion]))
    @forelse ($instaladoresPorBloque[$usuarioEnSesion] as $item)
        @php
            $clasesEstado = [
                'Calendarizado' => 'estado-calendarizado',
                'En espera' => 'estado-en-espera',
                'Post-Venta' => 'estado-post-venta'
            ];
            $claseEstado = $clasesEstado[$item->estado] ?? 'alguna-clase-default';
        @endphp

        <div class="{{ $claseEstado }}">
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}<br>
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
        </div>
    @empty
        <div class="clase-estado-default"></div>
    @endforelse
@else
    <div class="clase-estado-default"></div>
@endif
</div>
<div class="data-block" id="bloque-a3-3"></div> 
          <div class="data-block" id="bloque-a3-4"></div> 


        
        </div>
                
        <div class="schedule-row">
            <div class="time-block" >14:00-16:00</div>
            @php
                $notaVenta = $calendarioDef1->nota_venta ?? '';
                $instaladoresPorBloque = [];
                
                foreach ($agendaItems1 as $item) {
                    if ($item->bloque == 'A-4' && $item->nota_venta == $notaVenta) {
                        $instaladoresPorBloque[$item->instalador][] = $item;
                    }
                }
            @endphp
            @php
                $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
            @endphp
            @if (isset($instaladoresPorBloque[$usuarioEnSesion]))
                @php
                    $primerItem = $instaladoresPorBloque[$usuarioEnSesion][0];
                    $clasesEstado = [
                          'Calendarizado' => 'estado-calendarizado',
                          'En espera' => 'estado-en-espera',
                          'Post-Venta' => 'estado-post-venta'
                      ];

                       $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                @endphp


            @endif


            @php
            $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
        @endphp
        
        <div class="data-block" id="bloque-a4-2">
            @if(isset($instaladoresPorBloque[$usuarioEnSesion]))
            @forelse ($instaladoresPorBloque[$usuarioEnSesion] as $item)
                @php
                    $clasesEstado = [
                        'Calendarizado' => 'estado-calendarizado',
                        'En espera' => 'estado-en-espera',
                        'Post-Venta' => 'estado-post-venta'
                    ];
                    $claseEstado = $clasesEstado[$item->estado] ?? 'alguna-clase-default';
                @endphp
        
                <div class="{{ $claseEstado }}">
                    <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                        @if ($item->fecha_instalacion2)
                            NV:{{ $item->nota_venta }}<br>
                            Cliente:{{ $item->calendarioDef->cliente }}<br>
                            {{ $item->nota_resumida2 ?? '-' }}
                        @endif
                    </div>
                </div>
            @empty
                <div class="clase-estado-default"></div>
            @endforelse
        @else
            <div class="clase-estado-default"></div>
        @endif
        </div>

            
      
            <div class="data-block" id="bloque-a4-3"></div> 
            <div class="data-block" id="bloque-a4-4"></div> 



          
          </div>
                    
        <div class="schedule-row">
          <div class="time-block">16:00-18:00</div>
          @php
              $notaVenta = $calendarioDef1->nota_venta ?? '';
              $instaladoresPorBloque = [];
              foreach ($agendaItems1 as $item) {
                  if ($item->bloque == 'A-5' && $item->nota_venta == $notaVenta) {
                      $instaladoresPorBloque[$item->instalador][] = $item;
                  }
              }
          @endphp
          @php
              $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
          @endphp
          @if (isset($instaladoresPorBloque[$usuarioEnSesion]))
              @php
                  $primerItem = $instaladoresPorBloque[$usuarioEnSesion][0];
                  $clasesEstado = [
                          'Calendarizado' => 'estado-calendarizado',
                          'En espera' => 'estado-en-espera',
                          'Post-Venta' => 'estado-post-venta'
                      ];

                       $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

              @endphp

    
          @endif


          @php
          $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
      @endphp
      
      <div class="data-block" id="bloque-a5-2">
        @if(isset($instaladoresPorBloque[$usuarioEnSesion]))
        @forelse ($instaladoresPorBloque[$usuarioEnSesion] as $item)
            @php
                $clasesEstado = [
                    'Calendarizado' => 'estado-calendarizado',
                    'En espera' => 'estado-en-espera',
                    'Post-Venta' => 'estado-post-venta'
                ];
                $claseEstado = $clasesEstado[$item->estado] ?? 'alguna-clase-default';
            @endphp
    
            <div class="{{ $claseEstado }}">
                <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                    @if ($item->fecha_instalacion2)
                        NV:{{ $item->nota_venta }}<br>
                        Cliente:{{ $item->calendarioDef->cliente }}<br>
                        {{ $item->nota_resumida2 ?? '-' }}
                    @endif
                </div>
            </div>
        @empty
            <div class="clase-estado-default"></div>
        @endforelse
    @else
        <div class="clase-estado-default"></div>
    @endif
      </div>
         
          <div class="data-block" id="bloque-a5-3"></div> 
          <div class="data-block" id="bloque-a5-4"></div> 



        </div>
        
        <div class="schedule-row">

              <div class="time-block">18:00-20:00</div>
              @php
                  $notaVenta = $calendarioDef1->nota_venta ?? '';
                  $instaladoresPorBloque = [];
                  foreach ($agendaItems1 as $item) {
                      if ($item->bloque == 'A-6' && $item->nota_venta == $notaVenta) {
                          $instaladoresPorBloque[$item->instalador][] = $item;
                      }
                  }
              @endphp
              @php
                  $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
              @endphp
              @if (isset($instaladoresPorBloque[$usuarioEnSesion]))
                  @php
                      $primerItem = $instaladoresPorBloque[$usuarioEnSesion][0];
                      $clasesEstado = [
                          'Calendarizado' => 'estado-calendarizado',
                          'En espera' => 'estado-en-espera',
                          'Post-Venta' => 'estado-post-venta'
                      ];

                       $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                  @endphp

                
              @endif
              
              @php
              $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
          @endphp
          
          <div class="data-block" id="bloque-a6-2">
            @if(isset($instaladoresPorBloque[$usuarioEnSesion]))
            @forelse ($instaladoresPorBloque[$usuarioEnSesion] as $item)
                @php
                    $clasesEstado = [
                        'Calendarizado' => 'estado-calendarizado',
                        'En espera' => 'estado-en-espera',
                        'Post-Venta' => 'estado-post-venta'
                    ];
                    $claseEstado = $clasesEstado[$item->estado] ?? 'alguna-clase-default';
                @endphp
        
                <div class="{{ $claseEstado }}">
                    <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                        @if ($item->fecha_instalacion2)
                            NV:{{ $item->nota_venta }}<br>
                            Cliente:{{ $item->calendarioDef->cliente }}<br>
                            {{ $item->nota_resumida2 ?? '-' }}
                        @endif
                    </div>
                </div>
            @empty
                <div class="clase-estado-default"></div>
            @endforelse
        @else
            <div class="clase-estado-default"></div>
        @endif
          </div>
              <div class="data-block" id="bloque-a6-3"></div> 
              <div class="data-block" id="bloque-a6-4"></div> 



            
         </div>

        <div class="schedule-row">
            <div class="time-block">20:00-22:00</div>
            @php
                $notaVenta = $calendarioDef1->nota_venta ?? '';
                $instaladoresPorBloque = [];
                foreach ($agendaItems1 as $item) {
                    if ($item->bloque == 'A-7' && $item->nota_venta == $notaVenta) {
                        $instaladoresPorBloque[$item->instalador][] = $item;
                    }
                }
            @endphp
            @php
                $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
            @endphp
            @if (isset($instaladoresPorBloque[$usuarioEnSesion]))
                @php
                    $primerItem = $instaladoresPorBloque[$usuarioEnSesion][0];
                    $clasesEstado = [
                          'Calendarizado' => 'estado-calendarizado',
                          'En espera' => 'estado-en-espera',
                          'Post-Venta' => 'estado-post-venta'
                      ];

                       $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                @endphp



                
            @endif

            @php
            $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
        @endphp
        
        <div class="data-block" id="bloque-a7-2">
            @if(isset($instaladoresPorBloque[$usuarioEnSesion]))
            @forelse ($instaladoresPorBloque[$usuarioEnSesion] as $item)
                @php
                    $clasesEstado = [
                        'Calendarizado' => 'estado-calendarizado',
                        'En espera' => 'estado-en-espera',
                        'Post-Venta' => 'estado-post-venta'
                    ];
                    $claseEstado = $clasesEstado[$item->estado] ?? 'alguna-clase-default';
                @endphp
        
                <div class="{{ $claseEstado }}">
                    <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                        @if ($item->fecha_instalacion2)
                            NV:{{ $item->nota_venta }}<br>
                            Cliente:{{ $item->calendarioDef->cliente }}<br>
                            {{ $item->nota_resumida2 ?? '-' }}
                        @endif
                    </div>
                </div>
            @empty
                <div class="clase-estado-default"></div>
            @endforelse
        @else
            <div class="clase-estado-default"></div>
        @endif
        </div>
          
               
            <div class="data-block" id="bloque-a7-3"></div> 
            <div class="data-block" id="bloque-a7-4"></div> 



            


         </div>


      <div class="schedule-row">
          <div class="time-block">22:00-24:00</div>
          @php
              $notaVenta = $calendarioDef1->nota_venta ?? '';
              $instaladoresPorBloque = [];
              foreach ($agendaItems1 as $item) {
                  if ($item->bloque == 'A-8' && $item->nota_venta == $notaVenta) {
                      $instaladoresPorBloque[$item->instalador][] = $item;
                  }
              }
          @endphp
          @php
              $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
          @endphp
          @if (isset($instaladoresPorBloque[$usuarioEnSesion]))
              @php
                  $primerItem = $instaladoresPorBloque[$usuarioEnSesion][0];
                  $clasesEstado = [
                          'Calendarizado' => 'estado-calendarizado',
                          'En espera' => 'estado-en-espera',
                          'Post-Venta' => 'estado-post-venta'
                      ];

                       $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

              @endphp
             


           
       
          @endif

       
          @php
          $usuarioEnSesion = session('usuario') ? session('usuario')->NOMBRE : 'Invitado';
      @endphp
      
      <div class="data-block" id="bloque-a8-2">
        @if(isset($instaladoresPorBloque[$usuarioEnSesion]))
        @forelse ($instaladoresPorBloque[$usuarioEnSesion] as $item)
            @php
                $clasesEstado = [
                    'Calendarizado' => 'estado-calendarizado',
                    'En espera' => 'estado-en-espera',
                    'Post-Venta' => 'estado-post-venta'
                ];
                $claseEstado = $clasesEstado[$item->estado] ?? 'alguna-clase-default';
            @endphp
    
            <div class="{{ $claseEstado }}">
                <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                    @if ($item->fecha_instalacion2)
                        NV:{{ $item->nota_venta }}<br>
                        Cliente:{{ $item->calendarioDef->cliente }}<br>
                        {{ $item->nota_resumida2 ?? '-' }}
                    @endif
                </div>
            </div>
        @empty
            <div class="clase-estado-default"></div>
        @endforelse
    @else
        <div class="clase-estado-default"></div>
    @endif
      </div>
         
          <div class="data-block" id="bloque-a8-3"></div> 
          <div class="data-block" id="bloque-a8-4"></div> 


        </div>
      
</div>
