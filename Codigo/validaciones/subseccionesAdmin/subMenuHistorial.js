document.addEventListener('DOMContentLoaded', function () {
    const subEnlaces = document.querySelectorAll('.submenu-historial a');
    const subsecciones = document.querySelectorAll('#historial .subcontenido');

    // Activar la primera subsección
    subsecciones.forEach(sub => sub.classList.remove('activo'));
    subEnlaces.forEach(link => link.classList.remove('activo'));
    if (subsecciones[0]) subsecciones[0].classList.add('activo');
    if (subEnlaces[0]) subEnlaces[0].classList.add('activo');

    // Evento de submenú
    subEnlaces.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            const subId = this.getAttribute('data-seccion');

            subsecciones.forEach(sub => sub.classList.remove('activo'));
            subEnlaces.forEach(link => link.classList.remove('activo'));

            document.getElementById(subId)?.classList.add('activo');
            this.classList.add('activo');
        });
    });
});
