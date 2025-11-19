<div class="miModalSeleccionDias" id="modalSeleccionDias1">
  <div class="miModalSeleccionDias-content">
      <div class="miModalSeleccionDias-header">
          <span class="miModalSeleccionDias-close-button" onclick="cerrarModalSeleccionDias1()">&times;</span>
          <h2>Seleccione los días a asignar</h2>
      </div>
      <div class="miModalSeleccionDias-controls">
          <button onclick="cambiarMes1(-1)">&#10094;</button>
          <span id="mesAnio1"></span>
          <button onclick="cambiarMes1(1)">&#10095;</button>
      </div>
      <div class="miModalSeleccionDias-body" id="calendarioContainer1">
      </div>
      <div class="fechasSeleccionadas-container">
          <input type="text" id="fechasSeleccionadas1" readonly>
      </div>
      <div class="miModalSeleccionDias-footer">
          <button class="miModalSeleccionDias-btn" onclick="guardarCambios1()">Guardar Cambios</button>
          <button class="miModalSeleccionDias-btn miModalSeleccionDias-btn-primary" onclick="cerrarModalSeleccionDias1()">Cerrar</button>
      </div>
  </div>
</div>

<style>
  .miModalSeleccionDias-content {
      width: 80%; 
      max-width: 600px; 
  }

  .fechasSeleccionadas-container {
      margin: 20px 0; 
  }

  #fechasSeleccionadas, #fechasSeleccionadas1 {
      width: 100%; 
      padding: 10px; 
      box-sizing: border-box; 
  }

  .miModalSeleccionDias-controls,
  .miModalSeleccionDias-footer {
      display: flex;
      justify-content: space-between; 
      padding: 10px; 
  }

  .miModalSeleccionDias-controls button,
  .miModalSeleccionDias-footer button {
      padding: 5px 10px; 
      margin: 0 5px; 
      cursor: pointer;
  }

  /* Estilo para los días del calendario */
  .dia {
      display: inline-block;
      width: calc(100% / 7 - 2px); /* Ajusta esto según el número de días que quieras mostrar por fila */
      padding: 10px;
      margin: 1px;
      background-color: #f0f0f0;
      text-align: center;
      cursor: pointer;
  }

  .dia.seleccionado {
      background-color: #007bff;
      color: white;
  }
</style>
