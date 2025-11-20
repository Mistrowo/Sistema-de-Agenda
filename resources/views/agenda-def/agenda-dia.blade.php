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
        th, td { width: 12.5%; }
        th:first-child, td:first-child { width: 12.5%; }
        .item-card { min-height: 78px; }
    </style>
</head>

<body class="bg-p-gray min-h-screen">

    <!-- HEADER COMPACTO Y ELEGANTE -->
    <div class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="px-4 py-3 flex items-center justify-between">
            <h1 class="text-lg font-bold text-gray-800">Calendario Día</h1>

            <div class="flex items-center gap-3 bg-p-blue/50 rounded-full px-5 py-1.5">
                <button id="prev-day" class="text-p-darkblue hover:bg-white/60 p-1.5 rounded-full transition">
                    <i class="fas fa-chevron-left text-sm"></i>
                </button>
                <div id="current-date" class="font-bold text-p-darkblue text-base min-w-[160px] text-center leading-tight"></div>
                <button id="next-day" class="text-p-darkblue hover:bg-white/60 p-1.5 rounded-full transition">
                    <i class="fas fa-chevron-right text-sm"></i>
                </button>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('calendariosemana') }}">
                    <button class="bg-p-green hover:bg-green-300 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium transition">
                        Vista Semanal
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

    <!-- TABLA PRINCIPAL -->
    <div class="px-4 py-6">
        <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
            <table class="w-full table-fixed">
                <thead class="bg-gradient-to-r from-p-blue to-p-purple text-gray-800">
                    <tr>
                        <th class="px-4 py-4 text-xs font-bold uppercase">Bloque</th>
                        <th class="px-4 py-4 text-xs font-bold uppercase">DIEGO</th>
                        <th class="px-4 py-4 text-xs font-bold uppercase">FRANCO</th>
                        <th class="px-4 py-4 text-xs font-bold uppercase">GABRIEL</th>
                        <th class="px-4 py-4 text-xs font-bold uppercase">JONATHAN</th>
                        <th class="px-4 py-4 text-xs font-bold uppercase">VOLANTE</th>
                        <th class="px-4 py-4 text-xs font-bold uppercase">ILESA</th>
                        <th class="px-4 py-4 text-xs font-bold uppercase">BODEGA</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @foreach ($bloques as $bloque)
                        @php
                            $horario = $bloquesHorarios[$bloque] ?? $bloque;
                            $items = $agendaItems->where('bloque', $bloque);
                        @endphp

                        <tr class="hover:bg-p-gray/50 transition">
                            <td class="px-4 py-5 text-center font-medium bg-p-blue/30 border-r border-gray-200">
                                <div class="text-sm font-bold text-gray-800">{{ $horario }}</div>
                                <div class="text-xs text-gray-600">{{ $bloque }}</div>
                            </td>

                          @foreach(['DIEGO','FRANCO','GABRIEL','JONATHAN','VOLANTE','ILESA','BODEGA'] as $instalador)
    @php
        $itemsInstalador = $items->where('instalador', $instalador);
    @endphp
    <td class="p-3 align-top border-r border-gray-200">
        <div class="space-y-2">
            @foreach($itemsInstalador as $item)
                @php
                    $bg = match($item->estado) {
                        'Calendarizado' => 'bg-p-blue border-blue-400 text-blue-900',
                        'En espera'     => 'bg-p-pink border-amber-400 text-amber-900',
                        'Post-Venta'    => 'bg-p-green border-green-400 text-green-900',
                        default         => 'bg-gray-100 border-gray-400 text-gray-700'
                    };
                    
                    // ✅ OBTENER CLIENTE - Esta es la línea crítica
                    $cliente = $item->cliente ?? 'Sin cliente';
                @endphp

                <div 
                    class="item-card rounded-lg border-2 {{ $bg }} p-3 shadow hover:shadow-lg transition transform hover:-translate-y-1 cursor-pointer"
                    data-item='@json($item)'
                    onclick="abrirModalSeguro(this)">
                    <div class="text-xs font-bold text-gray-800">
                        NV: {{ $item->nota_venta }}
                    </div>
                    <div class="text-xs truncate text-gray-700 mt-1">
                        {{ Str::limit($cliente, 22) }}
                    </div>
                    @if($item->nota_resumida)
                        <div class="text-[10px] italic text-gray-600 mt-1 truncate">
                            {{ Str::limit($item->nota_resumida, 32) }}
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

    <!-- MODAL -->
    <div id="modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-xl w-full">
            <div class="bg-gradient-to-r from-p-blue to-p-purple text-gray-800 p-5 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold">Detalle Instalación</h3>
                    <button onclick="document.getElementById('modal').classList.add('hidden')" class="p-2 hover:bg-white/30 rounded-lg text-2xl">
                        ×
                    </button>
                </div>
            </div>
            <div class="p-6 space-y-4" id="modal-body"></div>
        </div>
    </div>

    <script>
        const meses = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
        let fecha = new Date();

        // Obtener fecha desde URL
        const urlParams = new URLSearchParams(window.location.search);
        const fechaURL = urlParams.get('fecha');
        if (fechaURL) {
            fecha = new Date(fechaURL + 'T00:00:00');
        }

        function actualizarFecha() {
            const dia = fecha.getDate();
            const mes = meses[fecha.getMonth()];
            const año = fecha.getFullYear();
            document.getElementById('current-date').innerHTML = `${dia} ${mes} ${año}`;
        }

        document.getElementById('prev-day').onclick = () => { 
            fecha.setDate(fecha.getDate() - 1);
            recargarConFecha();
        };
        
        document.getElementById('next-day').onclick = () => { 
            fecha.setDate(fecha.getDate() + 1);
            recargarConFecha();
        };

        function recargarConFecha() {
            const fechaFormateada = fecha.toISOString().slice(0, 10);
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
    // ✅ Obtener cliente de diferentes fuentes posibles
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
                <span class="px-2 py-1 rounded text-xs font-medium ${
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
        <div class="flex justify-end gap-3 mt-6">
            <button onclick="document.getElementById('modal').classList.add('hidden')" 
                    class="px-6 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-sm">
                Cerrar
            </button>
        </div>
    `;
    document.getElementById('modal').classList.remove('hidden');
}
        actualizarFecha();
    </script>
</body>
</html>