
<div class="modal" id="miModal">
    
        
    <div class="modal-content">
        <span class="close-button" onclick="cerrarModal()">&times;</span>
    
            <div class="modal-header">
            <div class="modal-title">
                <h2>LECTURA AGENDA DESPACHOS</h2>
                <div class="datos">
                    <span>Fecha: <strong>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</strong></span>
                    <span>Usuario: <strong>{{ session('usuario') ? session('usuario')->NOMBRE : 'Usuario no autenticado' }}</strong></span>
                    </div>
            </div>
    
            
            <div class="modal-meta">
                
                <div class="datos2">
                    <form id="miFormulario" method="POST" action="{{ route('agenda_def.store3') }}">
                    @csrf
                    <button class="comando-btn"></i></button>
                    <button type="button" id="guardarBtn" class="comando-btn tooltip-container">
                        <span class="tooltip-text" id="tooltipText">Guardar Requerimiento</span>
                        <i class="fa fa-save" id="iconoGuardar"></i>
                    </button>
                    

                <button type="button" id="botonEliminar" class="comando-btn" class="tooltip-container">
                    <span class="tooltip-text">Eliminar Requerimiento</span>
                    <i class="fas fa-trash"></i> 
                </button>

                <button type="button" id="botoneditar" class="comando-btn" class="tooltip-container">
                    <span class="tooltip-text">Editar Requerimiento</span>
                    <i class="fas fa-pencil-alt"></i> 
                </button>
                
                

                
              

                </div>
            </div>
            
            </div>
            
        



        <div class="modal-body">
        
            <div class="form-row">
                <div class="form-field third-width">
                    <label for="horaBloque">Hora/Bloque</label>
                    <select name="bloque" id="horaBloque">
                        <option value="" selected></option>
                    </select>
                </div>


                <input type="hidden" id="bloqueAntiguo" name="bloque_antiguo">

                
                <div class="form-field third-width">
                    <label for="instalador">Bodega</label>
                    <select name="instalador" id="instalador">
                      
                        <option value="" selected></option>
                    </select>
                </div>

                <input type="hidden" id="instaladorAntiguo" name="instalador_antiguo">


            <div class="form-field third-width input-icon-container">
                <label for="notaVenta">Nota Venta</label>
                <input type="text" id="notaVenta" name="nota_venta" placeholder="N°">
                <i class="fas fa-binoculars"></i> 
            </div>

            
            <div class="form-field half-width">
                <label for="fechaEntrega">Fecha Entrega</label>
                <input type="text" name="fecha_entrega" id="fechaEntregaModal" value="{{ $fechaEntrega ?? 'No definido' }}">
            </div>
          

            </div>
        
            <div class="form-row">
            
                <div class="form-field half-width">
                    <label for="fechaInstalacionModal">Fecha Despacho</label>
                    <input type="date" id="fechaInstalacionModal" name="fecha_instalacion2">
                </div>

        
            <div class="form-field third-width">
                <label for="transportista">Transportista</label>
                <input type="text" name="transportista" id="transportista" value="" >
            </div>
            
                


          
                <div class="form-field third-width">
                    <label for="descripcion">Descripción</label>
                    <input type="text"  id="descripcionModal">
                </div>
           

            <div class="form-field third-width">
                <label for="cliente">Cliente</label>
                <input type="text" name="cliente" id="cliente">
            </div>

            <div class="linea-vertical"></div>

            
            
        </div>

            



            

        </div>
        
        
        
        <div class="modal-row">
            <div class="modal-observations">
                <div class="textarea-container">
                    <label for="observacionesExtra">Nota Resumida (Visible en Agenda)</label>
                    <textarea id="observaciones3" name="nota_resumida2" maxlength="60"></textarea>
            
                    <label for="observaciones2">Nota Resumida </label>
                    <textarea id="observaciones2" name="nota_resumida"></textarea>
                </div>
                
                <div class="textarea-container">
                    <label for="observaciones1">Observaciones Instaladores</label>
                    <textarea id="observaciones1" name="observacion_bloque" readonly>{{ $observacion ?? 'No definido' }}</textarea>
                </div>
            </div>
            
        </div>
        
        
        


        <div class="modal-section1">

            <div class="modal-status">
                <label for="observaciones">Estado  del Despacho</label>

                <div class="status-indicators">
                    <div class="status-indicator">
                        <input type="checkbox" class="status-checkbox" id="confirmedCheckbox" name="estado" value="Calendarizado">
                        <label for="confirmedCheckbox">
                            <div class="indicator-color confirmed"></div>
                            <div class="indicator-text">Despacho Confirmado</div>
                        </label>
                    </div>
                   <!--
                    <div class="status-indicator">
                        <input type="checkbox" class="status-checkbox" id="postSaleCheckbox" name="estado" value="Post-Venta">
                        <label for="postSaleCheckbox">
                            <div class="indicator-color post-sale"></div>
                            <div class="indicator-text">Post Venta</div>
                        </label>
                    </div>
                    -->

                    <div class="status-indicator">
                        <input type="checkbox" class="status-checkbox" id="pendingCheckbox" name="estado" value="En espera">
                        <label for="pendingCheckbox">
                            <div class="indicator-color pending"></div>
                            <div class="indicator-text">Por Confirmar</div>
                        </label>
                    </div>
                </div>
                
            </div>

            </form>
        </div>

            
                <div class="bloques">
                    <h3 class="bloques-title1">Bloques</h3>
                    <div class="asignacion-multiple">
                    <span>Asignación múltiple</span>
                    <label><input type="radio" name="asignacion_multiple" value="si" id="asignacion_si"> Sí</label>
                    <label><input type="radio" name="asignacion_multiple" value="no" id="asignacion_no"> No</label>
                    </div>
                    
                    <div class="bloques-container">
                         <label><input type="checkbox" name="bloque" value="BLOQUE A-1 (8:00-10:00)" data-id="A-1">BLOQUE A-1(08-10)</label>
                        <label><input type="checkbox" name="bloque" value="BLOQUE A-2 (10:00-12:00)" data-id="A-2" > BLOQUE A-2(10-12)</label>
                        <label><input type="checkbox" name="bloque" value="BLOQUE A-3 (12:00-14:00)" data-id="A-3" > BLOQUE A-3(12-14)</label>
                        <label><input type="checkbox" name="bloque" value="BLOQUE A-4 (14:00-16:00)" data-id="A-4"> BLOQUE A-4(14-16) </label>
                        <label><input type="checkbox" name="bloque" value="BLOQUE A-5 (16:00-18:00)" data-id="A-5"> BLOQUE A-5(16-18)</label>
                        <label><input type="checkbox" name="bloque" value="BLOQUE A-6 (18:00-20:00)" data-id="A-6"> BLOQUE A-6(18-20)</label>
                        <label><input type="checkbox" name="bloque" value="BLOQUE A-7 (20:00-22:00)" data-id="A-7"> BLOQUE A-7(20-22)</label>
                        <label><input type="checkbox" name="bloque" value="BLOQUE A-8 (22:00-24:00)" data-id="A-8"> BLOQUE A-8(22-24)</label>
                    </div>
                </div>

                <div class="instaladores">
                <h3 class="bloques-title">Bodegas</h3>
                <div class="instaladores-container">
                        <label><input type="checkbox" name="instalador" value="KHEMNOVA"> KHEMNOVA</label>
                        <label><input type="checkbox" name="instalador" value="STORETEK"> STORETEK</label>
                        <label><input type="checkbox" name="instalador" value="SAN JOAQUIN"> SAN JOAQUIN</label>
                       

                </div>
                </div>
            
            </div>









</div>
    