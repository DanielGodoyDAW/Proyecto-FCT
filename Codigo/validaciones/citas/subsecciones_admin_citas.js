document.addEventListener('DOMContentLoaded', function () {
    const enlaces = document.querySelectorAll('.menu-citas a'); // Enlaces del menú de citas
    const secciones = document.querySelectorAll('.contenido-admin'); // Secciones de contenido de citas

    // Recuperar la sección activa desde localStorage
    const seccionActiva = localStorage.getItem('seccionActiva');

    if (seccionActiva && document.getElementById(seccionActiva)) {
        // Mostrar la sección activa guardada
        secciones.forEach(seccion => seccion.classList.remove('activo'));
        enlaces.forEach(enlace => enlace.classList.remove('activo'));

        document.getElementById(seccionActiva).classList.add('activo');
        document.querySelector(`.menu-citas a[data-seccion="${seccionActiva}"]`).classList.add('activo');
    } else if (enlaces.length > 0) {
        secciones.forEach(seccion => seccion.classList.remove('activo'));
        enlaces.forEach(enlace => enlace.classList.remove('activo'));
        secciones[0].classList.add('activo');
        enlaces[0].classList.add('activo');
    }

    // Manejar clics en los enlaces del menú
    enlaces.forEach(enlace => {
        enlace.addEventListener('click', function (e) {
            e.preventDefault(); // Evitar que el enlace recargue la página

            // Ocultar todas las secciones
            secciones.forEach(seccion => {
                seccion.classList.remove('activo');
            });

            // Remover clase activa de todos los enlaces
            enlaces.forEach(enlace => {
                enlace.classList.remove('activo');
            });

            // Mostrar la sección correspondiente
            const seccionId = this.getAttribute('data-seccion'); // Obtener el ID de la sección
            document.getElementById(seccionId).classList.add('activo');

            // Añadir clase activa al enlace clicado
            this.classList.add('activo');

            // Guardar la sección activa en localStorage
            localStorage.setItem('seccionActiva', seccionId);
        });
    });
});