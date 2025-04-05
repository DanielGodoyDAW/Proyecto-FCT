<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/locales/es.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css">
    <link rel="stylesheet" href="/Codigo/estilos/styleCalendario.css">
    <title>Calendario de Reserva</title>
</head>

<body>

    <div id="calendar-container">
        <div id="calendar-scroll">
            <div id="calendar"></div>
            <!-- Modal -->
            <div id="modalDia" class="modal" style="display: none;">
                <div class="modal-content">
                    <p id="detalleFecha"></p>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                contentHeight: 400,

                dayHeaderContent: function(info) {
                    const dias = {
                        'lun': 'Lunes',
                        'mar': 'Martes',
                        'mié': 'Miércoles',
                        'jue': 'Jueves',
                        'vie': 'Viernes',
                        'sáb': 'Sábado',
                        'dom': 'Domingo'
                    };
                    return dias[info.text] || info.text;
                },

                // Añadir clases a los días deshabilitados (sábados y domingos)
                dayCellClassNames: function(info) {
                    const fecha = new Date(info.date);
                    const diaSemana = fecha.getDay(); // 0 = domingo, 6 = sábado

                    if (diaSemana === 0 || diaSemana === 6) {
                        return ['fc-disabled-day']; // Clase personalizada para días deshabilitados
                    }
                },

                dateClick: function(info) {
                    const modal = document.getElementById('modalDia');
                    const detalleFecha = document.getElementById('detalleFecha');
                    const listaTramos = document.getElementById('tramos');

                    // Obtener el día de la semana (0 = domingo, 1 = lunes, ..., 6 = sábado)
                    const fecha = new Date(info.dateStr);
                    const diaSemana = fecha.getDay();

                    // Deshabilitar sábados y domingos
                    if (diaSemana === 0 || diaSemana === 6) {
                        detalleFecha.textContent = 'No hay horarios disponibles para esta fecha.';
                        modal.style.display = 'block';
                        listaTramos.innerHTML = '<p style="color: gray;">Día no disponible</p>';
                        return;
                    }

                    // Mostrar la fecha seleccionada
                    detalleFecha.textContent = 'Has seleccionado el día: ' + info.dateStr;
                    modal.style.display = 'block';

                    // Cargar tramos disponibles desde PHP
                    fetch('validaciones/tramos_horarios.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            fecha: info.dateStr
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        listaTramos.innerHTML = '';

                        if (data.error) {
                            listaTramos.innerHTML = `<p style="color: gray;">${data.error}</p>`;
                        } else {
                            // Crear contenedor para las dos columnas
                            const contenedorColumnas = document.createElement('div');
                            contenedorColumnas.classList.add('horarios-contenedor');

                            // Separar horarios de mañana y tarde
                            const horariosManana = [];
                            const horariosTarde = [];

                            for (const [inicio, fin] of Object.entries(data)) {
                                if (inicio < "14:00") {
                                    horariosManana.push(`${inicio} - ${fin}`);
                                } else {
                                    horariosTarde.push(`${inicio} - ${fin}`);
                                }
                            }

                            // Crear columna de horarios de mañana
                            if (horariosManana.length > 0) {
                                const columnaManana = document.createElement('div');
                                columnaManana.classList.add('horarios-columna');

                                const tituloManana = document.createElement('h3');
                                tituloManana.textContent = 'Horario de mañana:';
                                columnaManana.appendChild(tituloManana);

                                horariosManana.forEach(horario => {
                                    const button = document.createElement('button');
                                    button.textContent = horario;
                                    button.classList.add('horario-boton');

                                    // Al hacer clic en un tramo
                                    button.addEventListener('click', () => {
                                        if (confirm(`¿Deseas reservar el tramo ${horario}?`)) {
                                            fetch('validaciones/reservar_tramo.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                },
                                                body: JSON.stringify({
                                                    fecha: info.dateStr,
                                                    hora: horario.split(' - ')[0]
                                                }),
                                            })
                                            .then(res => res.json())
                                            .then(resp => {
                                                if (resp.success) {
                                                    alert(resp.mensaje);
                                                } else {
                                                    alert(resp.error || "Error al reservar");
                                                }
                                            })
                                            .catch(err => {
                                                alert("Error al reservar: " + err);
                                            });
                                        }
                                    });

                                    columnaManana.appendChild(button);
                                });

                                contenedorColumnas.appendChild(columnaManana);
                            }

                            // Crear columna de horarios de tarde
                            if (horariosTarde.length > 0) {
                                const columnaTarde = document.createElement('div');
                                columnaTarde.classList.add('horarios-columna');

                                const tituloTarde = document.createElement('h3');
                                tituloTarde.textContent = 'Horario de tarde:';
                                columnaTarde.appendChild(tituloTarde);

                                horariosTarde.forEach(horario => {
                                    const button = document.createElement('button');
                                    button.textContent = horario;
                                    button.classList.add('horario-boton');

                                    // Al hacer clic en un tramo
                                    button.addEventListener('click', () => {
                                        if (confirm(`¿Deseas reservar el tramo ${horario}?`)) {
                                            fetch('validaciones/reservar_tramo.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                },
                                                body: JSON.stringify({
                                                    fecha: info.dateStr,
                                                    hora: horario.split(' - ')[0]
                                                }),
                                            })
                                            .then(res => res.json())
                                            .then(resp => {
                                                if (resp.success) {
                                                    alert(resp.mensaje);
                                                } else {
                                                    alert(resp.error || "Error al reservar");
                                                }
                                            })
                                            .catch(err => {
                                                alert("Error al reservar: " + err);
                                            });
                                        }
                                    });

                                    columnaTarde.appendChild(button);
                                });

                                contenedorColumnas.appendChild(columnaTarde);
                            }

                            listaTramos.appendChild(contenedorColumnas);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });

            calendar.render();
        });
    </script>
</body>

</html>