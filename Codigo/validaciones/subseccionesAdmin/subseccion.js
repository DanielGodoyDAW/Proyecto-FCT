document.addEventListener('DOMContentLoaded', function () {
    const enlaces = document.querySelectorAll('.menu-admin a');
    const secciones = document.querySelectorAll('.contenido-admin');

    // Activar la primera sección
    secciones.forEach(seccion => seccion.classList.remove('activo'));
    enlaces.forEach(enlace => enlace.classList.remove('activo'));
    if (secciones[0]) secciones[0].classList.add('activo');
    if (enlaces[0]) enlaces[0].classList.add('activo');

    // Evento de navegación principal
    enlaces.forEach(enlace => {
        enlace.addEventListener('click', function (e) {
            e.preventDefault();

            const seccionId = this.getAttribute('data-seccion');

            secciones.forEach(seccion => seccion.classList.remove('activo'));
            enlaces.forEach(enlace => enlace.classList.remove('activo'));

            document.getElementById(seccionId)?.classList.add('activo');
            this.classList.add('activo');
        });
    });
});
