<?php
require_once __DIR__ . '/../../vendor/autoload.php';

function getClient() {
    $client = new Google_Client();
    $client->setApplicationName('Reserva de Citas');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig(__DIR__ . '/../config/credentials.json');
    //$client->setAuthConfig(__DIR__ . '/../../../config/credentials.json');
    return $client;
}

function crearEvento($fecha, $horaInicio, $horaFin, $descripcion) {
    $client = getClient();
    $service = new Google_Service_Calendar($client);

    $calendarId = 'danielgodoymedina@gmail.com'; // ID calendario específico
    $evento = new Google_Service_Calendar_Event([
        'summary' => 'Cita médica',
        'description' => $descripcion,
        'start' => [
            'dateTime' => $fecha . 'T' . $horaInicio . ':00',
            'timeZone' => 'Europe/Madrid',
        ],
        'end' => [
            'dateTime' => $fecha . 'T' . $horaFin . ':00',
            'timeZone' => 'Europe/Madrid',
        ],
    ]);

    $eventoCreado = $service->events->insert($calendarId, $evento);
    return $eventoCreado->htmlLink; // Devuelve el enlace al evento en Google Calendar
}

?>

