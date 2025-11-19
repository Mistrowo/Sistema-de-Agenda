<!-- Modal de Confirmación Personalizado -->
<div class="miModalConfirmacion" id="modalConfirmacionPersonalizado">
  <div class="miModalConfirmacion-content">
      <div class="miModalConfirmacion-header">
          <span class="miModalConfirmacion-close-button" onclick="cerrarModalConfirmacionPersonalizado()">&times;</span>
          <h2>Confirmación</h2>
      </div>
      <div class="miModalConfirmacion-body">
          ¿Desea asignar fechas múltiples ?
      </div>
      <div class="miModalConfirmacion-footer">
          <button class="miModalConfirmacion-btn" onclick="enviarFormularioPersonalizado()  ">No</button>
          <button class="miModalConfirmacion-btn miModalConfirmacion-btn-primary" onclick="confirmacionYAbrirModalSeleccionDias()">Sí</button>

      </div>
  </div>
</div>
