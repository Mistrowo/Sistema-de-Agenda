<div class="container">
    <div class="side-content">
    </div>
    <div class="main-title">CALENDARIO DE  INSTALACIONES KHEMNOVA</div>
    <div class="side-content">
      <div class="info">Fecha: <span>{{ session('fecha', 'Fecha no disponible') }}</span></div>
      <div class="info">Usuario: <span>{{ session('usuario') ? session('usuario')->NOMBRE : 'Usuario no autenticado' }}</span></div>
      <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit">Cerrar Sesión</button>
      </form>
  </div>
  
    </div>
  </div>

<div class="main-container">
<div class="section-container">
<div class="titulo-notas-ventas">
  <h2>Notas de Ventas:</h2>
</div>

<div class="filtro-fechas">
  
  <div class="fechas">
    <form method="GET" action="{{ route('calendario4') }}">
      Desde: <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}">
      Hasta: <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
      <button type="submit">Ejecutar</button>
  </form>
  
  </div>
     



  <div class="comandos">
    <div class="titulo-comandos">
        <span>Comandos:</span>
    </div>
    <a href="{{ route('agenda5') }}" class="tooltip-container">
      <i class="fa fa-calendar-alt"></i>
      <span class="tooltip-text">Ir a la Agenda por Instalacion</span>
  </a>
 
    <a href="javascript:void(0);" onclick="location.reload();" class="tooltip-container">
      <i class="fa fa-undo"></i>
      <span class="tooltip-text">Recargar Pagina</span>

  </a>
    </div>

  
    <div class="alertas">
      <div class="titulo-alertas">
        <span>Alertas: </span>
      </div>
      <div class="alerta">
        <div class="cuadro alerta-color" style="background-color: #FFFF00;"></div>
        <span>En espera</span>
      </div>
      <div class="alerta">
        <div class="cuadro alerta-color" style="background-color: #008000;"></div>
        <span>Calendarizado</span>
      </div>
      <div class="alerta">
        <div class="cuadro alerta-color" style="background-color: #FF0000;"></div>
        <span>Alerta</span>
      </div>
      <div class="alerta">
        <div class="cuadro alerta-icon">
            <i class="fas fa-exclamation-triangle filtro-pendiente" style="color: #FFA500;"></i> 
        </div>
        <span>Pendiente</span>
    </div>
    
    <div class="alerta">
        <div class="cuadro alerta-icon">
            <i class="fas fa-check filtro-finalizado" style="color: #28a745;"></i> 
        </div>
        <span>Finalizado</span>
    </div>
  
      
    </div>

    
 
</div>


</div>
</div>