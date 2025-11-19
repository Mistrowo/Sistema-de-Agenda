
<div class="modal" id="miModal">
    <div class="modal-content">
        <span class="close-button" onclick="cerrarModal()">&times;</span>
     
          <div class="modal-header">
            <div class="modal-title">
              <h2>LECTURA AGENDA INSTALACIONES</h2>
            </div>
            <div class="modal-meta">
              <span>Fecha: <strong>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</strong></span>
              <span>Usuario: <strong>{{ session('usuario') ? session('usuario')->NOMBRE : 'Usuario no autenticado' }}</strong></span>
            </div>
          </div>
          
      



        <div class="modal-body">
          <div class="form-row">
            <div class="form-field third-width input-icon-container">


              <label for="notaVenta">Nota Venta</label>
              <input type="text" id="notaVenta" placeholder="N°" value="{{ $calendarioDef1->nota_venta ?? '' }}" readonly>
          </div>
          
            <div class="form-field third-width">
              <label for="descripcion">Descripción</label>
              <input type="text" id="descripcionModal" value="{{ $calendarioDef1->descripcion ?? '' }}"readonly>
                  </div>
                  <div class="form-field third-width">
                      <label for="horaBloque">Hora/Bloque</label>
                      <input type="text" name="bloque" id="horaBloque"  value="" readonly>           
                  </div>

          </div>
        
          <div class="form-row">

            <div class="form-field half-width">

              <label for="fechaEntrega">Fecha Entrega</label>
              <input type="date" id="fechaEntregaModal" value="{{ $fechaEntrega }}" readonly>

            </div>

           

            <div class="form-field half-width">
              <label for="fechaInstalacion">Fecha Instalación</label>
              <input type="date" id="fechaInstalacionModal" value= readonly>

            </div>
            @foreach ($agendaDefFiltrados as $agenda)
      <form method="POST" action="{{ route('agenda-def.update-observacion', $agenda->id) }}">
        @endforeach
            @csrf
            @method('PUT')
              <div class="modal-column third modal-column-comandos">
                <label for="Comandos">Comandos</label>
                <div class="comandos-buttons">
                  <button class="comando-btn" data-id="{{ $agenda->id }}"  >
                    <span class="tooltip-text">Guardar Cambios</span>

                    <i class="fa fa-save"></i>
                  </button>

                  <button class="comando-btn" onclick="cerrarModal()">
                    <span class="tooltip-text">Cerrar</span>

                    <i class="fa fa-arrow-left"></i></button>
                </div>
                
              </div>
            </div>
        </div>
        
        



        <div class="modal-section">
          <div class="modal-row">
            <div class="modal-column third">
              <label for="transportista">Transportista</label>
              <input type="text" name="transportista" id="transportista" value="" >

            </div>
            <div class="modal-column third">
              <label for="instalador">Instalador</label>
              <input type="text" id="instalador" name="instalador" value="@isset($nombreUsuario){{ $nombreUsuario }}@endisset" readonly>
          </div>
          

            <div class="modal-column third">
             
            </div>
          </div>
        
          
            
          </div>

  
          
          <div class="modal-row">

            <div class="modal-observations">
              <div class="textarea-container">
                <label for="observaciones1">Observación </label>
                <textarea name="observacion_bloque" id="observaciones1"></textarea>
            </div>
            
          

              <div class="textarea-container">
                <label for="observaciones2">Nota Resumida</label>
                <textarea id="observaciones3" name="nota_resumida2 " maxlength="60"> </textarea>
              </div>
            </div>

          </form>
          </div>
          








    <div class="modal-section1">
      <div class="modal-status">
        <label for="observaciones">Estado  de la Instalacion</label>

        <div class="status-indicators">
          <div class="status-indicators">
            <div class="status-indicator">
              <input type="checkbox" id="confirmedCheckbox" name="status" value="confirmed" {{ $agenda->estado === 'Calendarizado' ? 'checked' : '' }} disabled>
                <label for="confirmedCheckbox">
                <div class="indicator-color confirmed"></div>
                <div class="indicator-text">Despacho Confirmado</div>
              </label>
            </div>
            
            <div class="status-indicator">
              <input type="checkbox" id="pendingCheckbox" name="status" value="pending"  {{ $agenda->estado === 'En espera' ? 'checked' : '' }} disabled>
              <label for="pendingCheckbox">
                <div class="indicator-color pending"></div>
                <div class="indicator-text">Por Confirmar</div>
              </label>
            </div>
            
            <div class="status-indicator">
              <input type="checkbox" id="postSaleCheckbox" name="status" value="post-sale" disabled>
              <label for="postSaleCheckbox">
                <div class="indicator-color post-sale"></div>
                <div class="indicator-text">Post Venta</div>
              </label>
            </div>
          </div>
        </div>
        
      </div>
    </div>


        
    
</div>
</div>    