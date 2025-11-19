<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ asset('css/calendario-dia.css') }}" rel="stylesheet">
        <link rel="icon" href="{{ asset('imagenes/descarga.png') }}" type="image/png">

        <link href="https://clientes.ohffice.cl/css/coreui.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>
    
  
<body>


  <div class="container">
    <div class="main-title">
      Calendario Instalaciones Diario

      <div class="date-and-button">
        <div id="current-date" class="current-date"></div>

    
        <button id="next-day-button" class="next-day-button">
            <i class="fas fa-arrow-right"></i>
        </button>

        <button id="prev-day-button" class="prev-day-button">
            <i class="fas fa-arrow-left"></i>
        </button>
        <a href="{{ route('calendariosemana') }}">
            <button id="week-button" class="week-button"> Por Semana</button>
        </a>


        <a href="{{ route('calendario') }}" class="back-button" title="Volver">
            <i class="fas fa-home"></i>
            <span class="tooltip-text">Volver al Inicio</span>
        </a>
        
    </div>
    
    </div>
  </div>
  
  
    


      
        


       



  
        
      

        <div class="schedule-container">
          <div class="schedule-header">

            <div class="header-item  ">BLOQUE</div>
            <div class="header-item" >DIEGO</div>
            <div class="header-item">FRANCO</div>
            <div class="header-item">GABRIEL</div>
            <div class="header-item">JONATHAN</div>
            <div class="header-item">VOLANTE</div>
            <div class="header-item">ILESA</div>
            <div class="header-item">BODEGA</div>
            <div class="header-item  ">KHEMNOVA</div>
            <div class="header-item ">SAN JOAQUIN</div>
            <div class="header-item  ">STORETEK</div>


          </div>
   
          @foreach ($bloques as $bloque)
          <div class="schedule-row">
              <div class="time-block">  {{ $bloquesHorarios[$bloque] }}</div>
              @foreach ($instaladores as $index => $instalador)
                  @php  
                      $itemsEnBloque = $agendaItems->filter(function ($item) use ($instalador, $bloque) {
                          return $item->bloque == $bloque && $item->instalador == $instalador;
                      });
                  @endphp
                  <div class="data-block" id="bloque-{{ strtolower($bloque) }}-{{ $index + 1 }}">
                      @foreach ($itemsEnBloque as $item)
                          @php
                              $clasesEstado = [
                                  'Calendarizado' => 'estado-calendarizado',
                                  'En espera' => 'estado-en-espera',
                                  'Post-Venta' => 'estado-post-venta'
                              ];
                              $claseEstado = $clasesEstado[$item->estado] ?? 'alguna-clase-default';
                          @endphp
                          <div class="{{ $claseEstado }}">
                            <div class="item-info" data-fecha-instalacion2="{{ $item->fecha_instalacion2 }}" data-nota-venta="{{ $item->nota_venta }}" data-instalador="{{ $instalador }}" data-bloque="{{ $bloque }}" data-descripcion="{{ $item->calendarioDef->descripcion }}" data-transportista="{{ $item->transportista }}" data-observacion="{{ $item->observacion_bloque }}" data-nota-resumida="{{ $item->nota_resumida }}" data-estado="{{ $item->estado }}" data-original-bloque="{{ $bloque }}" data-original-instalador="{{ $instalador }}">
                              NV:{{ $item->nota_venta }}<br>
                              Cliente:{{ $item->calendarioDef->cliente }}
                              @if (!in_array($instalador, ['STORETEK', 'KHEMNOVA', 'SAN JOAQUIN']))
                                <div class="edit-icon-container">
                                    <i class="fas fa-pencil-alt"></i>
                                </div>
                            @endif
                          </div>
                          
                          
                          
                          </div>
                      @endforeach
                  </div>
              @endforeach
          </div>
      @endforeach
      
      

        </div>
      



    
        <div class="modal" id="miModal">
            <div class="modal-content">
                <span class="close-button" onclick="cerrarModal()"></span>
                <div class="modal-header">
                    <div class="modal-title">
                        <h2>LECTURA AGENDA INSTALACIONES</h2>
                    </div>
                    <div class="modal-meta">
                        <span>Fecha: <strong>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</strong></span>
                        <span>Usuario: <strong>{{ session('usuario') ? session('usuario')->NOMBRE : 'Usuario no autenticado' }}</strong></span>
                    </div>
                    <div class="edit-icon-modal">
                      <i class="fas fa-pencil-alt" ></i>
                  </div>
                  
                  
                </div>

                <div class="modal-body">
                    <div class="form-row">
                      <div class="form-field third-width">
                        <label for="notaVenta">Nota Venta</label>
                        <input type="text" id="notaVenta" placeholder="N°" readonly >
                      </div> 
                      <div class="form-field third-width">
                        <label for="descripcion">Descripción</label>
                        <input type="text" id="descripcionModal"  readonly>
                      </div>
                      <div class="form-field third-width">
                        <label for="fechaEntrega">Fecha Entrega</label>
                        <input type="date" id="fechaEntregaModal" readonly>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-field third-width">
                        <label for="transportista">Transportista</label>
                        <input type="text" id="transportista">
                      </div>
                      <div class="form-field third-width">
                        <label for="instalador">Instalador</label>
                        <select id="instalador" class="form-control">
                            <option value="DIEGO">DIEGO</option>
                            <option value="JONATHAN">JONATHAN</option>
                            <option value="FRANCO">FRANCO</option>
                            <option value="VOLANTE">VOLANTE</option>
                            <option value="BODEGA">BODEGA</option>
                            <option value="ILESA">ILESA</option>
                            <option value="GABRIEL">GABRIEL</option>

                        </select>
                    </div>
                    <div class="form-field third-width">
                      <label for="horaBloque">Hora/Bloque</label>
                      <select name="bloque" id="horaBloque" class="form-control">
                          <option value="A-1">A-1</option>
                          <option value="A-2">A-2</option>
                          <option value="A-3">A-3</option>
                          <option value="A-4">A-4</option>
                          <option value="A-5">A-5</option>
                          <option value="A-6">A-6</option>
                          <option value="A-7">A-7</option>
                          <option value="A-8">A-8</option>
                      </select>
                  </div>
                    </div>
                    <div class="form-row">

                      <div class="form-field half-width">
                        <label for="observaciones2">Nota Resumida</label>
                        <textarea id="observaciones3" maxlength="60"></textarea>
                      </div>
                      <div class="form-field half-width">
                        <label for="observaciones1">Observación</label>
                        <textarea id="observaciones1" readonly></textarea>
                    </div>
                     
                    </div>
                  </div>



                
                  
                  <div class="modal-section1">
                    <div class="modal-status">
                        <label for="observaciones">Estado de la Instalación</label>
                        <div class="status-indicators">
                            <div class="status-indicator">
                                <input type="checkbox" id="confirmedCheckbox" name="status" value="Calendarizado" >
                                <label for="confirmedCheckbox">
                                    <div class="indicator-color confirmed"></div>
                                    <div class="indicator-text">Despacho Confirmado</div>
                                </label>
                            </div>
                            <div class="status-indicator">
                                <input type="checkbox" id="pendingCheckbox" name="status" value="En espera" >
                                <label for="pendingCheckbox">
                                    <div class="indicator-color pending"></div>
                                    <div class="indicator-text">Por Confirmar</div>
                                </label>
                            </div>
                            <div class="status-indicator">
                                <input type="checkbox" id="postSaleCheckbox" name="status" value="Post-Venta" >
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


<script>
  $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
  });
</script>    

<script src="/js/calendario-dia.js"></script>


  
</body>
</html>








