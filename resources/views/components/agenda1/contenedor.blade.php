<div class="schedule-container">
    <div class="schedule-header">
        <div class="header-item">BLOQUE</div>
        <div class="header-item" >DIEGO</div>
        <div class="header-item">FRANCO</div>
        <div class="header-item">GABRIEL</div>
        <div class="header-item">JONATHAN</div>
        <div class="header-item">VOLANTE</div>
        <div class="header-item">ILESA</div>
        <div class="header-item">BODEGA</div>
        <div class="header-item ">POR CONFIRMAR</div>
        <div class="header-item ">KHEMNOVA</div>
        <div class="header-item ">SAN JOAQUIN</div>
        <div class="header-item ">STORETEK</div>



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
       @foreach (['DIEGO', 'FRANCO', 'GABRIEL', 'JONATHAN', 'VOLANTE', 'ILESA', 'BODEGA'] as $index => $instalador)
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
            $primerItem = $instaladoresPorBloque['POR CONFIRMAR'][0];
                    $clasesEstado = [
                    'Calendarizado' => 'estado-calendarizado',
                    'En espera' => 'estado-en-espera',
                    'Post-Venta' => 'estado-post-venta'
                ];

                    $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

             @endphp
                <div class="{{ $claseEstado }}">
                    @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
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
        <div class="data-block data-block-bloqueado" id="bloque-a1-9">
            @if (isset($instaladoresPorBloque['KHEMNOVA']))
            @php
                $primerItem = $instaladoresPorBloque['KHEMNOVA'][0];
                $clasesEstado = [
                'Calendarizado' => 'estado-calendarizado',
                'En espera' => 'estado-en-espera',
                'Post-Venta' => 'estado-post-venta'
            ];

        $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

            @endphp
            <div class="{{ $claseEstado }}">
                @foreach ($instaladoresPorBloque['KHEMNOVA'] as $item)
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
        <div class="data-block data-block-bloqueado" id="bloque-a1-10">
            @if (isset($instaladoresPorBloque['SAN JOAQUIN']))
            @php
            $primerItem = $instaladoresPorBloque['SAN JOAQUIN'][0];
            $clasesEstado = [
            'Calendarizado' => 'estado-calendarizado',
            'En espera' => 'estado-en-espera',
            'Post-Venta' => 'estado-post-venta'
        ];

        $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

            @endphp
            <div class="{{ $claseEstado }}">
                @foreach ($instaladoresPorBloque['SAN JOAQUIN'] as $item)
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





        
        <div class="data-block data-block-bloqueado" id="bloque-a1-11">
            @if (isset($instaladoresPorBloque['STORETEK']))
            @php
                $primerItem = $instaladoresPorBloque['STORETEK'][0];
                    $clasesEstado = [
                    'Calendarizado' => 'estado-calendarizado',
                    'En espera' => 'estado-en-espera',
                    'Post-Venta' => 'estado-post-venta'
                ];

            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

            @endphp
            <div class="{{ $claseEstado }}">
                @foreach ($instaladoresPorBloque['STORETEK'] as $item)
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
   @foreach (['DIEGO', 'FRANCO', 'GABRIEL', 'JONATHAN', 'VOLANTE', 'ILESA', 'BODEGA'] as $index => $instalador)
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
                           Cliente:{{ $item->calendarioDef->cliente }}<br>
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
        $primerItem = $instaladoresPorBloque['POR CONFIRMAR'][0];
                $clasesEstado = [
                'Calendarizado' => 'estado-calendarizado',
                'En espera' => 'estado-en-espera',
                'Post-Venta' => 'estado-post-venta'
            ];

                $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

    @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
    @endif
    </div>
    <div class="data-block data-block-bloqueado" id="bloque-a2-9">
        @if (isset($instaladoresPorBloque['KHEMNOVA']))
        @php
            $primerItem = $instaladoresPorBloque['KHEMNOVA'][0];
            $clasesEstado = [
            'Calendarizado' => 'estado-calendarizado',
            'En espera' => 'estado-en-espera',
            'Post-Venta' => 'estado-post-venta'
        ];

        $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['KHEMNOVA'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
    @endif
    </div>
    <div class="data-block data-block-bloqueado" id="bloque-a2-10">

        @if (isset($instaladoresPorBloque['SAN JOAQUIN']))
        @php
            $primerItem = $instaladoresPorBloque['SAN JOAQUIN'][0];
            $clasesEstado = [
            'Calendarizado' => 'estado-calendarizado',
            'En espera' => 'estado-en-espera',
            'Post-Venta' => 'estado-post-venta'
        ];

        $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['SAN JOAQUIN'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
    @endif
    </div>
    <div class="data-block data-block-bloqueado" id="bloque-a2-11">
        @if (isset($instaladoresPorBloque['STORETEK']))
        @php
            $primerItem = $instaladoresPorBloque['STORETEK'][0];
            $clasesEstado = [
            'Calendarizado' => 'estado-calendarizado',
            'En espera' => 'estado-en-espera',
            'Post-Venta' => 'estado-post-venta'
        ];

        $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['STORETEK'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
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
    @foreach (['DIEGO', 'FRANCO', 'GABRIEL', 'JONATHAN', 'VOLANTE', 'ILESA', 'BODEGA'] as $index => $instalador)
        <div class="data-block" id="bloque-a3-{{ $index + 1 }}">
            @if (isset($instaladoresPorBloque[$instalador]))
                @php
                    $primerItem = $instaladoresPorBloque[$instalador][0];
                    $clasesEstado = [
                    'Calendarizado' => 'estado-calendarizado',
                    'En espera' => 'estado-en-espera',
                    'Post-Venta' => 'estado-post-venta'
                ];

                    $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';


                @endphp
                <div class="{{ $claseEstado }}">
                    @foreach ($instaladoresPorBloque[$instalador] as $item)
                    <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                        @if ($item->fecha_instalacion2)
                            NV:{{ $item->nota_venta }}<br>
                            Cliente:{{ $item->calendarioDef->cliente }}
                            {{ $item->nota_resumida2 ?? '-' }}
                        @endif
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
    <div class="data-block red-column" id="bloque-a3-confirmar">    @if (isset($instaladoresPorBloque['POR CONFIRMAR']))
    @php
        $primerItemConfirmar = $instaladoresPorBloque['POR CONFIRMAR'][0];
        $claseEstado = $primerItemConfirmar->estado == 'Calendarizado' ? 'estado-calendarizado' : 'estado-en-espera';
    @endphp
    <div class="{{ $claseEstado }}">
        @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
        <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
            @if ($item->fecha_instalacion2)
                NV:{{ $item->nota_venta }}<br>
                Cliente:{{ $item->calendarioDef->cliente }}
                {{ $item->nota_resumida2 ?? '-' }}
            @endif
        </div>
        @endforeach
    </div>
@endif
</div>
    <div class="data-block data-block-bloqueado" id="bloque-a3-9">
        @if (isset($instaladoresPorBloque['KHEMNOVA']))
        @php
            $primerItem = $instaladoresPorBloque['KHEMNOVA'][0];
                    $clasesEstado = [
                    'Calendarizado' => 'estado-calendarizado',
                    'En espera' => 'estado-en-espera',
                    'Post-Venta' => 'estado-post-venta'
                ];

                    $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['KHEMNOVA'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
    @endif
    </div>
    <div class="data-block data-block-bloqueado" id="bloque-a3-10">
        @if (isset($instaladoresPorBloque['SAN JOAQUIN']))
        @php
            $primerItem = $instaladoresPorBloque['SAN JOAQUIN'][0];
                    $clasesEstado = [
                    'Calendarizado' => 'estado-calendarizado',
                    'En espera' => 'estado-en-espera',
                    'Post-Venta' => 'estado-post-venta'
                ];

                    $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['SAN JOAQUIN'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
    @endif
    </div>
    <div class="data-block data-block-bloqueado" id="bloque-a3-11">
        @if (isset($instaladoresPorBloque['STORETEK']))
        @php
            $primerItem = $instaladoresPorBloque['STORETEK'][0];
                    $clasesEstado = [
                    'Calendarizado' => 'estado-calendarizado',
                    'En espera' => 'estado-en-espera',
                    'Post-Venta' => 'estado-post-venta'
                ];

                    $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['STORETEK'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
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
        @foreach (['DIEGO', 'FRANCO', 'GABRIEL', 'JONATHAN', 'VOLANTE', 'ILESA', 'BODEGA'] as $index => $instalador)
            <div class="data-block" id="bloque-a4-{{ $index + 1 }}">
                @if (isset($instaladoresPorBloque[$instalador]))
                    @php
                        $primerItem = $instaladoresPorBloque[$instalador][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                    @endphp
                    <div class="{{ $claseEstado }}">
                        @foreach ($instaladoresPorBloque[$instalador] as $item)
                        <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                            @if ($item->fecha_instalacion2)
                                NV:{{ $item->nota_venta }}<br>
                                Cliente:{{ $item->calendarioDef->cliente }}
                                {{ $item->nota_resumida2 ?? '-' }}
                            @endif
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
        <div class="data-block red-column" id="bloque-a4-confirmar"> 
            @if (isset($instaladoresPorBloque['POR CONFIRMAR']))
            @php
                $primerItemConfirmar = $instaladoresPorBloque['POR CONFIRMAR'][0];
                $primerItem = $instaladoresPorBloque[$instalador][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

            @endphp
            <div class="{{ $claseEstado }}">
                @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
                    {{ $item->nota_resumida2 ?? '-' }}<br>
                @endforeach
            </div>
        @endif
        </div>
        <div class="data-block data-block-bloqueado" id="bloque-a4-9">
            @if (isset($instaladoresPorBloque['KHEMNOVA']))
            @php
                $primerItem = $instaladoresPorBloque['KHEMNOVA'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

            @endphp
            <div class="{{ $claseEstado }}">
                @foreach ($instaladoresPorBloque['KHEMNOVA'] as $item)
                <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                    @if ($item->fecha_instalacion2)
                        NV:{{ $item->nota_venta }}<br>
                        Cliente:{{ $item->calendarioDef->cliente }}
                        {{ $item->nota_resumida2 ?? '-' }}
                    @endif
                </div>
                @endforeach
            </div>
        @endif
        </div>


        <div class="data-block data-block-bloqueado" id="bloque-a4-10">
            @if (isset($instaladoresPorBloque['SAN JOAQUIN']))
            @php
                $primerItem = $instaladoresPorBloque['SAN JOAQUIN'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

            @endphp
            <div class="{{ $claseEstado }}">
                @foreach ($instaladoresPorBloque['SAN JOAQUIN'] as $item)
                <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                    @if ($item->fecha_instalacion2)
                        NV:{{ $item->nota_venta }}<br>
                        Cliente:{{ $item->calendarioDef->cliente }}
                        {{ $item->nota_resumida2 ?? '-' }}
                    @endif
                </div>
                @endforeach
            </div>
        @endif
        </div>
        <div class="data-block data-block-bloqueado" id="bloque-a4-11">
            @if (isset($instaladoresPorBloque['STORETEK']))
            @php
                $primerItem = $instaladoresPorBloque['STORETEK'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

            @endphp
            <div class="{{ $claseEstado }}">
                @foreach ($instaladoresPorBloque['STORETEK'] as $item)
                <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                    @if ($item->fecha_instalacion2)
                        NV:{{ $item->nota_venta }}<br>
                        Cliente:{{ $item->calendarioDef->cliente }}
                        {{ $item->nota_resumida2 ?? '-' }}
                    @endif
                </div>
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
        @foreach (['DIEGO', 'FRANCO', 'GABRIEL', 'JONATHAN', 'VOLANTE', 'ILESA', 'BODEGA'] as $index => $instalador)
            <div class="data-block" id="bloque-a5-{{ $index + 1 }}">
                @if (isset($instaladoresPorBloque[$instalador]))
                    @php
                        $primerItem = $instaladoresPorBloque[$instalador][0];
                        $clasesEstado = [
                        'Calendarizado' => 'estado-calendarizado',
                        'En espera' => 'estado-en-espera',
                        'Post-Venta' => 'estado-post-venta'
                    ];

                    $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                    @endphp
                    <div class="{{ $claseEstado }}">
                        @foreach ($instaladoresPorBloque[$instalador] as $item)
                        <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                            @if ($item->fecha_instalacion2)
                                NV:{{ $item->nota_venta }}<br>
                                Cliente:{{ $item->calendarioDef->cliente }}
                                {{ $item->nota_resumida2 ?? '-' }}
                            @endif
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
        <div class="data-block red-column" id="bloque-a5-confirmar">
        @if (isset($instaladoresPorBloque['POR CONFIRMAR']))
        @php
            $primerItemConfirmar = $instaladoresPorBloque['POR CONFIRMAR'][0];
            $primerItem = $instaladoresPorBloque[$instalador][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
        @endif
        </div>
        <div class="data-block data-block-bloqueado" id="bloque-a5-9">
            @if (isset($instaladoresPorBloque['KHEMNOVA']))
            @php
                $primerItem = $instaladoresPorBloque['KHEMNOVA'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

            @endphp
            <div class="{{ $claseEstado }}">
                @foreach ($instaladoresPorBloque['KHEMNOVA'] as $item)
                <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                    @if ($item->fecha_instalacion2)
                        NV:{{ $item->nota_venta }}<br>
                        Cliente:{{ $item->calendarioDef->cliente }}
                        {{ $item->nota_resumida2 ?? '-' }}
                    @endif
                </div>
                @endforeach
            </div>
        @endif
        </div>
        <div class="data-block data-block-bloqueado" id="bloque-a5-10">
            @if (isset($instaladoresPorBloque['SAN JOAQUIN']))
            @php
                $primerItem = $instaladoresPorBloque['SAN JOAQUIN'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

            @endphp
            <div class="{{ $claseEstado }}">
                @foreach ($instaladoresPorBloque['SAN JOAQUIN'] as $item)
                <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                    @if ($item->fecha_instalacion2)
                        NV:{{ $item->nota_venta }}<br>
                        Cliente:{{ $item->calendarioDef->cliente }}
                        {{ $item->nota_resumida2 ?? '-' }}
                    @endif
                </div>
                @endforeach
            </div>
        @endif
        </div>




        <div class="data-block data-block-bloqueado" id="bloque-a5-11">

            @if (isset($instaladoresPorBloque['STORETEK']))
            @php
                $primerItem = $instaladoresPorBloque['STORETEK'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

            @endphp
            <div class="{{ $claseEstado }}">
                @foreach ($instaladoresPorBloque['STORETEK'] as $item)
                <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                    @if ($item->fecha_instalacion2)
                        NV:{{ $item->nota_venta }}<br>
                        Cliente:{{ $item->calendarioDef->cliente }}
                        {{ $item->nota_resumida2 ?? '-' }}
                    @endif
                </div>
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
    @foreach (['DIEGO', 'FRANCO', 'GABRIEL', 'JONATHAN', 'VOLANTE', 'ILESA', 'BODEGA'] as $index => $instalador)
        <div class="data-block" id="bloque-a6-{{ $index + 1 }}">
            @if (isset($instaladoresPorBloque[$instalador]))
                @php
                    $primerItem = $instaladoresPorBloque[$instalador][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                @endphp
                <div class="{{ $claseEstado }}">
                    @foreach ($instaladoresPorBloque[$instalador] as $item)
                    <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                        @if ($item->fecha_instalacion2)
                            NV:{{ $item->nota_venta }}<br>
                            Cliente:{{ $item->calendarioDef->cliente }}
                            {{ $item->nota_resumida2 ?? '-' }}
                        @endif
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
    <div class="data-block red-column" id="bloque-a6-confirmar"> 
        @if (isset($instaladoresPorBloque['POR CONFIRMAR']))
        @php
                    $primerItem = $instaladoresPorBloque['POR CONFIRMAR'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
    @endif
    </div>
    <div class="data-block data-block-bloqueado" id="bloque-a6-9">
        @if (isset($instaladoresPorBloque['KHEMNOVA']))
        @php
            $primerItem = $instaladoresPorBloque['KHEMNOVA'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['KHEMNOVA'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
    @endif
    </div>
    <div class="data-block data-block-bloqueado" id="bloque-a6-10">
        @if (isset($instaladoresPorBloque['SAN JOAQUIN']))
        @php
            $primerItem = $instaladoresPorBloque['SAN JOAQUIN'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['SAN JOAQUIN'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
    @endif
    </div>
    <div class="data-block data-block-bloqueado" id="bloque-a6-11">
        @if (isset($instaladoresPorBloque['STORETEK']))
        @php
            $primerItem = $instaladoresPorBloque['STORETEK'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['STORETEK'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
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
    @foreach (['DIEGO', 'FRANCO', 'GABRIEL', 'JONATHAN', 'VOLANTE', 'ILESA', 'BODEGA'] as $index => $instalador)
        <div class="data-block" id="bloque-a7-{{ $index + 1 }}">
            @if (isset($instaladoresPorBloque[$instalador]))
                @php
                    $primerItem = $instaladoresPorBloque[$instalador][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                @endphp
                <div class="{{ $claseEstado }}">
                    @foreach ($instaladoresPorBloque[$instalador] as $item)
                    <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                        @if ($item->fecha_instalacion2)
                            NV:{{ $item->nota_venta }}<br>
                            Cliente:{{ $item->calendarioDef->cliente }}
                            {{ $item->nota_resumida2 ?? '-' }}
                        @endif
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
    <div class="data-block red-column" id="bloque-a7-confirmar">   @if (isset($instaladoresPorBloque['POR CONFIRMAR']))
        @php
                    $primerItem = $instaladoresPorBloque['POR CONFIRMAR'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
    @endif
    </div>
    <div class="data-block data-block-bloqueado" id="bloque-a7-9">
        @if (isset($instaladoresPorBloque['KHEMNOVA']))
        @php
            $primerItem = $instaladoresPorBloque['KHEMNOVA'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['KHEMNOVA'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
    @endif
    </div>
    <div class="data-block data-block-bloqueado" id="bloque-a7-10">
        @if (isset($instaladoresPorBloque['SAN JOAQUIN']))
        @php
            $primerItem = $instaladoresPorBloque['SAN JOAQUIN'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['SAN JOAQUIN'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
    @endif
    </div>
    <div class="data-block data-block-bloqueado" id="bloque-a7-11">
        @if (isset($instaladoresPorBloque['STORETEK']))
        @php
            $primerItem = $instaladoresPorBloque['STORETEK'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['STORETEK'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
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
    @foreach (['DIEGO', 'FRANCO', 'GABRIEL', 'JONATHAN', 'VOLANTE', 'ILESA', 'BODEGA'] as $index => $instalador)
        <div class="data-block" id="bloque-a8-{{ $index + 1 }}">
            @if (isset($instaladoresPorBloque[$instalador]))
                @php
                    $primerItem = $instaladoresPorBloque[$instalador][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                @endphp
                <div class="{{ $claseEstado }}">
                    @foreach ($instaladoresPorBloque[$instalador] as $item)
                    <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                        @if ($item->fecha_instalacion2)
                            NV:{{ $item->nota_venta }}<br>
                            Cliente:{{ $item->calendarioDef->cliente }}
                            {{ $item->nota_resumida2 ?? '-' }}
                        @endif
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
    <div class="data-block red-column" id="bloque-a8-confirmar">
        @if (isset($instaladoresPorBloque['POR CONFIRMAR']))
        @php
                    $primerItem = $instaladoresPorBloque['POR CONFIRMAR'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

                @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['POR CONFIRMAR'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
    @endif
    </div>


    <div class="data-block data-block-bloqueado" id="bloque-a8-9">
        @if (isset($instaladoresPorBloque['KHEMNOVA']))
    @php
        $primerItem = $instaladoresPorBloque['KHEMNOVA'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

    @endphp
    <div class="{{ $claseEstado }}">
        @foreach ($instaladoresPorBloque['KHEMNOVA'] as $item)
        <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
            @if ($item->fecha_instalacion2)
                NV:{{ $item->nota_venta }}<br>
                Cliente:{{ $item->calendarioDef->cliente }}
                {{ $item->nota_resumida2 ?? '-' }}
            @endif
        </div>
        @endforeach
    </div>
@endif

    </div>

    <div class="data-block data-block-bloqueado" id="bloque-a8-10">
        @if (isset($instaladoresPorBloque['SAN JOAQUIN']))
        @php
            $primerItem = $instaladoresPorBloque['SAN JOAQUIN'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['SAN JOAQUIN'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
    @endif
    </div>
    <div class="data-block data-block-bloqueado" id="bloque-a8-11">
        @if (isset($instaladoresPorBloque['STORETEK']))
        @php
            $primerItem = $instaladoresPorBloque['STORETEK'][0];
                            $clasesEstado = [
                            'Calendarizado' => 'estado-calendarizado',
                            'En espera' => 'estado-en-espera',
                            'Post-Venta' => 'estado-post-venta'
                        ];

                            $claseEstado = $clasesEstado[$primerItem->estado] ?? 'alguna-clase-default';

        @endphp
        <div class="{{ $claseEstado }}">
            @foreach ($instaladoresPorBloque['STORETEK'] as $item)
            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}">
                @if ($item->fecha_instalacion2)
                    NV:{{ $item->nota_venta }}<br>
                    Cliente:{{ $item->calendarioDef->cliente }}
                    {{ $item->nota_resumida2 ?? '-' }}
                @endif
            </div>
            @endforeach
        </div>
    @endif
    </div>
    </div>


</div>
