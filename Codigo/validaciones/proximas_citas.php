<?php
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

// if (!isset($_SESSION['idPacientes'])) {
//     echo json_encode(['error' => 'Usuario no autenticado']);
//     exit();
// }

// $idPaciente = $_SESSION['idPacientes'];
// $query = "SELECT * FROM citas WHERE idPacientes = ? AND fecha >= CURDATE() ORDER BY fecha ASC";
// $stmt = $conexion->prepare($query);
// $stmt->bind_param("i", $idPaciente);
// $stmt->execute();
// $result = $stmt->get_result();

// $citas = [];
// while ($row = $result->fetch_assoc()) {
//     $citas[] = $row;
// }

// echo json_encode(['success' => true, 'citas' => $citas]);
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
                            const textoCita = document.createTextNode(`${fechaFormateada} - ${horaFormateada} (${cita.estado})`);
                            li.appendChild(textoCita);

                            // Crear el botón de eliminar
                            const botonEliminar = document.createElement('button');
                            botonEliminar.textContent = '🗑️'; // Ícono de papelera
                            botonEliminar.classList.add('btn-eliminar');
                            botonEliminar.title = 'Eliminar cita';

                            // Añadir evento para eliminar la cita
                            botonEliminar.addEventListener('click', () => {
                                if (confirm(`¿Estás seguro de que deseas eliminar la cita del ${fechaFormateada} a las ${horaFormateada}?`)) {
                                    eliminarCita(cita.fecha, cita.hora, li);
                                }
                            });

                            li.appendChild(botonEliminar);
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

    // Función para eliminar una cita
    function eliminarCita(fecha, hora, elemento) {
        fetch('validaciones/eliminar_cita.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ fecha, hora }),
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