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
        </div>
    </div>

    <!-- Modal -->
    <div id="modalDia" class="modal" style="display: none;">
        <div class="modal-content">
            <!-- <span class="close">&times;</span> -->
            <p id="detalleFecha"></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Vista mensual
                locale: 'es', // Español
                dayHeaderContent: function(info) {
                    // Personaliza los nombres de los días para que aparezcan en mayúsculas
                    const dias = {
                        'lun': 'Lunes',
                        'mar': 'Martes',
                        'mié': 'Miércoles',
                        'jue': 'Jueves',
                        'vie': 'Viernes',
                        'sáb': 'Sábado',
                        'dom': 'Domingo'
                    };
                    return dias[info.text] || info.text; // Devuelve el nombre personalizado
                },
                contentHeight: 400,

                // Aquí va el dateClick
                dateClick: function(info) {
                    var modal = document.getElementById('modalDia');
                    var detalleFecha = document.getElementById('detalleFecha');

                    // Formatear la fecha al estilo español (dd/mm/yyyy)
                    var fecha = new Date(info.dateStr); // Convierte la fecha a un objeto Date
                    var dia = fecha.getDate().toString().padStart(2, '0'); // Día con dos dígitos
                    var mes = (fecha.getMonth() + 1).toString().padStart(2, '0'); // Mes con dos dígitos
                    var anio = fecha.getFullYear(); // Año

                    detalleFecha.textContent = 'Has seleccionado el día: ' + dia + '/' + mes + '/' + anio;
                    modal.style.display = 'block';

                    // Enviar la fecha al servidor mediante fetch
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
                            console.log('Tramos horarios:', data); // Aquí puedes manejar los tramos horarios devueltos
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                },

                events: function(fetchInfo, successCallback, failureCallback) {
                    // Llamada a un archivo PHP para obtener los datos de disponibilidad
                    fetch('validaciones/calendario/get-availability.php')
                        .then(response => response.json())
                        .then(data => {
                            // Procesar los datos y asignar clases personalizadas
                            const events = data.map(day => {
                                return {
                                    start: day.date, // Fecha del día
                                    display: 'background', // Mostrar como fondo
                                    classNames: [day.status] // Clase CSS según el estado
                                };
                            });
                            successCallback(events);
                        })
                        .catch(error => failureCallback(error));
                }
            });

            calendar.render();
        });
    </script>
</body>

</html>