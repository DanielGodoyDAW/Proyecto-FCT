document.addEventListener('DOMContentLoaded', function () {
    const enlaces = document.querySelectorAll('.menu-citas a'); // Selecciona todos los enlaces del menú de citas
    const secciones = document.querySelectorAll('.contenido-admin'); // Selecciona todas las secciones de contenido

    // Mostrar la primera sección por defecto
    secciones.forEach(seccion => seccion.classList.remove('activo')); // Desactiva todas las secciones
    enlaces.forEach(enlace => enlace.classList.remove('activo')); // Desactiva todos los enlaces
    if (secciones.length > 0 && enlaces.length > 0) { // Verifica que existan secciones y enlaces
        secciones[0].classList.add('activo'); // Activa la primera sección
        enlaces[0].classList.add('activo'); // Activa el primer enlace
    }

    // Manejar clics en los enlaces del menú
    enlaces.forEach(enlace => { // Recorre cada enlace
        enlace.addEventListener('click', function (e) { // Añade un evento de clic
            e.preventDefault(); // Evitar recarga

            // Ocultar todas las secciones
            secciones.forEach(seccion => { // Recorre cada sección
                seccion.classList.remove('activo'); // Desactiva la sección
            });

            // Borrar activo de todos los enlaces
            enlaces.forEach(enlace => { // Recorre cada enlace
                enlace.classList.remove('activo'); // Desactiva el enlace
            });

            // Mostrar sección correspondiente
            const seccionId = this.getAttribute('data-seccion'); // Obtiene el ID de la sección a mostrar
            const seccionMostrar = document.getElementById(seccionId); // Busca la sección por ID
            if (seccionMostrar) { // Si se encontró la sección
                seccionMostrar.classList.add('activo'); // Activa la sección
            }

            // Añadir clase activo al enlace clicado
            this.classList.add('activo');
        });
    });
});
