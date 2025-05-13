document.addEventListener('DOMContentLoaded', function () { // Espera a que el DOM esté completamente cargado
    const subEnlaces = document.querySelectorAll('.submenu-historial a'); // Selecciona todos los enlaces del submenú de historial
    const subsecciones = document.querySelectorAll('#historial .subcontenido'); // Selecciona todas las subsecciones dentro de historial

    const yaHayActivo = document.querySelector('#historial .subcontenido.activo'); // Verifica si ya hay una subsección activa
    if (!yaHayActivo) { // Si no hay subsección activa
        // Activar la primera subsección solo si no hay activa
        subsecciones.forEach(sub => sub.classList.remove('activo')); // Desactiva todas las subsecciones
        subEnlaces.forEach(link => link.classList.remove('activo')); // Desactiva todos los enlaces del submenú
        if (subsecciones[0]) subsecciones[0].classList.add('activo'); // Activa la primera subsección
        if (subEnlaces[0]) subEnlaces[0].classList.add('activo'); // Activa el primer enlace del submenú
    }

});

function mostrarHistorial(subseccionId) { // Función para mostrar el historial
    document.querySelectorAll('.contenido-admin').forEach(sec => sec.classList.remove('activo')); // Desactiva todas las secciones
    document.getElementById('historial').classList.add('activo'); // Activa la sección de historial

    document.querySelectorAll('.menu-admin a').forEach(link => link.classList.remove('activo')); // Desactiva todos los enlaces del menú
    document.querySelector('[data-seccion="historial"]').classList.add('activo'); // Activa el enlace de historial

    document.querySelectorAll('#historial .subcontenido').forEach(sub => sub.classList.remove('activo')); // Desactiva todas las subsecciones
    document.getElementById(subseccionId).classList.add('activo'); // Activa la subsección correspondiente
}

