var currentDate = new Date();



var miModal = new bootstrap.Modal(document.getElementById('miModal'), {
    backdrop: true 
});

function cerrarModal() {
    $('#miModal').modal('hide');
}


function updateItemInfoDates() {
    var formattedDateId = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1).toString().padStart(2, '0') + '-' + currentDate.getDate().toString().padStart(2, '0');
    var itemInfoElements = document.querySelectorAll('.item-info');

    itemInfoElements.forEach(function(element) {
        var fechaInstalacion2 = element.getAttribute('data-fecha-instalacion2');
        if (fechaInstalacion2 === formattedDateId) {
            element.style.display = 'block'; 
        } else {
            element.style.display = 'none'; 
        }
    });
}


function obtenerNombreMes(month) {
    var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    return meses[month];
}
function updateCurrentDate() {
    var formattedCurrentDate = currentDate.getDate() + ' de ' + obtenerNombreMes(currentDate.getMonth()) + ' de ' + currentDate.getFullYear();
    var currentDateElement = document.getElementById('current-date');
    currentDateElement.textContent = formattedCurrentDate;
    updateItemInfoDates(); 
}


document.getElementById('next-day-button').addEventListener('click', function() {
    currentDate.setDate(currentDate.getDate() + 1);
    updateCurrentDate();
});

updateCurrentDate(); 



document.getElementById('prev-day-button').addEventListener('click', function() {
    currentDate.setDate(currentDate.getDate() -1 );
    updateCurrentDate();
});



document.addEventListener('DOMContentLoaded', function() {

    var statusCheckboxes = document.querySelectorAll('input[name="status"]');
    statusCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                statusCheckboxes.forEach(function(otherCheckbox) {
                    if (otherCheckbox !== checkbox) {
                        otherCheckbox.checked = false;
                    }
                });
            }
        });
    });
    var editIcons = document.querySelectorAll('.edit-icon-container');
    editIcons.forEach(function(icon) {

      
        icon.addEventListener('click', function() {
            var modal = new bootstrap.Modal(document.getElementById('miModal'));
            modal.show();
        });
    });
});
var currentItemInfo = null; 

document.addEventListener('DOMContentLoaded', function() {
    var editIcons = document.querySelectorAll('.edit-icon-container');
    editIcons.forEach(function(icon) {
        icon.addEventListener('click', function() {
            currentItemInfo = this.closest('.item-info'); 

            
            var estado = currentItemInfo.getAttribute('data-estado');
            var notaVenta = currentItemInfo.getAttribute('data-nota-venta');
            var fechaInstalacion = currentItemInfo.getAttribute('data-fecha-instalacion2');
            var descripcion = currentItemInfo.getAttribute('data-descripcion');
            var transportista = currentItemInfo.getAttribute('data-transportista');
            var observacion = currentItemInfo.getAttribute('data-observacion');
            var notaResumida = currentItemInfo.getAttribute('data-nota-resumida');
            var instalador = currentItemInfo.getAttribute('data-instalador');
            var bloque = currentItemInfo.getAttribute('data-bloque');

            document.getElementById('confirmedCheckbox').checked = false;
            document.getElementById('pendingCheckbox').checked = false;
            document.getElementById('postSaleCheckbox').checked = false;

            switch (estado) {
                case 'Calendarizado':
                    document.getElementById('confirmedCheckbox').checked = true;
                    break;
                case 'En espera':
                    document.getElementById('pendingCheckbox').checked = true;
                    break;
                case 'Post-Venta':
                    document.getElementById('postSaleCheckbox').checked = true;
                    break;
            }

            document.getElementById('notaVenta').value = notaVenta;
            document.getElementById('instalador').value = instalador;
            document.getElementById('horaBloque').value = bloque;
            document.getElementById('fechaEntregaModal').value = fechaInstalacion;
            document.getElementById('descripcionModal').value = descripcion;
            document.getElementById('transportista').value = transportista;
            document.getElementById('observaciones1').value = observacion;
            document.getElementById('observaciones3').value = notaResumida;

            var modal = new bootstrap.Modal(document.getElementById('miModal'));
            modal.show();
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var editIconModal = document.querySelector('.edit-icon-modal i');
    if (editIconModal) {
        editIconModal.addEventListener('click', function() {
            if (!currentItemInfo) {
                console.error('No se ha seleccionado ningún elemento para editar.');
                return;
            }

            var notaVenta = document.getElementById('notaVenta').value;
            var instalador = document.getElementById('instalador').value;
            var bloque = document.getElementById('horaBloque').value;
            var fechaEntrega = document.getElementById('fechaEntregaModal').value;
            var descripcion = document.getElementById('descripcionModal').value;
            var transportista = document.getElementById('transportista').value;
            var observaciones = document.getElementById('observaciones1').value;
            var notaResumida = document.getElementById('observaciones3').value;
            var estado = document.querySelector('input[name="status"]:checked').value;
            var originalBloque = currentItemInfo.getAttribute('data-original-bloque');
            var originalInstalador = currentItemInfo.getAttribute('data-original-instalador');

            var dataToSend = {
                nota_venta: notaVenta,
                original_bloque: originalBloque,
                original_instalador: originalInstalador,
                nuevo_bloque: bloque,
                nuevo_instalador: instalador,
                fecha_entrega: fechaEntrega,
                descripcion: descripcion,
                transportista: transportista,
                observaciones: observaciones,
                nota_resumida: notaResumida,
                estado: estado,
                _token: $('meta[name="csrf-token"]').attr('content') // Token de seguridad
            };


            var confirmacion = confirm('¿Desea modificar los datos?');
            if (confirmacion) {
                $.ajax({
                    url: '/update-agenda',
                    method: 'POST',
                    data: dataToSend,
                    success: function(response) {
                        alert('Requerimiento actualizado con éxito');
                        location.reload(); 
                    },
                    error: function(error) {
                    
                        console.error(error);
                    }
                });
            }
        });
    }
});

