// =====================================================
// CALENDARIO.JS - Versión Consolidada y Optimizada
// =====================================================

// =====================================================
// FUNCIONES AUXILIARES
// =====================================================

function extraerBloque(cadenaCompleta) {
    if (!cadenaCompleta) return null;
    
    // Si viene "BLOQUE A-1 (08:00-10:00)", extraer "A-1"
    var match = cadenaCompleta.match(/BLOQUE ([A-Z]-\d+)/i);
    if (match) {
        return match[1]; // Devuelve "A-1"
    }
    
    // Si viene "bloque-a-1" o similar
    match = cadenaCompleta.match(/bloque-([a-z])-(\d+)/i);
    if (match) {
        return match[1].toUpperCase() + '-' + match[2]; // Devuelve "A-1"
    }
    
    return null;
}
var bloqueCompleto = document.getElementById('horaBloque')?.value;
console.log('🔍 Bloque completo:', bloqueCompleto);
var bloque = extraerBloque(bloqueCompleto);
console.log('🔍 Bloque extraído:', bloque);

function abrirModal() {
    document.getElementById("miModal").style.display = "flex";
}

function cerrarModal() {
    document.getElementById("miModal").style.display = "none";
}

function cerrarModalConfirmacionPersonalizado() {
    document.getElementById('modalConfirmacionPersonalizado').style.visibility = 'hidden';
}

function cerrarModalConfirmacionPersonalizado1() {
    document.getElementById('modalConfirmacionPersonalizado1').style.visibility = 'hidden';
}

function abrirModalConfirmacionPersonalizado() {
    document.getElementById('modalConfirmacionPersonalizado').style.visibility = 'visible';
}

function abrirModalConfirmacionPersonalizado1() {
    document.getElementById('modalConfirmacionPersonalizado1').style.visibility = 'visible';
}

function abrirModalSeleccionDias() {
    document.getElementById('modalSeleccionDias').style.display = 'flex';
}

function cerrarModalSeleccionDias() {
    if (event) event.preventDefault();
    document.getElementById('modalSeleccionDias').style.display = 'none';
}
function abrirModalSeleccionDias1() {
    document.getElementById('modalSeleccionDias1').style.display = 'flex';
}

function cerrarModalSeleccionDias1() {
    if (event) event.preventDefault();
    document.getElementById('modalSeleccionDias1').style.display = 'none';
}

function confirmacionYAbrirModalSeleccionDias() {
    cerrarModalConfirmacionPersonalizado();
    abrirModalSeleccionDias();
}

function confirmacionYAbrirModalSeleccionDias1() {
    cerrarModalConfirmacionPersonalizado1();
    
    // ✅ GUARDAR VALORES DEL MODAL CON MANEJO DE NULOS
    var transportistaElement = document.getElementById('transportista');
    
    window.datosModalTemp = {
        notaVenta: document.getElementById('notaVenta').value,
        transportista: transportistaElement ? (transportistaElement.value || null) : null,  // ✅ Manejo seguro
        fechaEntrega: document.getElementById('fechaEntregaModal').value,
        observacionBloque: document.getElementById('observaciones1').value || null,
        observacionBloque2: document.getElementById('observaciones3').value || null,
        observacionBloque3: document.getElementById('observaciones2').value || null,
        estado: document.querySelector('input[name="estado"]:checked')?.value || 'Calendarizado'
    };
    
    console.log('💾 Datos guardados temporalmente:', window.datosModalTemp);
    
    abrirModalSeleccionDias1();
}

// =====================================================
// VARIABLES GLOBALES PARA CALENDARIOS
// =====================================================

// Calendario principal (modalSeleccionDias)
let fechaActual = new Date();
let mesActual = fechaActual.getMonth();
let añoActual = fechaActual.getFullYear();
let fechasSeleccionadasGlobalmente = [];

// Calendario 1 (modalSeleccionDias1)
let fechaActual1 = new Date();
let mesActual1 = fechaActual1.getMonth();
let añoActual1 = fechaActual1.getFullYear();
let fechasSeleccionadasGlobalmente1 = [];

// Mapeo de bloques
var bloqueDescripcion = {
    'bloque-a-1': 'BLOQUE A-1 (08:00-10:00)',
    'bloque-a-2': 'BLOQUE A-2 (10:00-12:00)',
    'bloque-a-3': 'BLOQUE A-3 (12:00-14:00)',
    'bloque-a-4': 'BLOQUE A-4 (14:00-16:00)',
    'bloque-a-5': 'BLOQUE A-5 (16:00-18:00)',
    'bloque-a-6': 'BLOQUE A-6 (18:00-20:00)',
    'bloque-a-7': 'BLOQUE A-7 (20:00-22:00)',
    'bloque-a-8': 'BLOQUE A-8 (22:00-24:00)',
    'bloque-a-confirmar': 'POR CONFIRMAR'
};

// =====================================================
// FUNCIONES DE GUARDADO
// =====================================================

function enviarFormularioPersonalizado() {
    cerrarModalConfirmacionPersonalizado();
    
    // Obtener valores DEL MODAL (no del header)
    var notaVenta = document.getElementById('notaVenta')?.value;
    var transportista = document.getElementById('transportista')?.value || null;
    var bloqueCompleto = document.getElementById('horaBloque')?.value;
    var bloque = extraerBloque(bloqueCompleto);
    var fechaEntrega = document.getElementById('fechaEntregaModal')?.value;
    var instalador = document.getElementById('instalador')?.value;
    var notaResumida = document.getElementById('observaciones2')?.value;
    var observacionBloque = document.getElementById('observaciones1')?.value;
    var estadoCheckbox = document.querySelector('input[name="estado"]:checked');
    var estado = estadoCheckbox ? estadoCheckbox.value : '';
    var notaResumida2 = document.getElementById('observaciones3')?.value;
    var fechaInstalacion = document.getElementById('fechaInstalacionModal')?.value;
    
    if (!notaVenta) { 
    Swal.fire({ icon: 'error', title: 'Error', text: 'No se encontró la Nota de Venta' });
    return; 
}
if (!bloque) { 
    Swal.fire({ icon: 'error', title: 'Error', text: 'Por favor seleccione un Bloque' });
    return; 
}
if (!instalador) { 
    Swal.fire({ icon: 'error', title: 'Error', text: 'Por favor seleccione un Instalador' });
    return; 
}
if (!fechaInstalacion) { 
    Swal.fire({ icon: 'error', title: 'Error', text: 'Por favor seleccione la Fecha de Instalación' });
    return; 
}
if (!estado) { 
    Swal.fire({ icon: 'error', title: 'Error', text: 'Por favor seleccione un Estado' });
    return; 
}

    var datosParaEnviar = {
        nota_venta: notaVenta,
        transportista: transportista,
        bloque: bloque,
        fecha_entrega: fechaEntrega,
        instalador: instalador,
        nota_resumida: notaResumida,
        observacion_bloque: observacionBloque,
        estado: estado,
        nota_resumida2: notaResumida2,
        fecha_instalacion2: fechaInstalacion
    };

    console.log('📤 Enviando datos:', datosParaEnviar);

    var guardarBtn = document.getElementById('guardarBtn');
    var iconoGuardar = document.getElementById('iconoGuardar');
    if (guardarBtn) {
        guardarBtn.disabled = true;
        if (iconoGuardar) iconoGuardar.className = 'fa fa-spinner fa-spin';
    }

    fetch('/agenda-def/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(datosParaEnviar)
    })
    .then(response => response.json())
   .then(data => {
    if (data.success) {
         Swal.fire({
            icon: 'success',
            title: '¡Guardado!',
            text: 'Registro guardado exitosamente',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.reload();
        });
    } else {

         Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.message || 'Error desconocido'
        });
    }
})
.catch(error => {
    console.error('❌ Error:', error);

     Swal.fire({
        icon: 'error',
        title: 'Error al guardar',
        text: error.message
    });
})
.finally(() => {
    // Rehabilitar botón solo si no hubo éxito
    var guardarBtn = document.getElementById('guardarBtn');
    var iconoGuardar = document.getElementById('iconoGuardar');
    if (guardarBtn && !document.hidden) {
        guardarBtn.disabled = false;
        if (iconoGuardar) iconoGuardar.className = 'fa fa-save';
    }
});
}
function enviarDatos() {
    cerrarModalConfirmacionPersonalizado1();

    var notaVenta = document.getElementById('notaVenta').value;
    var transportista = document.getElementById('transportista')?.value || null;

    var fechaEntrega = document.getElementById('fechaEntregaModal').value;
    var observacionBloque = document.getElementById('observaciones1').value;
    var observacionBloque2 = document.getElementById('observaciones3').value;
    var observacionBloque3 = document.getElementById('observaciones2').value;
    var fechaInstalacion = document.getElementById('fechaInstalacionModal').value;
    var estadoCheckbox = document.querySelector('input[name="estado"]:checked');
    var estado = estadoCheckbox ? estadoCheckbox.value : 'Calendarizado';
    console.log('🔍 Estado seleccionado:', estado);

    var instaladoresSeleccionados = document.querySelectorAll('.instaladores-container input[type="checkbox"]:checked');
    var bloquesSeleccionados = document.querySelectorAll('.bloques-container input[type="checkbox"]:checked');

    var datosParaEnviar = [];
    instaladoresSeleccionados.forEach(function(instalador) {
        bloquesSeleccionados.forEach(function(bloque) {
            var bloqueId = bloque.getAttribute('data-id');
            datosParaEnviar.push({
                nota_venta: notaVenta,
                transportista: transportista,
                bloque: bloqueId,
                fecha_entrega: fechaEntrega,
                instalador: instalador.value,
                observacion_bloque: observacionBloque,
                nota_resumida2: observacionBloque2,
                nota_resumida: observacionBloque3,
                fecha_instalacion2: fechaInstalacion,
                estado: estado
            });
        });
    });

    Swal.fire({
        title: 'Guardando...',
        text: 'Por favor espere',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('/agenda-def/ruta-para-guardar-multiple', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(datosParaEnviar)
    })
    .then(response => response.json())
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Registros guardados correctamente',
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(() => {
            window.location.reload();
        });
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron guardar los registros',
            confirmButtonColor: '#3085d6'
        });
    });
}

function guardarCambios() {
    console.log('🎯 Función guardarCambios() ejecutada');
    
    cerrarModalSeleccionDias();
    
    var fechasSeleccionadas = document.getElementById('fechasSeleccionadas').value;
    console.log('📅 Fechas del input:', fechasSeleccionadas);
    
    if (!fechasSeleccionadas || fechasSeleccionadas.trim() === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Por favor seleccione al menos una fecha',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    var notaVenta = document.getElementById('notaVenta')?.value;
    var transportista = document.getElementById('transportista')?.value || null;
    var bloqueCompleto = document.getElementById('horaBloque')?.value;
    
    if (!notaVenta || !bloqueCompleto) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Faltan datos del formulario',
            confirmButtonColor: '#3085d6'
        });
        return;
    }
    
    var bloque = extraerBloque(bloqueCompleto);
    var fechaEntrega = document.getElementById('fechaEntregaModal')?.value;
    var instalador = document.getElementById('instalador')?.value;
    var notaResumida = document.getElementById('observaciones2')?.value;
    var observacionBloque = document.getElementById('observaciones1')?.value;
    var estadoCheckbox = document.querySelector('input[name="estado"]:checked');
    var estado = estadoCheckbox ? estadoCheckbox.value : 'Calendarizado';
    var notaResumida2 = document.getElementById('observaciones3')?.value;
    
    // ✅ OBTENER FECHA ACTUAL DEL HEADER (la que está seleccionada)
    var fechaActualHeader = document.getElementById('fechaInstalacion2')?.value;
    console.log('📅 Fecha actual del header:', fechaActualHeader);
    
    // ✅ COMBINAR: Fecha actual + Fechas nuevas seleccionadas
    var fechasArray = fechasSeleccionadas.split(',').map(f => f.trim());
    
    // Si la fecha actual no está en las seleccionadas, agregarla
    if (fechaActualHeader && !fechasArray.includes(fechaActualHeader)) {
        fechasArray.unshift(fechaActualHeader); // Agregar al inicio
        console.log('✅ Fecha actual agregada:', fechaActualHeader);
    }
    
    var fechasCombinadas = fechasArray.join(', ');
    console.log('📅 Fechas combinadas:', fechasCombinadas);

    var datosParaEnviar = {
        nota_venta: notaVenta,
        transportista: transportista,
        bloque: bloque,
        fecha_entrega: fechaEntrega,
        instalador: instalador,
        nota_resumida: notaResumida,
        observacion_bloque: observacionBloque,
        estado: estado,
        nota_resumida2: notaResumida2,
        fechas: fechasCombinadas // ✅ Enviar fechas combinadas
    };

    console.log('📤 Enviando datos:', datosParaEnviar);

    // Mostrar loading mientras se guarda
    Swal.fire({
        title: 'Guardando...',
        text: 'Por favor espere',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('/guardar-agenda', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(datosParaEnviar)
    })
    .then(response => {
        console.log('📥 Status:', response.status);
        return response.text().then(text => {
            console.log('📄 Respuesta completa:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('❌ No es JSON válido');
                throw new Error('El servidor devolvió HTML. Revisa los logs.');
            }
        });
    })
    .then(data => {
        console.log('✅ Datos guardados:', data);
        
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: `Registros guardados para ${fechasArray.length} fecha${fechasArray.length > 1 ? 's' : ''}`,
            timer: 2500,
timerProgressBar: true,
showConfirmButton: false,
allowOutsideClick: false,
allowEscapeKey: false
        }).then(() => {
            window.location.reload();
        });
    })
    .catch(error => {
        console.error('❌ Error:', error);
        
        Swal.fire({
            icon: 'error',
            title: 'Error al guardar',
            text: error.message,
            confirmButtonColor: '#d33'
        });
    });
}


function guardarCambios1() {
    console.log('🎯 Función guardarCambios1() ejecutada (asignación múltiple)');
    
    var fechasSeleccionadas = document.getElementById('fechasSeleccionadas1').value;
    console.log('📅 Fechas del input:', fechasSeleccionadas);
    
    if (!fechasSeleccionadas || fechasSeleccionadas.trim() === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Por favor seleccione al menos una fecha',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    // ✅ USAR VALORES GUARDADOS TEMPORALMENTE
    if (!window.datosModalTemp) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se encontraron los datos del modal',
            confirmButtonColor: '#d33'
        });
        console.error('window.datosModalTemp no existe');
        return;
    }

    var notaVenta = window.datosModalTemp.notaVenta;
    var transportista = window.datosModalTemp.transportista;
    var fechaEntrega = window.datosModalTemp.fechaEntrega;
    var observacionBloque = window.datosModalTemp.observacionBloque;
    var observacionBloque2 = window.datosModalTemp.observacionBloque2;
    var observacionBloque3 = window.datosModalTemp.observacionBloque3;
    var estado = window.datosModalTemp.estado;

    console.log('📦 Usando datos temporales:', window.datosModalTemp);

    var instaladoresSeleccionados = document.querySelectorAll('.instaladores-container input[type="checkbox"]:checked');
    var bloquesSeleccionados = document.querySelectorAll('.bloques-container input[type="checkbox"]:checked');
    var fechasArray = fechasSeleccionadas.split(',').map(f => f.trim());

    var datosParaEnviar = [];
    instaladoresSeleccionados.forEach(function(instalador) {
        bloquesSeleccionados.forEach(function(bloque) {
            var bloqueId = bloque.getAttribute('data-id');
            datosParaEnviar.push({
                nota_venta: notaVenta,
                transportista: transportista || null,
                bloque: bloqueId,
                fecha_entrega: fechaEntrega,
                instalador: instalador.value,
                observacion_bloque: observacionBloque,
                nota_resumida2: observacionBloque2,
                nota_resumida: observacionBloque3,
                fechas: fechasArray,
                estado: estado
            });
        });
    });

    console.log('📤 Enviando datos múltiples:', datosParaEnviar);

    // Mostrar loading
    Swal.fire({
        title: 'Guardando...',
        text: 'Procesando múltiples asignaciones',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('/guardar-agenda2', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify(datosParaEnviar)
    })
    .then(response => {
        console.log('📥 Respuesta recibida:', response.status);
        if (!response.ok) {
            throw new Error('Error en la respuesta: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('✅ Datos guardados:', data);
        
        // ✅ CERRAR MODAL DESPUÉS DE GUARDAR EXITOSAMENTE
        cerrarModalSeleccionDias1();
        
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: `Registros guardados para todas las combinaciones (${fechasArray.length} fecha${fechasArray.length > 1 ? 's' : ''})`,
            timer: 2500,
timerProgressBar: true,
showConfirmButton: false,
allowOutsideClick: false,
allowEscapeKey: false
        }).then(() => {
            // ✅ LIMPIAR DATOS TEMPORALES
            delete window.datosModalTemp;
            window.location.reload();
        });
    })
    .catch(error => {
        console.error('❌ Error:', error);
        
        Swal.fire({
            icon: 'error',
            title: 'Error al guardar',
            text: error.message,
            confirmButtonColor: '#d33'
        });
        
        cerrarModalSeleccionDias1();
    });
}

// =====================================================
// EVENT LISTENERS - DOM CONTENT LOADED (UN SOLO BLOQUE)
// =====================================================

document.addEventListener('DOMContentLoaded', function() {
    
    console.log('✅ Calendario.js cargado');
    
    // =================================================
    // CONFIGURACIÓN INICIAL
    // =================================================
    
    // Actualizar checkbox según bloque
    function actualizarCheckbox() {
        var valorBloque = document.getElementById('horaBloque')?.value;
        var checkbox = document.getElementById('pendingCheckbox');
        if (checkbox) {
            checkbox.checked = (valorBloque === 'POR CONFIRMAR');
        }
    }
    
    var horaBloque = document.getElementById('horaBloque');
    if (horaBloque) {
        actualizarCheckbox();
        horaBloque.addEventListener('change', actualizarCheckbox);
    }
    
    // =================================================
    // EVENT LISTENERS EN DATA-BLOCKS (CONSOLIDADO)
    // =================================================
    
    var dataBlocks = document.querySelectorAll('.data-block');
    console.log('📊 Data blocks encontrados:', dataBlocks.length);
    
    dataBlocks.forEach(function(block) {
        block.addEventListener('click', function() {
            
            // Evitar clicks en bloques bloqueados
            if (this.classList.contains('data-block-bloqueado')) {
                return;
            }
            
            console.log('🖱️ Click en:', this.id);
            
            // ============================================
            // PASO 1: CARGAR DATOS DEL HEADER AL MODAL
            // ============================================
            
            // Nota de Venta
            var notaVentaHeader = document.getElementById('notaVentaNum');
            var notaVentaModal = document.getElementById('notaVenta');
            if (notaVentaHeader && notaVentaModal) {
                notaVentaModal.value = notaVentaHeader.value || '';
                console.log('✅ Nota Venta:', notaVentaHeader.value);
            }
            
            // Cliente
            var clienteHeader = document.getElementById('clienteNombre');
            var clienteModal = document.getElementById('cliente');
            if (clienteHeader && clienteModal) {
                clienteModal.value = clienteHeader.value || '';
                console.log('✅ Cliente:', clienteHeader.value);
            }
            
            // Descripción
            var descripcionHeader = document.getElementById('descripcion');
            var descripcionModal = document.getElementById('descripcionModal');
            if (descripcionHeader && descripcionModal) {
                descripcionModal.value = descripcionHeader.value || '';
                console.log('✅ Descripción:', descripcionHeader.value);
            }
            
            // Fecha Instalación
            var fechaHeader = document.getElementById('fechaInstalacion2');
            var fechaModal = document.getElementById('fechaInstalacionModal');
          if (fechaHeader && fechaModal) {
    var fechaValue = fechaHeader.value || '';
    // Si tiene formato datetime, extraer solo la fecha
    if (fechaValue.includes(' ')) {
        fechaValue = fechaValue.split(' ')[0];
    }
    fechaModal.value = fechaValue;
}
            
            // ============================================
            // PASO 2: EXTRAER Y CARGAR BLOQUE
            // ============================================
            // El ID es "bloque-a-2-3", necesitamos "bloque-a-2"
var partes = block.id.split('-'); // ["bloque", "a", "2", "3"]
var bloqueId = partes[0] + '-' + partes[1] + '-' + partes[2]; // "bloque-a-2"
            var descripcion = bloqueDescripcion[bloqueId];
            var modalHoraBloque = document.getElementById('horaBloque');
            
            if (modalHoraBloque && descripcion) {
                modalHoraBloque.innerHTML = '';
                
                // Agregar opción seleccionada
                var defaultOption = new Option(descripcion, bloqueId, true, true);
                modalHoraBloque.add(defaultOption);
                
                // Agregar otras opciones
                Object.keys(bloqueDescripcion).forEach(function(clave) {
                    if (clave !== bloqueId && clave !== 'bloque-confirmar') {
                        var option = new Option(bloqueDescripcion[clave], clave);
                        modalHoraBloque.add(option);
                    }
                });
                
                console.log('✅ Bloque:', descripcion);
            }
            
            // Guardar bloque antiguo
            var bloqueAntiguo = document.getElementById('bloqueAntiguo');
            if (bloqueAntiguo) {
                bloqueAntiguo.value = bloqueId;
            }
            
            // ============================================
            // PASO 3: EXTRAER Y CARGAR INSTALADOR
            // ============================================
            
          var headerItems = document.querySelectorAll('thead th');
var columnIndex = Array.prototype.indexOf.call(block.parentNode.children, block);
var instaladorNombre = '';

if (columnIndex > 0 && headerItems[columnIndex]) {
    instaladorNombre = headerItems[columnIndex].textContent.trim();
}
            
            var modalInstalador = document.getElementById('instalador');
            if (modalInstalador && instaladorNombre) {
                modalInstalador.innerHTML = '';
                
                // Agregar opción seleccionada
                var defaultOption = new Option(instaladorNombre, instaladorNombre, true, true);
                modalInstalador.add(defaultOption);
                
                // Agregar otras opciones
                var opcionesFijas = ['DIEGO', 'FRANCO', 'GABRIEL', 'JONATHAN', 'VOLANTE', 'ILESA', 'BODEGA', 'POR CONFIRMAR'];
                opcionesFijas.forEach(function(opcion) {
                    if (opcion !== instaladorNombre) {
                        var option = new Option(opcion, opcion);
                        modalInstalador.add(option);
                    }
                });
                
                console.log('✅ Instalador:', instaladorNombre);
            }
            
            // Guardar instalador antiguo
            var instaladorAntiguo = document.getElementById('instaladorAntiguo');
            if (instaladorAntiguo) {
                instaladorAntiguo.value = instaladorNombre;
            }
            
            // ============================================
            // PASO 4: ABRIR MODAL
            // ============================================
            
            abrirModal();
            
            // ============================================
            // PASO 5: CARGAR DATOS ADICIONALES VIA API
            // ============================================
            
            var bloqueIdModificado = bloqueId.split('-')[1].charAt(0) + '-' + bloqueId.split('-')[1].slice(1);
            bloqueIdModificado = bloqueIdModificado.toUpperCase();
            var fechaSeleccionada = fechaHeader ? fechaHeader.value : '';
            
            // Transportista
            fetch('/ruta-para-obtener-transportista2', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ bloque: bloqueIdModificado, instalador: instaladorNombre, fecha_instalacion2: fechaSeleccionada })
            })
            .then(response => response.json())
            .then(data => {
                if (data.transportista) {
                    document.getElementById('transportista').value = data.transportista;
                }
            });
            
            // Nota Resumida
            fetch('/ruta-para-obtener-nota-resumida', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ bloque: bloqueIdModificado, instalador: instaladorNombre, fecha_instalacion2: fechaSeleccionada })
            })
            .then(response => response.json())
            .then(data => {
                if (data.notaResumida) {
                    document.getElementById('observaciones2').value = data.notaResumida;
                }
            });
            
            // Nota Resumida 2
            fetch('/ruta-para-obtener-nota', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ bloque: bloqueIdModificado, instalador: instaladorNombre, fecha_instalacion2: fechaSeleccionada })
            })
            .then(response => response.json())
            .then(data => {
                if (data.nota_resumida2) {
                    document.getElementById('observaciones3').value = data.nota_resumida2;
                }
            });
            
            // Observaciones
            fetch('/ruta-para-obtener-observacion2', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ bloque: bloqueIdModificado, instalador: instaladorNombre, fecha_instalacion2: fechaSeleccionada })
            })
            .then(response => response.json())
            .then(data => {
                if (data.observacionBloque) {
                    document.getElementById('observaciones1').value = data.observacionBloque;
                }
            });
            
            // Estado
            fetch('/ruta-para-obtener-estado', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ bloque: bloqueIdModificado, instalador: instaladorNombre, fecha_instalacion2: fechaSeleccionada })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('confirmedCheckbox').checked = false;
                document.getElementById('postSaleCheckbox').checked = false;
                document.getElementById('pendingCheckbox').checked = false;
                switch (data.estado) {
    case 'Calendarizado':
        document.getElementById('confirmedCheckbox').checked = true;
        break;
    case 'Post-Venta':
        document.getElementById('postSaleCheckbox').checked = true;
        break;
    case 'En espera':
        document.getElementById('pendingCheckbox').checked = true;
        break;
    case 'Completar Campo':
    case '':
    case null:
        // No marcar ninguno
        console.log('⚠️ Sin estado definido');
        break;
    default:
        console.log('⚠️ Estado desconocido:', data.estado);
}
                
   
            });
        });
    });
    
    // =================================================
    // CALENDARIOS (modalSeleccionDias)
    // =================================================
    
   

    

    


    var btnPrev = document.querySelector('.miModalSeleccionDias-controls button:nth-child(1)');
    var btnNext = document.querySelector('.miModalSeleccionDias-controls button:nth-child(3)');
    if (btnPrev) btnPrev.addEventListener('click', function() { cambiarMes(-1); });
    if (btnNext) btnNext.addEventListener('click', function() { cambiarMes(1); });

    
   generarCalendario(mesActual, añoActual)

   

   

   

   

    var btnPrev1 = document.querySelector('#modalSeleccionDias1 .miModalSeleccionDias-controls button:nth-child(1)');
    var btnNext1 = document.querySelector('#modalSeleccionDias1 .miModalSeleccionDias-controls button:nth-child(3)');
    if (btnPrev1) btnPrev1.addEventListener('click', function() { cambiarMes1(-1); });
    if (btnNext1) btnNext1.addEventListener('click', function() { cambiarMes1(1); });

    generarCalendario1(mesActual1, añoActual1);
    
    // =================================================
    // ASIGNACIÓN MÚLTIPLE
    // =================================================
    
    var asignacionSi = document.getElementById('asignacion_si');
    var asignacionNo = document.getElementById('asignacion_no');
    var checkboxes = document.querySelectorAll('.bloques-container input[type="checkbox"], .instaladores-container input[type="checkbox"]');
    var botonMultiple = document.getElementById('botonmultiple');
    
    if (checkboxes.length > 0) {
        checkboxes.forEach(function(checkbox) {
            checkbox.disabled = true;
        });
    }
    if (botonMultiple) botonMultiple.disabled = true;
    if (asignacionNo) asignacionNo.checked = true;
    
    if (asignacionSi) {
        asignacionSi.addEventListener('change', function() {
            if (this.checked) {
                checkboxes.forEach(function(checkbox) {
                    checkbox.disabled = false;
                });
                if (botonMultiple) botonMultiple.disabled = false;
                
                // Marcar checkboxes basado en selección actual
                var instaladorInput = document.getElementById('instalador');
                var bloqueSelect = document.getElementById('horaBloque');
                
                if (instaladorInput && bloqueSelect) {
                    var instaladorSeleccionado = instaladorInput.value.trim();
                    var bloqueSeleccionado = bloqueSelect.options[bloqueSelect.selectedIndex].text.trim();
                    
                    var checkboxesInstaladores = document.querySelectorAll('.instaladores-container input[type="checkbox"]');
                    var checkboxesBloques = document.querySelectorAll('.bloques-container input[type="checkbox"]');
                    
                    checkboxesInstaladores.forEach(function(checkbox) {
                        checkbox.checked = (checkbox.value === instaladorSeleccionado);
                    });
                    checkboxesBloques.forEach(function(checkbox) {
                        checkbox.checked = (checkbox.value === bloqueSeleccionado);
                    });
                }
            }
        });
    }
    
    if (asignacionNo) {
        asignacionNo.addEventListener('change', function() {
            if (this.checked) {
                checkboxes.forEach(function(checkbox) {
                    checkbox.disabled = true;
                });
                if (botonMultiple) botonMultiple.disabled = true;
            }
        });
    }
    
    // =================================================
    // STATUS CHECKBOXES (mutuamente exclusivos)
    // =================================================
    
    const statusCheckboxes = document.querySelectorAll('.status-checkbox');
    statusCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                statusCheckboxes.forEach(box => {
                    if (box !== checkbox) box.checked = false;
                });
            }
        });
    });
    
    // =================================================
    // BOTONES
    // =================================================
    
    var guardarBtn = document.getElementById('guardarBtn');
    if (guardarBtn) {
        guardarBtn.addEventListener('click', function(event) {
            event.preventDefault();
            cerrarModal();
            abrirModalConfirmacionPersonalizado();
        });
    }
    
    var botonEliminar = document.getElementById('botonEliminar');
    if (botonEliminar) {
        botonEliminar.addEventListener('click', function() {
            var notaVenta = document.getElementById('notaVenta').value;
            var instalador = document.getElementById('instalador').value;
            var bloqueCompleto = document.getElementById('horaBloque').value;
            var bloque = extraerBloque(bloqueCompleto);

           Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción eliminará el requerimiento",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/agenda-def/eliminar', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ nota_venta: notaVenta, instalador: instalador, bloque: bloque })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: 'El requerimiento ha sido eliminado',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo eliminar el requerimiento'
                    });
                });
            }
        });
    
        });
    }
    
   var botonEditar = document.getElementById('botoneditar');
if (botonEditar) {
    botonEditar.addEventListener('click', function() {
        var notaVenta = document.getElementById('notaVenta').value;
        var transportista = document.getElementById('transportista').value;
        var bloqueAntiguo = extraerBloque(document.getElementById('bloqueAntiguo').value);
        var bloqueNuevo = extraerBloque(document.getElementById('horaBloque').value);
        var fechaEntrega = document.getElementById('fechaEntregaModal').value;
        var notaResumida = document.getElementById('observaciones2').value;
        var observacionBloque = document.getElementById('observaciones1').value;
        var estadoCheckbox = document.querySelector('input[name="estado"]:checked');
        var estado = estadoCheckbox ? estadoCheckbox.value : '';
        var notaResumida2 = document.getElementById('observaciones3').value;
        var fechaInstalacionAntigua = document.getElementById('fechaInstalacion2').value;
        var fechaInstalacionNueva = document.getElementById('fechaInstalacionModal').value;
        var instaladorAntiguo = document.getElementById('instaladorAntiguo').value;
        var instaladorNuevo = document.getElementById('instalador').value;

        var dataToSend = {
            nota_venta: notaVenta,
            transportista: transportista,
            bloque_antiguo: bloqueAntiguo,
            bloque_nuevo: bloqueNuevo,
            fecha_entrega: fechaEntrega,
            nota_resumida: notaResumida,
            observacion_bloque: observacionBloque,
            estado: estado,
            nota_resumida2: notaResumida2,
            fecha_instalacion_antigua: fechaInstalacionAntigua,
            fecha_instalacion_nueva: fechaInstalacionNueva,
            instalador_antiguo: instaladorAntiguo,
            instalador_nuevo: instaladorNuevo
        };

        // ✅ REEMPLAZAR confirm() POR SWAL
        Swal.fire({
            title: '¿Editar requerimiento?',
            text: "Se actualizarán los datos del requerimiento",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, editar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar loading
                Swal.fire({
                    title: 'Actualizando...',
                    text: 'Por favor espere',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('/agenda-def/ruta-de-actualizacion', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(dataToSend)
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        return response.text().then(text => { throw new Error(text) });
                    }
                })
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: 'El requerimiento ha sido actualizado',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo actualizar el requerimiento'
                    });
                });
            }
        });
    });
}
    
    if (botonMultiple && asignacionSi) {
        botonMultiple.addEventListener('click', function(event) {
            var estadoCheckbox = document.querySelector('input[name="estado"]:checked');
            var estado = estadoCheckbox ? estadoCheckbox.value : '';

            if (!estado) {
                Swal.fire({
        icon: 'warning',
        title: 'Estado requerido',
        text: 'Por favor, marque una opción de estado'
    });
                return;
            }

            var instaladoresSeleccionados = document.querySelectorAll('.instaladores-container input[type="checkbox"]:checked');
            var bloquesSeleccionados = document.querySelectorAll('.bloques-container input[type="checkbox"]:checked');

            if (instaladoresSeleccionados.length === 1 && bloquesSeleccionados.length === 1) {
                 Swal.fire({
        icon: 'info',
        title: 'Más alternativas',
        text: 'Por favor, marque más alternativas para asignación múltiple'
    });
                return;
            }

            event.preventDefault();
            cerrarModal();
            abrirModalConfirmacionPersonalizado1();
        });
    }
    
    // =================================================
    // CERRAR MODAL AL HACER CLICK FUERA
    // =================================================
    
    window.onclick = function(event) {
        var modal = document.getElementById('miModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
    
    console.log('✅ Todos los event listeners configurados');
});



// =====================================================
// EXPONER FUNCIONES GLOBALES PARA LOS MODALES
// =====================================================

window.generarCalendario = function(mes, año) {
    const contenedor = document.getElementById('calendarioContainer');
    if (!contenedor) return;
    
    contenedor.innerHTML = "";
    let primerDiaMes = new Date(año, mes, 1);
    let ultimoDiaMes = new Date(año, mes + 1, 0);
    
    const mesAnio = document.getElementById('mesAnio');
    if (mesAnio) {
        mesAnio.textContent = primerDiaMes.toLocaleString('es-ES', { month: 'long', year: 'numeric' });
    }

    let calendario = document.createElement('div');
    calendario.id = 'calendario';

    for (let dia = 1; dia <= ultimoDiaMes.getDate(); dia++) {
        let fechaCompleta = `${año}-${String(mes + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
        let celdaDia = document.createElement('div');
        celdaDia.classList.add('dia');
        celdaDia.innerText = dia;
        celdaDia.dataset.fecha = fechaCompleta;

        if (fechasSeleccionadasGlobalmente.includes(fechaCompleta)) {
            celdaDia.classList.add('seleccionado');
        }

        celdaDia.addEventListener('click', function() {
            this.classList.toggle('seleccionado');
            manejarSeleccionFecha(fechaCompleta);
        });

        calendario.appendChild(celdaDia);
    }

    contenedor.appendChild(calendario);
};

window.generarCalendario1 = function(mes, año) {
    const contenedor = document.getElementById('calendarioContainer1');
    if (!contenedor) return;
    
    contenedor.innerHTML = "";
    let primerDiaMes = new Date(año, mes, 1);
    let ultimoDiaMes = new Date(año, mes + 1, 0);

    const mesAnio = document.getElementById('mesAnio1');
    if (mesAnio) {
        mesAnio.textContent = primerDiaMes.toLocaleString('es-ES', { month: 'long', year: 'numeric' });
    }

    let calendario = document.createElement('div');
    calendario.id = 'calendario1';

    for (let dia = 1; dia <= ultimoDiaMes.getDate(); dia++) {
        let fechaCompleta = `${año}-${String(mes + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
        let celdaDia = document.createElement('div');
        celdaDia.classList.add('dia');
        celdaDia.innerText = dia;
        celdaDia.dataset.fecha = fechaCompleta;

        if (fechasSeleccionadasGlobalmente1.includes(fechaCompleta)) {
            celdaDia.classList.add('seleccionado');
        }

        celdaDia.addEventListener('click', function() {
            this.classList.toggle('seleccionado');
            manejarSeleccionFecha1(fechaCompleta);
        });

        calendario.appendChild(celdaDia);
    }

    contenedor.appendChild(calendario);
};

window.manejarSeleccionFecha = function(fecha) {
    const indice = fechasSeleccionadasGlobalmente.indexOf(fecha);
    if (indice > -1) {
        fechasSeleccionadasGlobalmente.splice(indice, 1);
    } else {
        fechasSeleccionadasGlobalmente.push(fecha);
    }
    actualizarFechasSeleccionadas();
};

window.manejarSeleccionFecha1 = function(fecha) {
    const indice = fechasSeleccionadasGlobalmente1.indexOf(fecha);
    if (indice > -1) {
        fechasSeleccionadasGlobalmente1.splice(indice, 1);
    } else {
        fechasSeleccionadasGlobalmente1.push(fecha);
    }
    actualizarFechasSeleccionadas1();
};

window.actualizarFechasSeleccionadas = function() {
    var elem = document.getElementById('fechasSeleccionadas');
    if (elem) {
        elem.value = fechasSeleccionadasGlobalmente.join(', ');
    }
};

window.actualizarFechasSeleccionadas1 = function() {
    var elem = document.getElementById('fechasSeleccionadas1');
    if (elem) {
        elem.value = fechasSeleccionadasGlobalmente1.join(', ');
    }
};

window.cambiarMes = function(direccion) {
    mesActual += direccion;
    if (mesActual < 0) {
        mesActual = 11;
        añoActual -= 1;
    } else if (mesActual > 11) {
        mesActual = 0;
        añoActual += 1;
    }
    window.generarCalendario(mesActual, añoActual);
};

window.cambiarMes1 = function(direccion) {
    mesActual1 += direccion;
    if (mesActual1 < 0) {
        mesActual1 = 11;
        añoActual1 -= 1;
    } else if (mesActual1 > 11) {
        mesActual1 = 0;
        añoActual1 += 1;
    }
    window.generarCalendario1(mesActual1, añoActual1);
};

console.log('✅ Funciones de calendario expuestas globalmente');