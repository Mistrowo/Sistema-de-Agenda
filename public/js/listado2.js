function updateRowStylesAndFilter() {
  var selectedFilter = document.getElementById('estadoSelect').value;

  var rows = document.querySelectorAll('.table tbody tr');

  rows.forEach(function(row) {
      var estado = row.querySelector('td:nth-child(3)').textContent.trim();

      row.classList.remove('fila-en-espera', 'fila-calendarizada');

      if (estado === 'En espera' || estado === '-') {
          row.classList.add('fila-en-espera');
      } else if (estado === 'Calendarizado' || estado === 'Post-Venta') {
          row.classList.add('fila-calendarizada');
      }

      switch (selectedFilter) {
          case 'calendarizado':
              row.style.display = (estado === 'Calendarizado' || estado === 'Post-Venta') ? '' : 'none';
              break;
          case 'nocalendarizado':
              row.style.display = (estado !== 'Calendarizado' && estado !== 'Post-Venta') ? '' : 'none';
              break;
          default:
              break;
      }
  });
}

  
  window.onload = function() {
    updateRowStylesAndFilter();
  
    var selectElement = document.getElementById('estadoSelect');
    selectElement.addEventListener('change', function() {
      updateSelectColor(this);
      updateRowStylesAndFilter();
    });
  };
  



  