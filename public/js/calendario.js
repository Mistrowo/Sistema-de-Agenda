

    


document.addEventListener('DOMContentLoaded', function() {
    function actualizarCheckbox() {
        var valorBloque = document.getElementById('horaBloque').value;
        var checkbox = document.getElementById('pendingCheckbox');
        checkbox.checked = (valorBloque === 'POR CONFIRMAR');
    }

    actualizarCheckbox();

    document.getElementById('horaBloque').addEventListener('change', actualizarCheckbox);
});




function extraerBloque(cadenaCompleta) {
    var resultado = cadenaCompleta.match(/bloque-([a-z])(\d+)/i);
    if (resultado) {
        return resultado[1].toUpperCase() + '-' + resultado[2];
    }
    return null;
}


function abrirModal() {
    document.getElementById("miModal").style.display = "block";
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


function enviarFormularioPersonalizado() {
    cerrarModalConfirmacionPersonalizado(); 
    
    // Obtener valores
    var notaVenta = document.getElementById('notaVentaNum').value; // CAMBIADO: era 'notaVenta'
    var transportista = document.getElementById('transportista').value;
    var bloqueCompleto = document.getElementById('horaBloque').value;
    var bloque = extraerBloque(bloqueCompleto);
    var fechaEntrega = document.getElementById('fechaEntregaModal').value;
    var instalador = document.getElementById('instalador').value;
    var notaResumida = document.getElementById('observaciones2').value;
    var observacionBloque = document.getElementById('observaciones1').value;
    var estadoCheckbox = document.querySelector('input[name="estado"]:checked');
    var estado = estadoCheckbox ? estadoCheckbox.value : ''; 
    var notaResumida2 = document.getElementById('observaciones3').value;
    var fechaInstalacion = document.getElementById('fechaInstalacion2').value;
    
    // Validaciones
    if (!notaVenta) {
        alert('❌ Error: No se encontró la Nota de Venta');
        return;
    }
    
    if (!bloque) {
        alert('❌ Error: Por favor seleccione un Bloque');
        return;
    }
    
    if (!instalador) {
        alert('❌ Error: Por favor seleccione un Instalador');
        return;
    }
    
    if (!transportista) {
        alert('❌ Error: Por favor ingrese el Transportista');
        return;
    }
    
    if (!fechaInstalacion) {
        alert('❌ Error: Por favor seleccione la Fecha de Instalación');
        return;
    }
    
    if (!estado) {
        alert('❌ Error: Por favor seleccione un Estado');
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

    // Deshabilitar botón guardar temporalmente
    var guardarBtn = document.getElementById('guardarBtn');
    var iconoGuardar = document.getElementById('iconoGuardar');
    if (guardarBtn) {
        guardarBtn.disabled = true;
        if (iconoGuardar) {
            iconoGuardar.className = 'fa fa-spinner fa-spin';
        }
    }

    // Configura la solicitud Fetch
    fetch('/agenda-def/store', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 
        },
        body: JSON.stringify(datosParaEnviar)
    })
    .then(response => {
        console.log('📥 Respuesta recibida, status:', response.status);
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('✅ Respuesta del servidor:', data);
        if (data.success) {
            alert('✅ Registro guardado exitosamente');
            console.log("Datos guardados exitosamente", data);
            window.location.reload();
        } else {
            alert('❌ Error: ' + (data.message || 'Error desconocido'));
            // Rehabilitar botón
            if (guardarBtn) {
                guardarBtn.disabled = false;
                if (iconoGuardar) {
                    iconoGuardar.className = 'fa fa-save';
                }
            }
        }
    })
    .catch(error => {
        console.error('❌ Error completo:', error);
        alert('❌ Error al guardar el registro: ' + error.message);
        // Rehabilitar botón
        if (guardarBtn) {
            guardarBtn.disabled = false;
            if (iconoGuardar) {
                iconoGuardar.className = 'fa fa-save';
            }
        }
    });
}


function abrirModalSeleccionDias() {
    document.getElementById('modalSeleccionDias').style.display = 'flex'; 
}




function cerrarModalSeleccionDias() {
    event.preventDefault()
    document.getElementById('modalSeleccionDias').style.display = 'none';
}



function guardarCambios() {
    cerrarModalSeleccionDias();

    var notaVenta = document.getElementById('notaVenta').value;
    var transportista = document.getElementById('transportista').value;
    var bloqueCompleto = document.getElementById('horaBloque').value;
    var bloque = extraerBloque(bloqueCompleto);
    var fechaEntrega = document.getElementById('fechaEntregaModal').value;
    var instalador = document.getElementById('instalador').value;
    var notaResumida = document.getElementById('observaciones2').value;
    var observacionBloque = document.getElementById('observaciones1').value;
    var estadoCheckbox = document.querySelector('input[name="estado"]:checked');
    var estado = estadoCheckbox ? estadoCheckbox.value : ''; 
    var notaResumida2 = document.getElementById('observaciones3').value;
    var fechasSeleccionadas = document.getElementById('fechasSeleccionadas').value; 
    console.log(fechasSeleccionadas)

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
        fechas: fechasSeleccionadas 
    };

    fetch('/guardar-agenda', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 
        },
        body: JSON.stringify(datosParaEnviar)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
        console.log("Datos guardados exitosamente", data);
        window.location.reload();
    })
    .catch(error => console.error('Error:', error));
}



function confirmacionYAbrirModalSeleccionDias() {
    cerrarModalConfirmacionPersonalizado();
    
    abrirModalSeleccionDias();
}



function confirmacionYAbrirModalSeleccionDias1() {
    cerrarModalConfirmacionPersonalizado1();
    
    abrirModalSeleccionDias1();
}


function abrirModalSeleccionDias1() {
    console.log(document.getElementById('modalSeleccionDias1')); 
    document.getElementById('modalSeleccionDias1').style.display = 'flex'; 
}






function abrirModalConfirmacionPersonalizado1() {
    document.getElementById('modalConfirmacionPersonalizado1').style.visibility = 'visible'; 
}





function abrirModalConfirmacionPersonalizado() {
    document.getElementById('modalConfirmacionPersonalizado').style.visibility = 'visible'; 
}












function enviarDatos() {
    cerrarModalConfirmacionPersonalizado1();

    var notaVenta = document.getElementById('notaVenta').value;
    var transportista = document.getElementById('transportista').value;
    var fechaEntrega = document.getElementById('fechaEntregaModal').value;
    var observacionBloque = document.getElementById('observaciones1').value;
    var observacionBloque2 = document.getElementById('observaciones3').value;
    var estadoCheckbox = document.querySelector('input[name="estado"]:checked');
    var observacionBloque3 = document.getElementById('observaciones2').value;
    var fechaInstalacion = document.getElementById('fechaInstalacion2').value; 

    var estado = estadoCheckbox ? estadoCheckbox.value : ''; 

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

    console.log("Enviando datos...", datosParaEnviar);
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
        console.log("Datos recibidos:", data);
        window.location.reload();
    })
    .catch(error => console.error('Error:', error));
}






document.addEventListener('DOMContentLoaded', function() {
    let fechaActual = new Date();
    let mesActual = fechaActual.getMonth();
    let añoActual = fechaActual.getFullYear();
    let fechasSeleccionadasGlobalmente = []; 

    function generarCalendario(mes, año) {
        const contenedor = document.getElementById('calendarioContainer');
        contenedor.innerHTML = ""; 

        let primerDiaMes = new Date(año, mes, 1);
        let ultimoDiaMes = new Date(año, mes + 1, 0);
        
        const mesAnio = document.getElementById('mesAnio');
        mesAnio.textContent = primerDiaMes.toLocaleString('default', { month: 'long' }) + ' ' + año;

        let calendario = document.createElement('div');
        calendario.id = 'calendario';

        for (let dia = 1; dia <= ultimoDiaMes.getDate(); dia++) {
            let fechaCompleta = `${año}-${mes + 1}-${dia < 10 ? '0' + dia : dia}`;
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
    }

    function cambiarMes(direccion) {
        mesActual += direccion;
        
        if (mesActual < 0) {
            mesActual = 11;
            añoActual -= 1;
        } else if (mesActual > 11) {
            mesActual = 0;
            añoActual += 1;
        }
        
        generarCalendario(mesActual, añoActual);
    }

    function manejarSeleccionFecha(fecha) {
        const indice = fechasSeleccionadasGlobalmente.indexOf(fecha);
        if (indice > -1) {
            fechasSeleccionadasGlobalmente.splice(indice, 1);
        } else {
            fechasSeleccionadasGlobalmente.push(fecha);
        }
        actualizarFechasSeleccionadas(); 
    }

    function actualizarFechasSeleccionadas() {
        document.getElementById('fechasSeleccionadas').value = fechasSeleccionadasGlobalmente.join(', ');
    }

    document.querySelector('.miModalSeleccionDias-controls button:nth-child(1)').addEventListener('click', function() {
        cambiarMes(-1);
    });

    document.querySelector('.miModalSeleccionDias-controls button:nth-child(3)').addEventListener('click', function() {
        cambiarMes(1);
    });

    generarCalendario(mesActual, añoActual);
});


document.addEventListener('DOMContentLoaded', function() {
    let fechaActual1 = new Date();
    let mesActual1 = fechaActual1.getMonth();
    let añoActual1 = fechaActual1.getFullYear();
    let fechasSeleccionadasGlobalmente1 = [];

    function generarCalendario1(mes, año) {
        const contenedor = document.getElementById('calendarioContainer1');
        contenedor.innerHTML = "";

        let primerDiaMes = new Date(año, mes, 1);
        let ultimoDiaMes = new Date(año, mes + 1, 0);

        const mesAnio = document.getElementById('mesAnio1');
        mesAnio.textContent = primerDiaMes.toLocaleString('default', { month: 'long' }) + ' ' + año;

        let calendario = document.createElement('div');
        calendario.id = 'calendario1';

        for (let dia = 1; dia <= ultimoDiaMes.getDate(); dia++) {
            let fechaCompleta = `${año}-${mes + 1}-${dia < 10 ? '0' + dia : dia}`;
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
    }

    function cambiarMes1(direccion) {
        mesActual1 += direccion;

        if (mesActual1 < 0) {
            mesActual1 = 11;
            añoActual1 -= 1;
        } else if (mesActual1 > 11) {
            mesActual1 = 0;
            añoActual1 += 1;
        }

        generarCalendario1(mesActual1, añoActual1);
    }

    function manejarSeleccionFecha1(fecha) {
        const indice = fechasSeleccionadasGlobalmente1.indexOf(fecha);
        if (indice > -1) {
            fechasSeleccionadasGlobalmente1.splice(indice, 1);
        } else {
            fechasSeleccionadasGlobalmente1.push(fecha);
        }
        actualizarFechasSeleccionadas1();
    }

    function actualizarFechasSeleccionadas1() {
        document.getElementById('fechasSeleccionadas1').value = fechasSeleccionadasGlobalmente1.join(', ');
    }

    document.querySelector('#modalSeleccionDias1 .miModalSeleccionDias-controls button:nth-child(1)').addEventListener('click', function() {
        cambiarMes1(-1);
    });

    document.querySelector('#modalSeleccionDias1 .miModalSeleccionDias-controls button:nth-child(3)').addEventListener('click', function() {
        cambiarMes1(1);
    });

    generarCalendario1(mesActual1, añoActual1);
});



document.querySelectorAll('.data-block').forEach(item => {
    item.addEventListener('click', abrirModal);
});


document.addEventListener('DOMContentLoaded', function() {
    var dataBlocks = document.querySelectorAll('.data-block');

    dataBlocks.forEach(function(block) {
        block.addEventListener('click', function() {
            var bloqueId = block.id.split('-')[0] + '-' + block.id.split('-')[1];
            var descripcion = bloqueDescripcion[bloqueId]; 
            var modalInput = document.getElementById('horaBloque');
            modalInput.value = descripcion;
            var modal = document.getElementById('miModal');
            modal.style.display = 'block';
            console.log('bloqueId original:', bloqueId);

            var bloqueIdModificado = bloqueId.split('-')[1].charAt(0) + '-' + bloqueId.split('-')[1].slice(1);
            bloqueIdModificado = bloqueIdModificado.toUpperCase();
            console.log('bloqueId modificado:', bloqueIdModificado);
            var fechaSeleccionada = document.getElementById('fechaInstalacion2').value;


            var headerItems = document.querySelectorAll('.schedule-header .header-item');
            var columnIndex = Array.prototype.indexOf.call(block.parentNode.children, block);
            var instaladorNombre = columnIndex > 0 ? headerItems[columnIndex].textContent : '';

            fetch('/ruta-para-obtener-transportista2', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ bloque: bloqueIdModificado, instalador: instaladorNombre,fecha_instalacion2: fechaSeleccionada })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('transportista').value = data.transportista;

                fetch('/ruta-para-obtener-nota-resumida', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ bloque: bloqueIdModificado, instalador: instaladorNombre,fecha_instalacion2: fechaSeleccionada})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.notaResumida) {
                        document.getElementById('observaciones2').value = data.notaResumida;
                    }
                });
                fetch('/ruta-para-obtener-nota', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ bloque: bloqueIdModificado, instalador: instaladorNombre,fecha_instalacion2: fechaSeleccionada })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('observaciones3').value = data.nota_resumida2;
                });

                fetch('/ruta-para-obtener-observacion2', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ bloque: bloqueIdModificado, instalador: instaladorNombre,fecha_instalacion2: fechaSeleccionada})
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('observaciones1').value = data.observacionBloque;
                });
            });

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
                    default:
                        break;
                }
            });
            
        });
    });
});
var bloqueDescripcion = {
    'bloque-a1': 'BLOQUE A-1 (8:00-10:00)',
    'bloque-a2': 'BLOQUE A-2 (10:00-12:00)',
    'bloque-a3': 'BLOQUE A-3 (12:00-14:00)',
    'bloque-a4': 'BLOQUE A-4 (14:00-16:00)',
    'bloque-a5': 'BLOQUE A-5 (16:00-18:00)',
    'bloque-a6': 'BLOQUE A-6 (18:00-20:00)',
    'bloque-a7': 'BLOQUE A-7 (20:00-22:00)',
    'bloque-a8': 'BLOQUE A-8 (22:00-24:00)',
    'bloque-confirmar': 'POR CONFIRMAR'
};
document.addEventListener('DOMContentLoaded', function() {
    var dataBlocks = document.querySelectorAll('.data-block');

    dataBlocks.forEach(function(block) {
        block.addEventListener('click', function() {
            var bloqueValor = this.id.split('-')[1]; 

            var modalHoraBloque = document.getElementById('horaBloque');
            modalHoraBloque.innerHTML = ''; 

            var clavePorDefecto = 'bloque-' + bloqueValor;
            var defaultOption = new Option(bloqueDescripcion[clavePorDefecto], clavePorDefecto, true, true);
            modalHoraBloque.add(defaultOption);

            Object.keys(bloqueDescripcion).forEach(function(clave) {
                if (clave !== clavePorDefecto && clave !== 'bloque-confirmar') {
                    var option = new Option(bloqueDescripcion[clave], clave);
                    modalHoraBloque.add(option);
                }
            });

            var bloqueAntiguo = document.getElementById('bloqueAntiguo');
            bloqueAntiguo.value = clavePorDefecto; 

            var modal = document.getElementById('miModal');
            modal.style.display = 'block';
        });
    });
});



document.addEventListener('DOMContentLoaded', function() {
    var dataBlocks = document.querySelectorAll('.data-block');

    dataBlocks.forEach(function(block) {
        block.addEventListener('click', function() {
            
            var descripcion = document.getElementById('descripcion').value;
            var modalDescripcion = document.getElementById('descripcionModal');
            modalDescripcion.value = descripcion;

            var modal = document.getElementById('miModal');
            modal.style.display = 'block';
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    var dataBlocks = document.querySelectorAll('.data-block');

    dataBlocks.forEach(function(block) {
        block.addEventListener('click', function() {
            
            var descripcion = document.getElementById('notaVentaNum').value;
            var modalDescripcion = document.getElementById('notaVenta');
            modalDescripcion.value = descripcion;

            var modal = document.getElementById('miModal');
            modal.style.display = 'block';
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    var dataBlocks = document.querySelectorAll('.data-block');

    dataBlocks.forEach(function(block) {
        block.addEventListener('click', function() {
            
            var descripcion = document.getElementById('clienteNombre').value;
            var modalDescripcion = document.getElementById('cliente');
            modalDescripcion.value = descripcion;

            var modal = document.getElementById('miModal');
            modal.style.display = 'block';
        });
    });
});

window.onclick = function(event) {
    var modal = document.getElementById('miModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}


document.addEventListener('DOMContentLoaded', function() {
    var dataBlocks = document.querySelectorAll('.data-block');

    dataBlocks.forEach(function(block) {
        block.addEventListener('click', function() {
            var descripcion = document.getElementById('fechaInstalacion2').value; 
            var modalDescripcion = document.getElementById('fechaInstalacionModal');
            modalDescripcion.value = descripcion;

            var modal = document.getElementById('miModal');
            modal.style.display = 'block';
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var dataBlocks = document.querySelectorAll('.data-block');

    dataBlocks.forEach(function(block) {
        block.addEventListener('click', function() {
            var headerItems = document.querySelectorAll('.schedule-header .header-item');

            var columnIndex = Array.prototype.indexOf.call(block.parentNode.children, block);

            var instaladorNombre = columnIndex > 0 ? headerItems[columnIndex].textContent.trim() : '';

            var modalInstalador = document.getElementById('instalador');
            modalInstalador.innerHTML = ''; 

            var defaultOption = new Option(instaladorNombre, instaladorNombre, true, true);
            modalInstalador.add(defaultOption);

            var opcionesFijas = ['DIEGO', 'FRANCO', 'GABRIEL', 'JONATHAN', 'VOLANTE', 'ILESA', 'BODEGA', 'POR CONFIRMAR'];
            opcionesFijas.forEach(function(opcion) {
                if (opcion !== instaladorNombre) {
                    var option = new Option(opcion, opcion);
                    modalInstalador.add(option);
                }
            });

            var instaladorAntiguo = document.getElementById('instaladorAntiguo');
            instaladorAntiguo.value = instaladorNombre;

            var modal = document.getElementById('miModal');
            modal.style.display = 'block';
        });
    });
});




document.addEventListener('DOMContentLoaded', function() {
    var asignacionSi = document.getElementById('asignacion_si');
    var instaladorInput = document.getElementById('instalador');
    var bloqueSelect = document.getElementById('horaBloque');
   

    asignacionSi.addEventListener('change', function() {
        if (this.checked) {
            var instaladorSeleccionado = instaladorInput.value.trim();
            var bloqueSeleccionado = (bloqueSelect.options[bloqueSelect.selectedIndex].text.trim());
            var checkboxesInstaladores = document.querySelectorAll('.instaladores-container input[type="checkbox"]');
            var checkboxesBloques = document.querySelectorAll('.bloques-container input[type="checkbox"]');

            checkboxesInstaladores.forEach(function(checkbox) {
                checkbox.checked = (checkbox.value === instaladorSeleccionado);
            });
            checkboxesBloques.forEach(function(checkbox) {
                checkbox.checked = (checkbox.value === bloqueSeleccionado);
            });
        }
    });

    var dataBlocks = document.querySelectorAll('.data-block');

    dataBlocks.forEach(function(block) {
        block.addEventListener('click', function() {
        });
    });
});




document.addEventListener('DOMContentLoaded', function() {
    var asignacionSi = document.getElementById('asignacion_si');
    var asignacionNo = document.getElementById('asignacion_no');
    var checkboxes = document.querySelectorAll('.bloques-container input[type="checkbox"], .instaladores-container input[type="checkbox"]');
    var botonMultiple = document.getElementById('botonmultiple'); 
  
    checkboxes.forEach(function(checkbox) {
        checkbox.disabled = true;
    });
    botonMultiple.disabled = true;
  
 
    asignacionNo.checked = true;
  
    asignacionSi.addEventListener('change', function() {
        if (this.checked) {
            checkboxes.forEach(function(checkbox) {
                checkbox.disabled = false;
            });
            botonMultiple.disabled = false; 
        }
    });
  
    asignacionNo.addEventListener('change', function() {
        if (this.checked) {
            checkboxes.forEach(function(checkbox) {
                checkbox.disabled = true;
            });
            botonMultiple.disabled = true; 
        }
    });
});



document.getElementById('guardarBtn').addEventListener('click', function(event) {
    event.preventDefault(); 
    cerrarModal()
    abrirModalConfirmacionPersonalizado(); 
});

document.addEventListener('DOMContentLoaded', () => {
    const checkboxes = document.querySelectorAll('.status-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                checkboxes.forEach(box => {
                    if (box !== checkbox) box.checked = false;
                });
            }
        });
    });
});

  document.addEventListener('DOMContentLoaded', function() {

    var asignacionSi = document.getElementById('asignacion_si');
    var asignacionNo = document.getElementById('asignacion_no');
    asignacionSi.addEventListener('change', function() {
    
        if (this.checked) {

            document.getElementById('botonmultiple').addEventListener('click', function(event) {


               
                var estadoCheckbox = document.querySelector('input[name="estado"]:checked');

                var estado = estadoCheckbox ? estadoCheckbox.value : ''; 

               
                if (!estado) {
                    alert('Por favor, marque una opción de estado.');
                    return;
                   
                }

                var instaladoresSeleccionados = document.querySelectorAll('.instaladores-container input[type="checkbox"]:checked');
                var bloquesSeleccionados = document.querySelectorAll('.bloques-container input[type="checkbox"]:checked');


                if (instaladoresSeleccionados.length === 1 && bloquesSeleccionados.length === 1) {
                    alert('Por favor, marque más alternativas.');
                    return;
                   
                }

                event.preventDefault(); 
                cerrarModal()
                abrirModalConfirmacionPersonalizado1(); 
            });
            
  
           
        }

    });

    asignacionNo.addEventListener('change', function() {
      
      
    });
});



document.getElementById('botonEliminar').addEventListener('click', function() {
    var notaVenta = document.getElementById('notaVenta').value;
    var instalador = document.getElementById('instalador').value;
    var bloqueCompleto = document.getElementById('horaBloque').value;
    var bloque = extraerBloque(bloqueCompleto);

    console.log(notaVenta);
    console.log(instalador);
    console.log(bloque);

    var confirmacion = confirm("¿Estás seguro de eliminar el requerimiento?");
    if (confirmacion) {
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
            window.location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
});




document.getElementById('botoneditar').addEventListener('click', function() {
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

    console.log(instaladorAntiguo);
    console.log(instaladorNuevo);


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

    console.log("Datos a enviar:", dataToSend);

    var confirmacion = confirm("¿Deseas editar el requerimiento?");
    if (confirmacion) {
        fetch('/agenda-def/ruta-de-actualizacion', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(dataToSend)
        })
        .then(response => {
            console.log("Respuesta del servidor:", response);
            if(response.ok) {
                return response.json();
            } else {
                return response.text().then(text => { throw new Error(text) });
            }
        })
        .then(data => {
            console.log("Datos recibidos:", data);
            window.location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
});




document.querySelectorAll('.data-block').forEach(item => {
    item.addEventListener('click', function() {
        if (this.classList.contains('data-block-bloqueado')) {
            return;
        }

    });
});


function guardarCambios1() {
    cerrarModalSeleccionDias();

    var notaVenta = document.getElementById('notaVenta').value;
    var transportista = document.getElementById('transportista').value;
    var fechaEntrega = document.getElementById('fechaEntregaModal').value;
    var observacionBloque = document.getElementById('observaciones1').value;
    var observacionBloque2 = document.getElementById('observaciones3').value;
    var estadoCheckbox = document.querySelector('input[name="estado"]:checked');
    var observacionBloque3 = document.getElementById('observaciones2').value;
    var fechasSeleccionadas = document.getElementById('fechasSeleccionadas1').value.split(','); 

    var estado = estadoCheckbox ? estadoCheckbox.value : ''; 

    var instaladoresSeleccionados = document.querySelectorAll('.instaladores-container input[type="checkbox"]:checked');
    var bloquesSeleccionados = document.querySelectorAll('.bloques-container input[type="checkbox"]:checked');
    var fechasSeleccionadas = document.getElementById('fechasSeleccionadas1').value.split(','); 

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
                fechas: fechasSeleccionadas, 
                estado: estado
            });
        });
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
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log("Datos guardados exitosamente", data);
        window.location.reload();
    })
    .catch(error => console.error('Error:', error));
}
