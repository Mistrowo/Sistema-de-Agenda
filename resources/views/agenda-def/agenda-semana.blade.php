<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('imagenes/descarga.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'p-blue': '#dbeafe',
                        'p-green': '#d1fae5',
                        'p-yellow': '#fef3c7',
                        'p-pink': '#fce7f3',
                        'p-purple': '#f3e8ff',
                        'p-gray': '#f8fafc',
                        'p-darkblue': '#3b82f6',
                    }
                }
            }
        }
    </script>

    <style>
        table { table-layout: fixed; width: 100%; }
        th, td { width: 14.28%; }
        th:first-child, td:first-child { width: 14.28%; }
        .item-card {
            min-height: 76px;
            margin: 4px 0;
            padding: 10px;
            border-radius: 12px;
            border-width: 2px;
            font-size: 0.75rem;
            line-height: 1.3;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            transition: all 0.2s ease;
        }
        .item-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
    </style>
</head>

<body class="bg-p-gray min-h-screen">

    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="px-4 py-3 flex items-center justify-between">
            <h1 class="text-lg font-bold text-gray-800">Calendario Semanal</h1>

            <div class="flex items-center gap-3 bg-p-blue/50 rounded-full px-5 py-1.5">
                <button id="prev-week-button" class="text-p-darkblue hover:bg-white/60 p-1.5 rounded-full transition">
                    <i class="fas fa-chevron-left text-sm"></i>
                </button>
                <div id="week-dates" class="font-bold text-p-darkblue text-base min-w-[240px] text-center leading-tight"></div>
                <button id="next-week-button" class="text-p-darkblue hover:bg-white/60 p-1.5 rounded-full transition">
                    <i class="fas fa-chevron-right text-sm"></i>
                </button>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('calendariodia') }}">
                    <button class="bg-p-green hover:bg-green-300 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium transition">
                        Por Día
                    </button>
                </a>
                <a href="{{ route('calendario') }}">
                    <button class="bg-gradient-to-r from-p-darkblue to-blue-600 hover:opacity-90 text-white px-4 py-2 rounded-lg text-sm font-bold transition">
                        Inicio
                    </button>
                </a>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3 justify-center text-xs py-2">
            <span class="font-semibold text-gray-700">
                <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                Leyenda:
            </span>
            
            <div class="flex items-center gap-1.5 bg-blue-100 px-2 py-1 rounded border border-blue-300">
                <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                <span class="font-medium text-blue-800">Calendarizado</span>
            </div>
            
            <div class="flex items-center gap-1.5 bg-red-100 px-2 py-1 rounded border border-red-300">
                <div class="w-2 h-2 rounded-full bg-red-400"></div>
                <span class="font-medium text-red-800">En Espera</span>
            </div>
            
            <div class="flex items-center gap-1.5 bg-green-100 px-2 py-1 rounded border border-green-300">
                <div class="w-2 h-2 rounded-full bg-green-400"></div>
                <span class="font-medium text-green-800">Post Venta</span>
            </div>
        </div>
    </div>

    <!-- TABLA SEMANAL -->
    <div class="px-4 py-6">
        <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
            <table class="w-full table-fixed">
                <thead class="bg-gradient-to-r from-p-blue to-p-purple text-gray-800">
                    <tr>
                        <th class="px-4 py-4 text-xs font-bold uppercase">Bloque</th>
                        @foreach ($weekDates as $fechaCompleta)
                            @php
                                $fecha = trim(substr($fechaCompleta, strpos($fechaCompleta, ',') !== false ? strpos($fechaCompleta, ',') + 1 : 0));
                                $carbon = \Carbon\Carbon::parse($fecha);

                                $diaEs = [
                                    'Monday'    => 'LUNES',
                                    'Tuesday'   => 'MARTES',
                                    'Wednesday' => 'MIÉRCOLES',
                                    'Thursday'  => 'JUEVES',
                                    'Friday'    => 'VIERNES',
                                    'Saturday'  => 'SÁBADO',
                                    'Sunday'    => 'DOMINGO'
                                ][$carbon->format('l')];
                            @endphp
                            <th class="px-4 py-4 text-xs font-bold uppercase text-center">
                                {{ $diaEs }}<br>
                                <span class="text-[10px] opacity-80">{{ $carbon->format('d/m') }}</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @php
                        $bloquesMap = [
                            'A-1' => '08:00-10:00',
                            'A-2' => '10:00-12:00',
                            'A-3' => '12:00-14:00',
                            'A-4' => '14:00-16:00',
                            'A-5' => '16:00-18:00',
                            'A-6' => '18:00-20:00',
                            'A-7' => '20:00-22:00',
                            'A-8' => '22:00-24:00',
                        ];
                    @endphp

                    @foreach ($bloquesMap as $bloque => $horario)
                        <tr class="hover:bg-p-gray/50 transition">
                            <td class="px-4 py-5 text-center font-medium bg-p-blue/30 border-r border-gray-200">
                                <div class="text-sm font-bold text-gray-800">{{ $horario }}</div>
                                <div class="text-xs text-gray-600">{{ $bloque }}</div>
                            </td>

                            @foreach ($weekDates as $index => $fechaCompleta)
                                @php
                                    $fechaDia = trim(substr($fechaCompleta, strpos($fechaCompleta, ',') !== false ? strpos($fechaCompleta, ',') + 1 : 0));

                                    $itemsDiaBloque = $agendaItems
                                        ->where('fecha_instalacion2', $fechaDia)
                                        ->where('bloque', $bloque);
                                @endphp

                                <td class="p-3 align-top border-r border-gray-200">
                                    <div class="space-y-2">
                                       @foreach($itemsDiaBloque as $item)
    @php
        $colorClass = match($item->estado) {
            'Calendarizado' => 'bg-p-blue border-blue-400 text-blue-900',
            'En espera'     => 'bg-p-pink border-amber-400 text-amber-900',
            'Post-Venta'    => 'bg-p-green border-green-400 text-green-900',
            default         => 'bg-gray-100 border-gray-400 text-gray-700'
        };
        
        $cliente = $item->notaVentaSoftland?->nv_cliente ?? $item->cliente ?? $item->nombre_cliente ?? 'Sin cliente';
    @endphp

    <div class="item-card rounded-lg border-2 {{ $colorClass }} shadow hover:shadow-lg transition transform hover:-translate-y-1 cursor-pointer"
         data-item='@json($item)'
         onclick="abrirModalSeguro(this)">
        <div class="font-bold text-gray-800 text-xs">NV: {{ $item->nota_venta }}</div>
        <div class="text-xs text-gray-700 truncate mt-1">
            {{ Str::limit($cliente, 20) }}
        </div>
        @if($item->nota_resumida)
            <div class="text-[10px] italic text-gray-600 mt-1 truncate">
                {{ Str::limit($item->nota_resumida, 30) }}
            </div>
        @endif
    </div>
@endforeach
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-xl w-full">
            <div class="bg-gradient-to-r from-p-blue to-p-purple text-gray-800 p-5 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold">Detalle Instalación</h3>
                    <button onclick="document.getElementById('modal').classList.add('hidden')" class="text-xl hover:bg-white/30 p-2 rounded-lg">×</button>
                </div>
            </div>
            <div class="p-6 space-y-4" id="modal-body"></div>
        </div>
    </div>

    <script>
        const meses = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
        let lunesActual = new Date();
        
        const urlParams = new URLSearchParams(window.location.search);
        const fechaURL = urlParams.get('fecha');
        
        if (fechaURL) {
            lunesActual = new Date(fechaURL + 'T00:00:00');
        } else {
            lunesActual.setDate(lunesActual.getDate() - lunesActual.getDay() + 1);
        }

        function actualizarRango() {
            let dias = [];
            for(let i = 0; i < 7; i++) {
                let d = new Date(lunesActual);
                d.setDate(d.getDate() + i);
                dias.push(d);
            }
            const inicio = `${dias[0].getDate()} ${meses[dias[0].getMonth()]}`;
            const fin = `${dias[6].getDate()} ${meses[dias[6].getMonth()]} ${dias[6].getFullYear()}`;
            document.getElementById('week-dates').innerHTML = `${inicio} - ${fin}`;
        }

        document.getElementById('prev-week-button').onclick = () => {
            lunesActual.setDate(lunesActual.getDate() - 7);
            recargarConFecha();
        };

        document.getElementById('next-week-button').onclick = () => {
            lunesActual.setDate(lunesActual.getDate() + 7);
            recargarConFecha();
        };

        function recargarConFecha() {
            const fechaFormateada = lunesActual.toISOString().slice(0, 10);
            const url = new URL(window.location.href);
            url.searchParams.set('fecha', fechaFormateada);
            window.location.href = url.toString();
        }

        function abrirModalSeguro(element) {
            try {
                const itemJson = element.getAttribute('data-item');
                const item = JSON.parse(itemJson);
                abrirModal(item);
            } catch(e) {
                console.error('Error al abrir modal:', e);
                alert('Error al cargar los datos del modal');
            }
        }

      function abrirModal(item) {
    const notaResumida = item.nota_resumida || '';
    const notaResumida2 = item.nota_resumida2 || '';
    const observacionBloque = item.observacion_bloque || '';
    
    document.getElementById('modal-body').innerHTML = `
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><strong>NV:</strong> ${item.nota_venta || 'N/A'}</div>
            <div><strong>Fecha:</strong> ${item.fecha_instalacion2 || 'N/A'}</div>
            <div><strong>Instalador:</strong> ${item.instalador || 'Sin asignar'}</div>
            <div><strong>Bloque:</strong> ${item.bloque || 'N/A'}</div>
            <div class="col-span-2"><strong>Estado:</strong> 
                <span class="px-2 py-1 rounded text-xs font-bold ${
                    item.estado === 'Calendarizado' ? 'bg-p-blue text-green-900' :
                    item.estado === 'En espera' ? 'bg-p-pink text-amber-900' : 
                    item.estado === 'Post-Venta' ? 'bg-p-green text-pink-900' :
                    'bg-gray-100 text-gray-700'
                }">${item.estado || 'Sin estado'}</span>
            </div>
        </div>
        ${notaResumida ? `
            <div class="mt-4">
                <label class="block text-sm font-medium mb-1">Nota Resumida</label>
                <textarea class="w-full p-3 border rounded-lg bg-gray-50" rows="2" readonly>${notaResumida}</textarea>
            </div>
        ` : ''}
        ${notaResumida2 ? `
            <div class="mt-2">
                <label class="block text-sm font-medium mb-1">Nota Resumida 2</label>
                <textarea class="w-full p-3 border rounded-lg bg-gray-50" rows="2" readonly>${notaResumida2}</textarea>
            </div>
        ` : ''}
        ${observacionBloque ? `
            <div class="mt-2">
                <label class="block text-sm font-medium mb-1">Observaciones</label>
                <textarea class="w-full p-3 border rounded-lg bg-gray-50" rows="2" readonly>${observacionBloque}</textarea>
            </div>
        ` : ''}
        <div class="flex justify-end mt-6">
            <button onclick="document.getElementById('modal').classList.add('hidden')" 
                    class="px-8 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium">
                Cerrar
            </button>
        </div>
    `;
    document.getElementById('modal').classList.remove('hidden');
}
        actualizarRango();
    </script>
</body>
</html>