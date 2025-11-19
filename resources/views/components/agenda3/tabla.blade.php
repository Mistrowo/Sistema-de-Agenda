


      

      <div class="schedule-container">
        <div class="schedule-header">
            <div class="header-item">BLOQUE</div>            
            <div class="header-item ">KHEMNOVA</div>
            <div class="header-item ">SAN JOAQUIN</div>
            <div class="header-item ">STORETEK</div>
            <div class="header-item ">POR CONFIRMAR</div>



        </div>
        <div class="schedule-row">
          <div class="time-block"> 08:00-10:00</div>
          @php
          $notaVenta = $calendarioDef->nota_venta ?? '';
          $instaladoresPorBloque = [];
          foreach ($agendaItems as $item) {
              if ($item->bloque == 'A-1' && $item->nota_venta == $notaVenta) {
                  $instaladoresPorBloque[$item->instalador][] = $item;
              }
          }
      @endphp
     @foreach (['KHEMNOVA','SAN JOAQUIN','STORETEK'] as $index => $instalador)
     <div class="data-block" id="bloque-a1-{{ $index + 1 }}">
         @if (isset($instaladoresPorBloque[$instalador]))
             @foreach ($instaladoresPorBloque[$instalador] as $item)
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
                             Cliente:{{ $item->calendarioDef->cliente }}
                             {{ $item->nota_resumida2 ?? '-' }}
                         @endif
                     </div>
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
        <div class="time-block"> 10:00-12:00</div>
         @php
          $notaVenta = $calendarioDef->nota_venta ?? '';
          $instaladoresPorBloque = [];
          foreach ($agendaItems as $item) {
              if ($item->bloque == 'A-2' && $item->nota_venta == $notaVenta) {
                  $instaladoresPorBloque[$item->instalador][] = $item;
              }
          }
      @endphp
     @foreach (['KHEMNOVA','SAN JOAQUIN','STORETEK'] as $index => $instalador)
     <div class="data-block" id="bloque-a2-{{ $index + 1 }}">
         @if (isset($instaladoresPorBloque[$instalador]))
             @foreach ($instaladoresPorBloque[$instalador] as $item)
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
                             Cliente:{{ $item->calendarioDef->cliente }}
                             {{ $item->nota_resumida2 ?? '-' }}
                         @endif
                     </div>
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
      <div class="time-block"> 12:00-14:00</div>
       @php
          $notaVenta = $calendarioDef->nota_venta ?? '';
          $instaladoresPorBloque = [];
          foreach ($agendaItems as $item) {
              if ($item->bloque == 'A-3' && $item->nota_venta == $notaVenta) {
                  $instaladoresPorBloque[$item->instalador][] = $item;
              }
          }
      @endphp
     @foreach (['KHEMNOVA','SAN JOAQUIN','STORETEK'] as $index => $instalador)
     <div class="data-block" id="bloque-a3-{{ $index + 1 }}">
         @if (isset($instaladoresPorBloque[$instalador]))
             @foreach ($instaladoresPorBloque[$instalador] as $item)
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
                             Cliente:{{ $item->calendarioDef->cliente }}
                             {{ $item->nota_resumida2 ?? '-' }}
                         @endif
                     </div>
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
    <div class="time-block"> 14:00-16:00</div>
     @php
          $notaVenta = $calendarioDef->nota_venta ?? '';
          $instaladoresPorBloque = [];
          foreach ($agendaItems as $item) {
              if ($item->bloque == 'A-4' && $item->nota_venta == $notaVenta) {
                  $instaladoresPorBloque[$item->instalador][] = $item;
              }
          }
      @endphp
     @foreach (['KHEMNOVA','SAN JOAQUIN','STORETEK'] as $index => $instalador)
     <div class="data-block" id="bloque-a4-{{ $index + 1 }}">
         @if (isset($instaladoresPorBloque[$instalador]))
             @foreach ($instaladoresPorBloque[$instalador] as $item)
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
                             Cliente:{{ $item->calendarioDef->cliente }}
                             {{ $item->nota_resumida2 ?? '-' }}
                         @endif
                     </div>
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
  <div class="time-block"> 16:00-18:00</div>
   @php
          $notaVenta = $calendarioDef->nota_venta ?? '';
          $instaladoresPorBloque = [];
          foreach ($agendaItems as $item) {
              if ($item->bloque == 'A-5' && $item->nota_venta == $notaVenta) {
                  $instaladoresPorBloque[$item->instalador][] = $item;
              }
          }
      @endphp
     @foreach (['KHEMNOVA','SAN JOAQUIN','STORETEK'] as $index => $instalador)
     <div class="data-block" id="bloque-a5-{{ $index + 1 }}">
         @if (isset($instaladoresPorBloque[$instalador]))
             @foreach ($instaladoresPorBloque[$instalador] as $item)
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
                             Cliente:{{ $item->calendarioDef->cliente }}
                             {{ $item->nota_resumida2 ?? '-' }}
                         @endif
                     </div>
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
<div class="time-block"> 18:00-20:00</div>
  @php
          $notaVenta = $calendarioDef->nota_venta ?? '';
          $instaladoresPorBloque = [];
          foreach ($agendaItems as $item) {
              if ($item->bloque == 'A-6' && $item->nota_venta == $notaVenta) {
                  $instaladoresPorBloque[$item->instalador][] = $item;
              }
          }
      @endphp
     @foreach (['KHEMNOVA','SAN JOAQUIN','STORETEK'] as $index => $instalador)
     <div class="data-block" id="bloque-a6-{{ $index + 1 }}">
         @if (isset($instaladoresPorBloque[$instalador]))
             @foreach ($instaladoresPorBloque[$instalador] as $item)
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
                             Cliente:{{ $item->calendarioDef->cliente }}
                             {{ $item->nota_resumida2 ?? '-' }}
                         @endif
                     </div>
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
<div class="time-block"> 20:00-22:00</div>
  @php
          $notaVenta = $calendarioDef->nota_venta ?? '';
          $instaladoresPorBloque = [];
          foreach ($agendaItems as $item) {
              if ($item->bloque == 'A-7' && $item->nota_venta == $notaVenta) {
                  $instaladoresPorBloque[$item->instalador][] = $item;
              }
          }
      @endphp
     @foreach (['KHEMNOVA','SAN JOAQUIN','STORETEK'] as $index => $instalador)
     <div class="data-block" id="bloque-a7-{{ $index + 1 }}">
         @if (isset($instaladoresPorBloque[$instalador]))
             @foreach ($instaladoresPorBloque[$instalador] as $item)
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
                             Cliente:{{ $item->calendarioDef->cliente }}
                             {{ $item->nota_resumida2 ?? '-' }}
                         @endif
                     </div>
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
<div class="time-block"> 22:00-24:00</div>
  @php
          $notaVenta = $calendarioDef->nota_venta ?? '';
          $instaladoresPorBloque = [];
          foreach ($agendaItems as $item) {
              if ($item->bloque == 'A-8' && $item->nota_venta == $notaVenta) {
                  $instaladoresPorBloque[$item->instalador][] = $item;
              }
          }
      @endphp
     @foreach (['KHEMNOVA','SAN JOAQUIN','STORETEK'] as $index => $instalador)
     <div class="data-block" id="bloque-a8-{{ $index + 1 }}">
         @if (isset($instaladoresPorBloque[$instalador]))
             @foreach ($instaladoresPorBloque[$instalador] as $item)
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
                             Cliente:{{ $item->calendarioDef->cliente }}
                             {{ $item->nota_resumida2 ?? '-' }}
                         @endif
                     </div>
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
























    

         
