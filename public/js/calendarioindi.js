



document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.data-block').forEach(item => {
        item.addEventListener('click', function() {
            if (this.querySelector('.estado-calendarizado') || this.querySelector('.estado-en-espera') || this.querySelector('.estado-post-venta')) {
                abrirModal();
            }
        });
    });
});

function abrirModal() {
    document.getElementById("miModal").style.display = "block";
}

function abrirModal() {
    document.getElementById("miModal").style.display = "block";
}

function cerrarModal() {
    document.getElementById("miModal").style.display = "none";
}




  
  function updateDateDisplay(hiddenInputId, displayInputId) {
    var selectedDate = document.getElementById(hiddenInputId).value;
    document.getElementById(displayInputId).value = selectedDate;
  }


  
  function openDatePicker(id) {
    var input = document.createElement('input');
    input.type = 'date';
    input.style.display = 'none';
    input.onchange = function() {
      document.getElementById(id + 'Display').value = this.value;
      document.body.removeChild(this);
    }
    document.body.appendChild(input);
    input.click();
  }
  

  





  var bloqueDescripcion = {
    'bloque-a1': 'BLOQUE A-1 (8:00-10:00)',
    'bloque-a2': 'BLOQUE A-2 (10:00-12:00)',
    'bloque-a3': 'BLOQUE A-3 (12:00-14:00)',
    'bloque-a4': 'BLOQUE A-4 (14:00-16:00)',
    'bloque-a5': 'BLOQUE A-5 (16:00-18:00)',
    'bloque-a6': 'BLOQUE A-6 (18:00-20:00)',
    'bloque-a7': 'BLOQUE A-7 (20:00-22:00)',
    'bloque-a8': 'BLOQUE A-8 (22:00-24:00)',
    
    
};



function cerrarModal() {
    document.getElementById("miModal").style.display = "none";
}


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

            var headerItems = document.querySelectorAll('.schedule-header .header-item');
            var columnIndex = Array.prototype.indexOf.call(block.parentNode.children, block);
            var instaladorNombre = columnIndex > 0 ? headerItems[columnIndex].textContent : '';
            console.log(instaladorNombre);

            var fechaSeleccionada = document.getElementById('fechaInstalacion2').value;

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
                document.getElementById('transportista').value = data.transportista;

                fetch('/ruta-para-obtener-nota-resumida2', {
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
                        document.getElementById('observaciones3').value = data.notaResumida;
                    }
                });

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
                     document.getElementById('observaciones1').value = data.observacionBloque;
                });
            });

            fetch('/ruta-para-obtener-estado2', {
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













    function mostrarInformacion(fechaSeleccionada) {
        var items = document.getElementsByClassName('item-info');
        for (var i = 0; i < items.length; i++) {
            var itemFecha = items[i].getAttribute('data-fecha-instalacion2');
            if (itemFecha === fechaSeleccionada) {
                items[i].style.display = 'block';
            } else {
                items[i].style.display = 'none';
            }
        }
    }



    document.addEventListener('DOMContentLoaded', function() {
        var primeraFecha = document.getElementById('fechaInstalacion2').value;
        mostrarInformacion(primeraFecha);
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





function mostrarInformacion(fechaSeleccionada) {
    document.querySelectorAll('.item-info').forEach(function(elemento) {
        if (elemento.getAttribute('data-fecha-instalacion2') === fechaSeleccionada) {
            elemento.style.display = 'block'; 
        } else {
            elemento.style.display = 'none'; 
        }
    });
}
