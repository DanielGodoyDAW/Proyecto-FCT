<?php
require_once __DIR__ . '/../../vendor/autoload.php';


function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Reserva de Citas');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    $config = parse_ini_file(__DIR__ . '/../../config.env');
    $credentialsPath = $config['GOOGLE_CREDENTIALS_PATH'] ?? null;

    if (!$credentialsPath || !file_exists(__DIR__ . '/../../' . $credentialsPath)) {
        die('Error: El archivo de credenciales de Google Calendar no existe.');
    }

    $client->setAuthConfig(__DIR__ . '/../../' . $credentialsPath);
    return $client;
}

function obtenerDatosPaciente($idPaciente)
{
    require_once __DIR__ . '/../conexion/conexion.php';
    global $conexion;
    $query = "SELECT nombre, apellido1, apellido2, telefono FROM Pacientes WHERE idPacientes = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $idPaciente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Devuelve un array con los datos del paciente
    } else {
        return null; // Si no se encuentra el paciente
    }
}

function crearEvento($fecha, $horaInicio, $horaFin, $descripcion, $idPaciente, $bloqueada)
{
    if ($bloqueada == 1) {
        // No crear evento en Google Calendar si la cita está bloqueada
        return;
    }

    $client = getClient();
    $service = new Google_Service_Calendar($client);

    // Obtener los datos del paciente
    $datosPaciente = obtenerDatosPaciente($idPaciente);

    if (!$datosPaciente) {
        throw new Exception('Error: No se encontraron datos del paciente.');
    }

    // Construir la descripción con los datos del paciente
    $descripcionCompleta = $descripcion . "\nPaciente: " . $datosPaciente['nombre'] . " " . $datosPaciente['apellido1'] . " " . $datosPaciente['apellido2'] . "\nTeléfono: " . $datosPaciente['telefono'];

    $calendarId = 'danielgodoymedina@gmail.com'; // ID del calendario específico
    $evento = new Google_Service_Calendar_Event([
        'summary' => 'Cita médica',
        'description' => $descripcionCompleta,
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
    return $eventoCreado->id;; // Devuelve el id
}

function eliminarEventoGoogleCalendar($eventId)
{
    if (empty($eventId)) {
        throw new Exception("El ID del evento no puede estar vacío.");
    }

    $client = getClient();
    $service = new Google_Service_Calendar($client);
    $calendarId = 'danielgodoymedina@gmail.com'; // Tu calendario

    try {
        $service->events->delete($calendarId, $eventId);
    } catch (Exception $e) {
        throw new Exception("No se pudo eliminar el evento de Google Calendar: " . $e->getMessage());
    }
}
