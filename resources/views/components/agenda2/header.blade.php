
<script>
    var nombreInstalador = "{{ session('usuario') ? session('usuario')->NOMBRE : 'Usuario no autenticado' }}";
</script>
  <div class="container">
    <div class="side-content">
     
    </div>
    <div class="main-title">AGENDA INSTALACIONES</div>
    <div class="side-content">
      <div class="info">Fecha: <span>{{ session('fecha', 'Fecha no disponible') }}</span></div>
      <div class="info">Usuario: <span>{{ session('usuario') ? session('usuario')->NOMBRE : 'Usuario no autenticado' }}</span></div>
      <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" >Cerrar Sesión</button>
      </form>
  </div>
  

    </div>
  </div>
    


      <div class="section-container">
        <div class="titulo-notas-ventas">
          <h2>Instalación</h2>
        </div>
        
        <div class="datos-venta-fecha">
          <div class="nota-venta">
            <label for="notaVentaNum">Nota de Venta N°:</label>
            <input type="text" id="notaVentaNum"  value="{{ $calendarioDef1->nota_venta ?? '' }}" readonly> 
          
        </div>
         
          <div class="cliente">
            <label for="clienteNombre">Cliente:</label>
            <input type="text" id="clienteNombre"  value="{{ $calendarioDef1->cliente ?? '' }}" readonly>
          </div>
          <div class="descripcion">
            <label for="descripcion">Descripción:</label>
            <input type="text" id="descripcion"  value="{{ $calendarioDef1->descripcion ?? ''  }}" readonly>
          </div>
          <div class="form-field half-width">

            <label for="fechaEntrega">Fecha Entrega</label>
            <input type="date" id="fechaEntregaModal" value="{{$fechaEntrega ?? ''  }}" readonly>
          

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
 
  <button class="comando-btn" onclick="window.location.href='{{ route('calendario3') }}';">
    <i class="fa fa-undo"></i>
    <span class="tooltip-text">Volver al calendario</span>
</button>
  

</div>





    
        </div>
        


       
      </div>
