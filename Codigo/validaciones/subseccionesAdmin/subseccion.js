document.addEventListener('DOMContentLoaded', function () {
    const enlaces = document.querySelectorAll('.menu-admin a');
    const secciones = document.querySelectorAll('.contenido-admin');

    // Mostrar la primera sección por defecto
    secciones.forEach(seccion => seccion.classList.remove('activo'));
    enlaces.forEach(enlace => enlace.classList.remove('activo'));
    secciones[0].classList.add('activo');
    enlaces[0].classList.add('activo');

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
            const seccionId = this.getAttribute('data-seccion');
            document.getElementById(seccionId).classList.add('activo');

            // Añadir clase activa al enlace clicado
            this.classList.add('activo');
        });
    });
});