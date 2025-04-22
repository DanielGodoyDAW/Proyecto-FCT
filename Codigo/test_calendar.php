<?php
// Test para crear un evento en Google Calendar
require_once __DIR__ . '/googleCalendar/google_calendar.php';

$fecha = '2025-04-14';
$horaInicio = '10:00';
$horaFin = '10:30';
$descripcion = 'Prueba de evento automático';

$link = crearEvento($fecha, $horaInicio, $horaFin, $descripcion, $idPaciente, $bloqueada);
echo "Evento creado: <a href='$link' target='_blank'>Ver en Calendar</a>";
?>