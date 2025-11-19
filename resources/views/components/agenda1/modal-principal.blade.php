
<div class="modal" id="miModal">
    
        
    <div class="modal-content">
        <span class="close-button" onclick="cerrarModal()">&times;</span>
    
            <div class="modal-header">
            <div class="modal-title">
                <h2>LECTURA AGENDA INSTALACIONES</h2>
                <div class="datos">
                <span>Fecha: <strong>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</strong></span>
                <span>Usuario: <strong>{{ session('usuario') ? session('usuario')->NOMBRE : 'Usuario no autenticado' }}</strong></span>
                </div>

                
            </div>
           

            <div id="selectedDates"></div>
            
            
            <div class="modal-meta">
               <div class="datos2">
                <form id="miFormulario" method="POST" action="{{ route('agenda_def.store') }}">
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

            <button type="button" id="botonmultiple" class="comando-btn tooltip-container">
                <span class="tooltip-text">Guardar Múltiple</span>
                <i class="fa fa-tasks"></i>
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

        


             
                <div class="form-field third-width input-icon-container">
                    <label for="transportista">Nombre del Transporte</label>
                    <input type="text" name="transportista" id="transportista" value="{{ $transportista ?? 'No definido' }}">
                    <span class="icon-button" data-toggle="modal" data-target="#modalTransporteNuevo">
                        <i class="fas fa-binoculars"></i>
                    </span>
                </div>
                
                
                



            <div class="form-field third-width input-icon-container">
                <label for="notaVenta">Nota Venta</label>
                <input type="text" id="notaVenta" name="nota_venta" placeholder="N°">
            </div>
            <div class="form-field third-width">
                <label for="descripcion">Descripción</label>
                <input type="text"  id="descripcionModal">
            </div>

           
           

            </div>
        
            <div class="form-row">

                <div class="form-field third-width">
                    <label for="instalador">Instalador</label>
                    <select name="instalador" id="instalador">
                      
                        <option value="" selected></option>
                    </select>
                </div>

                <input type="hidden" id="instaladorAntiguo" name="instalador_antiguo">

          

            <div class="form-field half-width">
                <label for="fechaInstalacionModal">Fecha Instalación</label>
                <input type="date" id="fechaInstalacionModal">
            </div>
            
            <div class="form-field half-width">
                <label for="fechaEntrega">Fecha Entrega</label>
                <input type="text" name="fecha_entrega" id="fechaEntregaModal" value="{{ $calendarioDef->fecha_fabril ?? 'No definido' }}">
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
                <label for="observaciones">Estado  de la Instalacion</label>

                <div class="status-indicators">
                    <div class="status-indicator">
                        <input type="checkbox" class="status-checkbox" id="confirmedCheckbox" name="estado" value="Calendarizado">
                        <label for="confirmedCheckbox">
                            <div class="indicator-color confirmed"></div>
                            <div class="indicator-text">Despacho Confirmado</div>
                        </label>
                    </div>
                    <div class="status-indicator">
                        <input type="checkbox" class="status-checkbox" id="postSaleCheckbox" name="estado" value="Post-Venta">
                        <label for="postSaleCheckbox">
                            <div class="indicator-color post-sale"></div>
                            <div class="indicator-text">Post Venta</div>
                        </label>
                    </div>
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
                <h3 class="bloques-title">Instaladores</h3>
                <div class="instaladores-container">
                        <label><input type="checkbox" name="instalador" value="DIEGO"> DIEGO</label>
                        <label><input type="checkbox" name="instalador" value="FRANCO"> FRANCO</label>
                        <label><input type="checkbox" name="instalador" value="GABRIEL"> GABRIEL</label>
                        <label><input type="checkbox" name="instalador" value="JONATHAN">JONATHAN </label>
                        <label><input type="checkbox" name="instalador" value="ILESA"> ILESA</label>
                        <label><input type="checkbox" name="instalador" value="BODEGA"> BODEGA</label>
                        <label><input type="checkbox" name="instalador" value="VOLANTE">VOLANTE </label>
                

                </div>
                </div>

             
            </div>



</div>

<div class="modal fade" id="modalTransporteNuevo" tabindex="-1" role="dialog" aria-labelledby="modalTransporteNuevoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header-transporte-nuevo">
                <h5 class="modal-title" id="modalTransporteNuevoLabel">Datos de Transporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body-transporte-nuevo">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="campo1Nuevo">Despacha</label>
                        <input type="text" class="form-control" id="campo1Nuevo">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="campo2Nuevo">Recibe</label>
                        <input type="text" class="form-control" id="campo2Nuevo">
                    </div>
                </div>



                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="campo3Nuevo">Patente</label>
                        <input type="text" class="form-control" id="campo3Nuevo">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="campo4Nuevo">Nombre Conductor</label>
                        <input type="text" class="form-control" id="campo4Nuevo">
                    </div>
                </div>


                <div class="form-row">


                    <div class="form-group col-md-6">
                        <label for="campo7Nuevo">Numero Celular</label>
                        <input type="number" class="form-control" id="campo7Nuevo">
                    </div>
                   
                    <div class="form-group col-md-6">
                        <label for="campo6Nuevo">Rut </label>
                        <input type="text" class="form-control" id="campo6Nuevo">
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="acompanantes">Acompañantes </label>
                        <input type="text" class="form-control" id="acompanantes" name="acompanantes" placeholder="Acompañante 1, Acompañante 2, Acompañante 3">
                    </div>
                </div>
                

                
            </div>
            <div class="modal-footer-transporte-nuevo">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar cambios</button>
            </div>
            
        </div>
    </div>
</div>
