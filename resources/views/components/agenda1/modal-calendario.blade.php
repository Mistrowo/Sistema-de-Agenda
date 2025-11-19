<div class="miModalSeleccionDias" id="modalSeleccionDias">
    <div class="miModalSeleccionDias-content">
        <div class="miModalSeleccionDias-header">
            <span class="miModalSeleccionDias-close-button" onclick="cerrarModalSeleccionDias()">&times;</span>
            <h2>Seleccione los días a asignar </h2>
        </div>
        <div class="miModalSeleccionDias-controls">
            <button onclick="cambiarMes(-1)">&#10094;</button>
            <span id="mesAnio"></span>
            <button onclick="cambiarMes(1)">&#10095;</button>
        </div>
        <div class="miModalSeleccionDias-body" id="calendarioContainer">
        </div>

        <div class="fechasSeleccionadas-container">
          <input type="text" id="fechasSeleccionadas" readonly>
      </div>
        
      <div class="miModalSeleccionDias-footer">
        <button class="miModalSeleccionDias-btn" onclick="guardarCambios()">Guardar Cambios</button>
        <button class="miModalSeleccionDias-btn miModalSeleccionDias-btn-primary" onclick="cerrarModalSeleccionDias()">Cerrar</button>
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

    #fechasSeleccionadas {
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
</style>
