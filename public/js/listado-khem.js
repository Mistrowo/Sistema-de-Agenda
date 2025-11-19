document.addEventListener('DOMContentLoaded', function() {
    var filtroPendiente = document.querySelector('.filtro-pendiente');
    var filtroFinalizado = document.querySelector('.filtro-finalizado');

    filtroPendiente.addEventListener('click', function() {
        filtrarFilas('Pendiente');
    });

    filtroFinalizado.addEventListener('click', function() {
        filtrarFilas('Finalizado');
    });

    function filtrarFilas(estado) {
        var filas = document.querySelectorAll('table tbody tr');
        filas.forEach(function(fila) {
            var boton = fila.querySelector('button[data-estado]');
            var estadoDespacho = boton ? boton.getAttribute('data-estado') : '';
            if (estadoDespacho === estado) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    }
});




function toggleComentario(calendarioDefId) {
      var estadoPendiente = document.querySelector('input[name="estado_despacho"][value="Pendiente"][data-calendario-def-id="' + calendarioDefId + '"]').checked;
      var comentario = document.getElementById('comentario' + calendarioDefId);
  
      comentario.disabled = !estadoPendiente;
  }
  

  document.addEventListener('DOMContentLoaded', function() {
    var botonFiltrar = document.querySelector('.btn-filtrar');
    var inputNotaVenta = document.querySelector('.nota-venta-input');

    botonFiltrar.addEventListener('click', function() {
        var valorNotaVenta = inputNotaVenta.value.trim().toLowerCase();
        var filas = document.querySelectorAll('table tbody tr');

        filas.forEach(function(fila) {
            var celdaNotaVenta = fila.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();
            if (celdaNotaVenta === valorNotaVenta) { 
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });
});

