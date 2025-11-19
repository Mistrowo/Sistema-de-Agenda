
<div class="section-container">
    <div class="titulo-notas-ventas">
    <h2>Instalación</h2>
    </div>
    
    <div class="datos-venta-fecha">
    <div class="nota-venta">
        <label for="notaVentaNum">Nota de Venta N°:</label>
        <input type="text" id="notaVentaNum" value="{{ $calendarioDef->nota_venta ?? '' }}" readonly>          </div>
    
    
    <div class="cliente">
        <label for="clienteNombre">Cliente:</label>
        <input type="text" id="clienteNombre" value="{{ $calendarioDef->cliente ?? '' }}" readonly>
        </div>
    <div class="descripcion">
        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" value="{{ $calendarioDef->descripcion ?? ''  }}" readonly>
    </div>


    <div class="form-field half-width">
        <label for="fechaEntrega">Fecha Entrega</label>
        <input type="text" id="fechaEntregaModal" value="{{$calendarioDef->fecha_fabril}}">
    </div>
    
   

    <div class="form-field half-width">
        <label for="fechaInstalacion2">Fecha Instalación</label>
        <select id="fechaInstalacion2" onchange="mostrarInformacion(this.value)" class="select-estilo">
            @foreach ($fechasInstalacion2 as $fecha)

                <option value="{{ $fecha }}" {{ $loop->first ? 'selected' : '' }}>{{ $fecha }}</option>
            @endforeach
        </select>
        
    </div>
    
    
    <div class="estado-despachos">
        <div class="estado-despacho">
        <div class="estado-indicador confirmado"></div>
        <div class="estado-texto">Despacho Confirmado:</div>
        </div>
        <div class="estado-despacho">
        <div class="estado-indicador por-confirmar"></div>
        <div class="estado-texto">Por Confirmar:</div>
        </div>
        <div class="estado-despacho">
        <div class="estado-indicador post-venta"></div>
        <div class="estado-texto">Post Venta:</div>
        </div>
    </div>
    
        <div class="comandos-container">
        
            <button class="comando-btn" onclick="goBack()">
                <i class="fa fa-undo"></i>
                <span class="tooltip-text">Volver al calendario</span>
            </button>
            <script>
                function goBack() {
                    window.history.back();
                }
                </script>
                
        
        
        </div>


    </div>

</div>


<script>
    function mostrarInformacion(fechaSeleccionada) {
        var items = document.getElementsByClassName('item-info');
        for (var i = 0; i < items.length; i++) {
            var itemFecha = items[i].getAttribute('data-fecha-instalacion2');
            if (itemFecha === fechaSeleccionada) {
                items[i].style.display = 'block';
            } else {
                items[i].style.display = 'none';
            }
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var primeraFecha = document.getElementById('fechaInstalacion2').value;
        mostrarInformacion(primeraFecha);
        
    });
</script>

