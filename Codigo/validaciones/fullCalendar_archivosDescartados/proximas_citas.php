<?php
// Este archivo se encarga de mostrar las próximas citas y el historial de citas del paciente o administrador
?>

<script>
    // Función para formatear la fecha en español
    function formatearFecha(fecha) {
        const opciones = {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        };
        const fechaSinHora = fecha.split(' ')[0]; // Eliminar la hora si viene en el formato "YYYY-MM-DD HH:MM:SS"
        const fechaFormateada = new Intl.DateTimeFormat('es-ES', opciones).format(new Date(fechaSinHora));
        return fechaFormateada;
    }

    // Función para formatear la hora en formato de 12 horas
    function formatearHora(hora) {
        const horaSinSegundos = hora.split(':').slice(0, 2).join(':'); // Eliminar los segundos si vienen en el formato "HH:MM:SS"
        const [horas, minutos] = horaSinSegundos.split(':');
        const date = new Date();
        date.setHours(horas, minutos);
        const opciones = {
            hour: 'numeric',
            minute: 'numeric',
            hour12: true
        };
        return new Intl.DateTimeFormat('es-ES', opciones).format(date);
    }

    // Función para cargar citas
    function cargarCitas(tipo, contenedorId) {
        fetch(`validaciones/obtener_citas.php?tipo=${tipo}`)
            .then(response => response.json())
            .then(data => {
                const contenedor = document.getElementById(contenedorId);
                contenedor.innerHTML = '';

                if (data.success) {
                    if (data.citas.length === 0) {
                        contenedor.innerHTML = '<li>No hay citas disponibles.</li>';
                    } else {
                        data.citas.forEach(cita => {
                            const li = document.createElement('li');
                            const fechaFormateada = formatearFecha(cita.fecha);
                            const horaFormateada = formatearHora(cita.hora);

                            // Crear el texto de la cita
                            let textoCita = `${fechaFormateada} - ${horaFormateada} (${cita.estado})`;
                            if (cita.bloqueada) {
                                textoCita += ` - [Bloqueada]`;
                            }
                            li.textContent = textoCita;

                            contenedor.appendChild(li);
                        });
                    }
                } else {
                    contenedor.innerHTML = `<li>Error: ${data.error}</li>`;
                }
            })
            .catch(error => {
                console.error('Error al cargar las citas:', error);
            });
    }

    // Función para actualizar el estado de una cita
    function actualizarEstadoCita(fecha, hora, nuevoEstado, elemento) {
        fetch('validaciones/actualizar_estado_cita.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ fecha, hora, estado: nuevoEstado }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Estado actualizado a ${nuevoEstado}.`);
                    elemento.textContent = `${formatearFecha(fecha)} - ${formatearHora(hora)} (${nuevoEstado})`;
                } else {
                    alert(`Error al actualizar el estado: ${data.error}`);
                }
            })
            .catch(error => {
                console.error('Error al actualizar el estado:', error);
            });
    }

    // Función para eliminar una cita
    function eliminarCita(fecha, hora, elemento) {
        fetch('validaciones/eliminar_cita.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    fecha,
                    hora
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Cita eliminada con éxito.');
                    elemento.remove(); // Eliminar el elemento de la lista
                } else {
                    alert(`Error al eliminar la cita: ${data.error}`);
                }
            })
            .catch(error => {
                console.error('Error al eliminar la cita:', error);
            });
    }

    // Cargar próximas citas y el historial
    cargarCitas('proximas', 'proximas-citas');
    cargarCitas('historial', 'historial-citas');
</script>