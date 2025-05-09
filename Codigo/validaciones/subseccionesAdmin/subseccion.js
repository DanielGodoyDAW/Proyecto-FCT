document.addEventListener('DOMContentLoaded', function () {
    const enlaces = document.querySelectorAll('.menu-admin a');
    const secciones = document.querySelectorAll('.contenido-admin');

    const pacienteId = localStorage.getItem('pacienteSeleccionado');
    const subseccion = localStorage.getItem('subseccionHistorial');

    // Modo normal si no viene de un botón especial
    if (!pacienteId || !subseccion) {
        // Activar la primera sección por defecto
        secciones.forEach(seccion => seccion.classList.remove('activo'));
        enlaces.forEach(enlace => enlace.classList.remove('activo'));
        if (secciones[0]) secciones[0].classList.add('activo');
        if (enlaces[0]) enlaces[0].classList.add('activo');
    }

    // Activar desde localStorage si viene de un botón especial
    if (pacienteId && subseccion) {
        // Mostrar sección "historial"
        document.querySelectorAll('.contenido-admin').forEach(div => div.classList.remove('activo'));
        const principal = document.getElementById('historial');
        if (principal) principal.classList.add('activo');

        // Marcar el enlace del menú
        document.querySelectorAll('.menu-admin a').forEach(a => a.classList.remove('activo'));
        const link = document.querySelector('[data-seccion="historial"]');
        if (link) link.classList.add('activo');

        // Mostrar subsección correspondiente
        document.querySelectorAll('#historial .subcontenido').forEach(div => div.classList.remove('activo'));
        const sub = document.getElementById(subseccion);
        if (sub) sub.classList.add('activo');

        // Rellenar campo oculto del paciente
        document.querySelectorAll('input[name="idPaciente"]').forEach(input => {
            input.value = pacienteId;
        });

        // Limpiar localStorage solo después de aplicar
        localStorage.removeItem('pacienteSeleccionado');
        localStorage.removeItem('subseccionHistorial');
    }

    // Navegación normal entre secciones del menú
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

// Captura clic en botones de historial y redirige a admin
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('redirigir-historial')) {
        const pacienteId = e.target.getAttribute('data-id');
        const subseccion = e.target.getAttribute('data-subseccion');

        if (pacienteId && subseccion) {
            localStorage.setItem('pacienteSeleccionado', pacienteId);
            localStorage.setItem('subseccionHistorial', subseccion);
            window.location.href = 'admin.php';
        }
    }
});

// Maneja clic manual en los enlaces del submenú de historial
document.addEventListener('click', function (e) {
    if (e.target.matches('.submenu-historial a[data-subseccion]')) {
        e.preventDefault();

        // Desactiva todos
        document.querySelectorAll('.submenu-historial a').forEach(link => link.classList.remove('activo'));

        // Activa el clicado
        e.target.classList.add('activo');

        // Muestra la sub-sección correspondiente
        const id = e.target.getAttribute('data-subseccion');
        document.querySelectorAll('#historial .subcontenido').forEach(div => div.classList.remove('activo'));
        const target = document.getElementById(id);
        if (target) target.classList.add('activo');
    }
});
