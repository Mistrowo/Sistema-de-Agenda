var today = new Date();
var currentStartDate = new Date(today);

function updateWeekDates(startDate) {
    var endDate = new Date(startDate);
    endDate.setDate(startDate.getDate() + 5); 

    var formattedStartDate = startDate.toLocaleDateString('es-ES', { month: 'long', day: 'numeric' });
    var formattedEndDate = endDate.toLocaleDateString('es-ES', { month: 'long', day: 'numeric' });

    var weekDatesElement = document.getElementById('week-dates');
    weekDatesElement.textContent = formattedStartDate + ' al ' + formattedEndDate;

    var headerItems = document.querySelectorAll('.schedule-header .header-item');
    var dayNames = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

    var bloques = ['A-1', 'A-2', 'A-3', 'A-4', 'A-5', 'A-6', 'A-7', 'A-8'];

    var iconos = [];

    for (var i = 1; i < headerItems.length; i++) {
        var date = new Date(startDate);
        date.setDate(startDate.getDate() + (i - 1));
        var dateStr = date.toISOString().split('T')[0];

        headerItems[i].setAttribute('data-fecha', dateStr);
        headerItems[i].id = dayNames[i - 1] + '-' + dateStr;

        if (dayNames[i - 1] === "miercoles") {
            headerItems[i].textContent = "Miércoles";
        } else if (dayNames[i - 1] === "sabado") {
            headerItems[i].textContent = "Sábado";
        } else {
            headerItems[i].textContent = dayNames[i - 1];
        }
    

        bloques.forEach(function(bloque) {
            var dataBlockId = 'bloque-' + bloque.replace('-', '') + '-dia-' + i;
            var dataBlock = document.getElementById(dataBlockId);

            if (dataBlock) {
                dataBlock.setAttribute('data-fecha', dateStr);
                dataBlock.innerHTML = '';

                if (instaladoresPorFecha[dateStr] && instaladoresPorFecha[dateStr].some(item => item.bloque === bloque)) {
                    dataBlock.classList.add('bloque-ocupado');

                    instaladoresPorFecha[dateStr].filter(item => item.bloque === bloque).forEach(function(item) {
                        var infoDiv = document.createElement('div');
                        infoDiv.className = 'bloque-info';

                        var notaVentaSpan = document.createElement('span');
                        notaVentaSpan.className = 'nota-venta';
                        notaVentaSpan.textContent = item.nota_venta + ' - ';

                        var nombreClienteSpan = document.createElement('span');
                        nombreClienteSpan.className = 'nombre-cliente';
                        nombreClienteSpan.textContent = item.nombre_cliente + ' - ';

                        var instaladorSpan = document.createElement('span');
                        instaladorSpan.className = 'instalador';
                        instaladorSpan.textContent = item.instalador;

                        infoDiv.appendChild(notaVentaSpan);
                        infoDiv.appendChild(nombreClienteSpan);
                        infoDiv.appendChild(instaladorSpan);

                        dataBlock.appendChild(infoDiv);
                    });

                    var icono = document.createElement('i');
                    icono.className = 'fas fa-pencil-alt';
                    icono.setAttribute('data-toggle', 'modal');
                    icono.setAttribute('data-target', '#notasVentaModal');
                    dataBlock.appendChild(icono);
                    iconos.push({ icono: icono, bloque: bloque, fecha: dateStr });
                } else {
                    dataBlock.classList.remove('bloque-ocupado');
                    var iconoExistente = dataBlock.querySelector('.fa-pencil-alt');
                    if (iconoExistente) {
                        dataBlock.removeChild(iconoExistente);
                    }
                }
            } else {
                console.error('No se encontró el bloque de datos con ID:', dataBlockId);
            }
        });
    }

    iconos.forEach(function(obj) {
        obj.icono.onclick = function() {
            var modalBody = document.getElementById('modalContent');
            modalBody.innerHTML = '';
    
            if (instaladoresPorFecha[obj.fecha]) {
                var itemsEnBloque = instaladoresPorFecha[obj.fecha].filter(item => item.bloque === obj.bloque);
                itemsEnBloque.forEach(function(item, index) {
                    var fila = document.createElement('tr');
                    fila.innerHTML = '<th scope="row">' + (index + 1) + '</th>' +
                                     '<td>' + item.nota_venta + '</td>' +
                                     '<td>' + item.nombre_cliente + '</td>' + 
                                     '<td>' + item.fecha_instalacion2 + '</td>' +
                                     '<td>' + item.instalador + '</td>' +
                                     '<td>' + item.bloque + '</td>' +
                                     '<td>' + item.estado + '</td>' +
                                     '<td>' + '<a href="/agenda-def/detalle/' + item.calendario_def_id + '" class="tooltip-container"><i class="fas fa-edit"></i><span class="tooltip-text">Editar NV</span></a>' + '</td>';

            
                    modalBody.appendChild(fila);
                });
            }
            
        };
    });
}




function updateDataBlocks(weekDates) {
    var dataBlocks = document.querySelectorAll('.data-block .item-info');
    dataBlocks.forEach(function(block) {
        var fechaInstalacion = block.getAttribute('data-fecha-instalacion2').split(' ')[0];
        if (weekDates.includes(fechaInstalacion)) {
            block.style.display = ''; 
        } else {
            block.style.display = 'none'; 
        }
    });
}



function initializeWeek() {
    var today = new Date();
    var currentStartDate = new Date(today.setDate(today.getDate() - today.getDay() + 1)); 
    updateWeekDates(currentStartDate);
}

window.onload = function() {
    initializeWeek();
};

function goToNextWeek() {
    currentStartDate.setDate(currentStartDate.getDate() + 7); 
    updateWeekDates(currentStartDate);
}

function goToPrevWeek() {
    currentStartDate.setDate(currentStartDate.getDate() - 7); 
    updateWeekDates(currentStartDate);
}

window.onload = function() {
    var today = new Date();
    var dayOfWeek = today.getDay();
    var difference = dayOfWeek === 0 ? 6 : dayOfWeek - 1; 
    currentStartDate.setDate(today.getDate() - difference);

    updateWeekDates(currentStartDate);
};

document.getElementById('next-week-button').addEventListener('click', goToNextWeek);
document.getElementById('prev-week-button').addEventListener('click', goToPrevWeek);
