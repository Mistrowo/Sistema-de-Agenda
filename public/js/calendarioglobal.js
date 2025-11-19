
function abrirModal() {
    document.getElementById("miModal").style.display = "block";
}

function cerrarModal() {
    document.getElementById("miModal").style.display = "none";
}

document.querySelectorAll('.data-block').forEach(item => {
    item.addEventListener('click', abrirModal);
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
    'bloque-confirmar':'POR CONFIRMAR'

    
    
};


document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-fecha-instalacion]').forEach(function(element) {
        console.log('Fecha de instalación (data-fecha-instalacion):', element.getAttribute('data-fecha-instalacion'));
        console.log('Contenido del elemento:', element.innerHTML);
    });
});




