document.addEventListener('DOMContentLoaded', function () {
    const enlaces = document.querySelectorAll('.menu-admin a');
    const secciones = document.querySelectorAll('.contenido-admin');

    const pacienteId = localStorage.getItem('pacienteSeleccionado');
    const subseccion = localStorage.getItem('subseccionHistorial');

    // Parámetros desde la URL
    const urlParams = new URLSearchParams(window.location.search);
    const seccionFromUrl = urlParams.get('seccion');
    const subFromUrl = urlParams.get('sub');

    // 1. Activar desde localStorage (clic en botón)
    if (pacienteId && subseccion) {
        activarHistorialDesdeStorage(pacienteId, subseccion);
        localStorage.removeItem('pacienteSeleccionado');
        localStorage.removeItem('subseccionHistorial');
    }
    // 2. Activar desde GET 
    else if (seccionFromUrl === 'historial') {
        activarHistorialDesdeUrl(subFromUrl || 'ver');
    }
    // 3. Si nada especial, activa la primera por defecto
    else {
        secciones.forEach(seccion => seccion.classList.remove('activo'));
        enlaces.forEach(enlace => enlace.classList.remove('activo'));
        if (secciones[0]) secciones[0].classList.add('activo');
        if (enlaces[0]) enlaces[0].classList.add('activo');
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

    // FUNCIONES AUXILIARES
    function activarHistorialDesdeStorage(pacienteId, subId) {
        document.querySelectorAll('.contenido-admin').forEach(div => div.classList.remove('activo'));
        document.getElementById('historial')?.classList.add('activo');

        document.querySelectorAll('.menu-admin a').forEach(a => a.classList.remove('activo'));
        document.querySelector('[data-seccion="historial"]')?.classList.add('activo');

        document.querySelectorAll('#historial .subcontenido').forEach(div => div.classList.remove('activo'));
        document.getElementById(subId)?.classList.add('activo');

        document.querySelectorAll('input[name="idPaciente"]').forEach(input => {
            input.value = pacienteId;
        });
    }

    function activarHistorialDesdeUrl(subId) {
        document.querySelectorAll('.contenido-admin').forEach(div => div.classList.remove('activo'));
        document.getElementById('historial')?.classList.add('activo');

        document.querySelectorAll('.menu-admin a').forEach(a => a.classList.remove('activo'));
        document.querySelector('[data-seccion="historial"]')?.classList.add('activo');

        document.querySelectorAll('#historial .subcontenido').forEach(div => div.classList.remove('activo'));
        document.getElementById(subId)?.classList.add('activo');
    }
});
