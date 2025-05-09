document.addEventListener('DOMContentLoaded', function () {
    const subEnlaces = document.querySelectorAll('.submenu-historial a');
    const subsecciones = document.querySelectorAll('#historial .subcontenido');

    const yaHayActivo = document.querySelector('#historial .subcontenido.activo');
    if (!yaHayActivo) {
        // Activar la primera subsección solo si no hay activa
        subsecciones.forEach(sub => sub.classList.remove('activo'));
        subEnlaces.forEach(link => link.classList.remove('activo'));
        if (subsecciones[0]) subsecciones[0].classList.add('activo');
        if (subEnlaces[0]) subEnlaces[0].classList.add('activo');
    }

});

function mostrarHistorial(subseccionId) {
    document.querySelectorAll('.contenido-admin').forEach(sec => sec.classList.remove('activo'));
    document.getElementById('historial').classList.add('activo');

    document.querySelectorAll('.menu-admin a').forEach(link => link.classList.remove('activo'));
    document.querySelector('[data-seccion="historial"]').classList.add('activo');

    document.querySelectorAll('#historial .subcontenido').forEach(sub => sub.classList.remove('activo'));
    document.getElementById(subseccionId).classList.add('activo');
}

