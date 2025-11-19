

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

document.querySelectorAll('.data-block').forEach(item => {
    item.addEventListener('click', abrirModal);
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
                document.getElementById('pendingCheckbox').checked = false;
            
                switch (data.estado) {
                    case 'Calendarizado':
                        document.getElementById('confirmedCheckbox').checked = true;
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
document.getElementById('guardarBtn').addEventListener('click', function() {
    var formData = new FormData(document.getElementById('miFormulario'));

    var bloqueSelect = document.getElementById('horaBloque');
    if (bloqueSelect && bloqueSelect.value) {
        var bloqueId = bloqueSelect.value.split('-')[1];
        var bloqueFormateado = bloqueId.charAt(0) + '-' + bloqueId.slice(1);
        formData.set('bloque', bloqueFormateado.toUpperCase());
    }

    var bloqueAntiguo = document.getElementById('bloqueAntiguo').value;
    if (bloqueAntiguo) {
        var bloqueAntiguoFormateado = bloqueAntiguo.split('-')[1];
        if (bloqueAntiguoFormateado) {
            var bloqueAntiguoFormateadoFinal = bloqueAntiguoFormateado.charAt(0) + '-' + bloqueAntiguoFormateado.slice(1);
            formData.set('bloque_antiguo', bloqueAntiguoFormateadoFinal.toUpperCase());
        }
    }

    var estadoCheckbox = document.querySelector('.status-indicators input[type="checkbox"]:checked');
    if (estadoCheckbox) {
        formData.set('estado', estadoCheckbox.value);
    }

    var object = {};
    formData.forEach(function(value, key) {
        object[key] = value;
    });
    var json = JSON.stringify(object);

    fetch('/agenda-def/store3', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: json
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
});








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

function mostrarInformacion(fechaSeleccionada) {
    var elementos = document.querySelectorAll('.item-info');

    elementos.forEach(function(elemento) {
        var fechaInstalacion = elemento.getAttribute('data-fecha-instalacion2');

        if (fechaInstalacion === fechaSeleccionada) {
            elemento.style.display = 'block';
        } else {
            elemento.style.display = 'none';
        }
    });
}

mostrarInformacion(document.getElementById('fechaInstalacion2').value);



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
            var headerItems = document.querySelectorAll('.schedule-header .header-item');

            var columnIndex = Array.prototype.indexOf.call(block.parentNode.children, block);

            var instaladorNombre = columnIndex > 0 ? headerItems[columnIndex].textContent.trim() : '';

            var modalInstalador = document.getElementById('instalador');
            modalInstalador.innerHTML = ''; 

            var defaultOption = new Option(instaladorNombre, instaladorNombre, true, true);
            modalInstalador.add(defaultOption);

            var opcionesFijas = ['KHEMNOVA','SAN JOAQUIN','STORETEK', 'POR CONFIRMAR'];
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
  
    checkboxes.forEach(function(checkbox) {
      checkbox.disabled = true;
    });
  
    asignacionSi.addEventListener('change', function() {
      if (this.checked) {
        checkboxes.forEach(function(checkbox) {
          checkbox.disabled = false;
        });
      }
    });
  
    asignacionNo.addEventListener('change', function() {
      if (this.checked) {
        checkboxes.forEach(function(checkbox) {
          checkbox.disabled = true;
        });
      }
    });
  });
  
  document.addEventListener('DOMContentLoaded', function() {
    var asignacionSi = document.getElementById('asignacion_si');
    var asignacionNo = document.getElementById('asignacion_no');
    var botonGuardar = document.getElementById('guardarBtn');
    var textoTooltip = document.getElementById('tooltipText');
    var iconoGuardar = document.getElementById('iconoGuardar');
    

    asignacionSi.addEventListener('change', function() {
        if (this.checked) {
            botonGuardar.id = 'guardarBtnMultiple';
            textoTooltip.textContent = 'Guardar Requerimientos Múltiples';
            iconoGuardar.className = 'fa fa-tasks';
           
            document.getElementById('guardarBtnMultiple').addEventListener('click', function(event) {
                event.preventDefault(); 
            
                var notaVenta = document.getElementById('notaVenta').value;
                var transportista = document.getElementById('transportista').value;
                var fechaEntrega = document.getElementById('fechaEntregaModal').value;
                var observacionBloque = document.getElementById('observaciones1').value;
                var observacionBloque2 = document.getElementById('observaciones3').value;
                var estadoCheckbox = document.querySelector('input[name="estado"]:checked');
                var observacionBloque3 = document.getElementById('observaciones2').value;

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
                            nota_resumida2:observacionBloque2 ,
                            nota_resumida:observacionBloque3,

                            estado:estado
                        });
                    });
                });
                console.log(datosParaEnviar);
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
            });
            

        }
    });

    asignacionNo.addEventListener('change', function() {
        if (this.checked) {
            botonGuardar.id = 'guardarBtn';
            textoTooltip.textContent = 'Guardar Requerimiento';
            iconoGuardar.className = 'fa fa-save';

            var notaResumida = document.getElementById('observaciones2').value;

            

    fetch('/actualizar-nota-resumida', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            bloque: bloqueIdModificado,
            instalador: instaladorNombre,
            nota_venta: notaVenta,
            nota_resumida: notaResumida,
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Nota resumida actualizada con éxito');
        } else {
            console.log('Error al actualizar la nota resumida');
        }
    });
        }
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

    // Agregar confirmación antes de enviar la solicitud
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



