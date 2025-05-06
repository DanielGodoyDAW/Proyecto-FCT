document.addEventListener('DOMContentLoaded', function () {
    const enlaces = document.querySelectorAll('.menu-citas a');
    const secciones = document.querySelectorAll('.contenido-admin');

    // Mostrar la primera sección por defecto
    secciones.forEach(seccion => seccion.classList.remove('activo'));
    enlaces.forEach(enlace => enlace.classList.remove('activo'));
    if (secciones.length > 0 && enlaces.length > 0) {
        secciones[0].classList.add('activo');
        enlaces[0].classList.add('activo');
    }

    // Manejar clics en los enlaces del menú
    enlaces.forEach(enlace => {
        enlace.addEventListener('click', function (e) {
            e.preventDefault(); // Evitar recarga

            // Ocultar todas las secciones
            secciones.forEach(seccion => {
                seccion.classList.remove('activo');
            });

            // Borrar activo de todos los enlaces
            enlaces.forEach(enlace => {
                enlace.classList.remove('activo');
            });

            // Mostrar sección correspondiente
            const seccionId = this.getAttribute('data-seccion');
            const seccionMostrar = document.getElementById(seccionId);
            if (seccionMostrar) {
                seccionMostrar.classList.add('activo');
            }

            // Añadir clase activo al enlace clicado
            this.classList.add('activo');
        });
    });
});
