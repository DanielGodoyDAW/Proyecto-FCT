document.addEventListener('DOMContentLoaded', function () { 
    const enlaces = document.querySelectorAll('.menu-admin a'); // Enlaces del menú
    const secciones = document.querySelectorAll('.contenido-admin'); // Secciones del contenido

    const pacienteId = localStorage.getItem('pacienteSeleccionado'); // ID del paciente
    const subseccion = localStorage.getItem('subseccionHistorial'); // Sub-sección del historial

    // Parámetros desde la URL
    const urlParams = new URLSearchParams(window.location.search); // Obtenemos los parámetros de la URL
    const seccionFromUrl = urlParams.get('seccion'); // Sección desde la URL
    const subFromUrl = urlParams.get('sub'); // Sub-sección desde la URL

    // 1. Activar desde localStorage (clic en botón)
    if (pacienteId && subseccion) { // Si hay ID de paciente y sub-sección
        activarHistorialDesdeStorage(pacienteId, subseccion); // Activa el historial desde localStorage
        localStorage.removeItem('pacienteSeleccionado'); // Limpia el ID del paciente
        localStorage.removeItem('subseccionHistorial'); // Limpia la sub-sección
    }
    // 2. Activar desde GET 
    else if (seccionFromUrl === 'historial') { // Si la sección es historial
        activarHistorialDesdeUrl(subFromUrl || 'ver'); // Activa el historial desde la URL
    }
    // 3. Si nada especial, activa la primera por defecto
    else { // Si no hay nada especial
        secciones.forEach(seccion => seccion.classList.remove('activo')); // Desactiva todas las secciones
        enlaces.forEach(enlace => enlace.classList.remove('activo')); // Desactiva todos los enlaces del menú
        if (secciones[0]) secciones[0].classList.add('activo'); // Activa la primera sección
        if (enlaces[0]) enlaces[0].classList.add('activo'); // Activa el primer enlace del menú
    }

    // Navegación normal entre secciones del menú
    enlaces.forEach(enlace => { // Recorre todos los enlaces del menú
        enlace.addEventListener('click', function (e) { // Agrega un evento de clic a cada enlace
            e.preventDefault(); // Previene el comportamiento por defecto del enlace
            const seccionId = this.getAttribute('data-seccion'); // Obtiene el ID de la sección correspondiente al enlace

            secciones.forEach(seccion => seccion.classList.remove('activo')); // Desactiva todas las secciones
            enlaces.forEach(enlace => enlace.classList.remove('activo')); 

            document.getElementById(seccionId)?.classList.add('activo'); // Activa la sección correspondiente
            this.classList.add('activo'); // Activa el enlace clicado
        });
    });

    // Captura clic en botones de historial y redirige a admin
    document.addEventListener('click', function (e) { // Captura clic en los botones de historial
        if (e.target.classList.contains('redirigir-historial')) { // Verifica si el clic fue en un botón de redirección
            const pacienteId = e.target.getAttribute('data-id'); // Obtiene el ID del paciente
            const subseccion = e.target.getAttribute('data-subseccion'); // Obtiene la sub-sección

            if (pacienteId && subseccion) { // Si hay ID de paciente y sub-sección
                localStorage.setItem('pacienteSeleccionado', pacienteId); // Guarda el ID del paciente en localStorage
                localStorage.setItem('subseccionHistorial', subseccion); // Guarda la sub-sección en localStorage
                window.location.href = 'admin.php'; // Redirige a la página admin
            }
        }
    });

    // Maneja clic manual en los enlaces del submenú de historial
    document.addEventListener('click', function (e) { // Captura clic en los enlaces del submenú
        if (e.target.matches('.submenu-historial a[data-subseccion]')) { // Verifica si el clic fue en un enlace del submenú
            e.preventDefault();

            // Desactiva todos
            document.querySelectorAll('.submenu-historial a').forEach(link => link.classList.remove('activo'));

            // Activa el clicado
            e.target.classList.add('activo');

            // Muestra la sub-sección correspondiente
            const id = e.target.getAttribute('data-subseccion'); // Obtiene el ID de la sub-sección
            document.querySelectorAll('#historial .subcontenido').forEach(div => div.classList.remove('activo')); // Desactiva todas las sub-secciones
            const target = document.getElementById(id); // Obtiene el elemento de la sub-sección
            if (target) target.classList.add('activo'); // Activa la sub-sección correspondiente
        }
    });

    // FUNCIONES AUXILIARES
    function activarHistorialDesdeStorage(pacienteId, subId) { // Activa el historial desde localStorage
        document.querySelectorAll('.contenido-admin').forEach(div => div.classList.remove('activo')); // Desactiva todas las secciones
        document.getElementById('historial')?.classList.add('activo'); // Activa la sección de historial

        document.querySelectorAll('.menu-admin a').forEach(a => a.classList.remove('activo')); // Desactiva todos los enlaces del menú
        document.querySelector('[data-seccion="historial"]')?.classList.add('activo'); // Activa el enlace de historial

        document.querySelectorAll('#historial .subcontenido').forEach(div => div.classList.remove('activo')); // Desactiva todas las sub-secciones
        document.getElementById(subId)?.classList.add('activo'); // Activa la sub-sección correspondiente
        document.querySelectorAll('input[name="idPaciente"]').forEach(input => {
            input.value = pacienteId; // Asigna el ID del paciente al input oculto
        });
    }

    function activarHistorialDesdeUrl(subId) { // Activa el historial desde la URL
        document.querySelectorAll('.contenido-admin').forEach(div => div.classList.remove('activo')); // Desactiva todas las secciones
        document.getElementById('historial')?.classList.add('activo'); // Activa la sección de historial

        document.querySelectorAll('.menu-admin a').forEach(a => a.classList.remove('activo')); // Desactiva todos los enlaces del menú
        document.querySelector('[data-seccion="historial"]')?.classList.add('activo'); // Activa el enlace de historial

        document.querySelectorAll('#historial .subcontenido').forEach(div => div.classList.remove('activo')); // Desactiva todas las sub-secciones
        document.getElementById(subId)?.classList.add('activo'); // Activa la sub-sección correspondiente
    }
});
