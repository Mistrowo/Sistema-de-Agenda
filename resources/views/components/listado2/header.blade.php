<div class="container">



      
    <div class="side-content">
    </div>
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
  <style>
    .fechas input, .fechas select {
        margin-right: 20px;
    }
</style>



<div class="main-container">



    <div class="section-container">
      
      <div class="titulo-notas-ventas">
        <h2>Vista Instalador</h2>
      </div>
      
      <div class="filtro-fechas">
        <div class="fechas">
          <form method="GET" action="{{ route('calendario3') }}"> 
            Fecha Inicio: <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
            Fecha Fin: <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}">
            <button type="submit" class="btn-filtrar">Filtrar</button>
        </form>
        
          Instalador: <input type="text" name="instalador" value="<?php echo session('usuario') ? session('usuario')->NOMBRE : 'Usuario no autenticado'; ?>">
          Estado Requerimiento:
          <select name="estado" id="estadoSelect" onchange="updateSelectColor(this)">
            <option value="calendarizado">Confirmado</option>
            <option value="nocalendarizado">Por Confirmar</option>
          </select>
        </div>
      </div>
   <script>
        function updateSelectColor(selectElement) {
          if (selectElement.value === "calendarizado") {
            selectElement.className = 'select-calendarizado';
          } else {
            selectElement.className = 'select-no-calendarizado';
          }
        }
      
        window.onload = function() {
          var selectElement = document.getElementById('estadoSelect');
          updateSelectColor(selectElement);
        };
      </script>
      
        
      
             
          
       
      </div>
  
      
      </div>
    </div>
  