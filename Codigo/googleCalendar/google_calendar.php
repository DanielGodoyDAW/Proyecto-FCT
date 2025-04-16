<?php
require_once __DIR__ . '/../../vendor/autoload.php';
 

function getClient() {
    $client = new Google_Client();
    $client->setApplicationName('Reserva de Citas');
    $client->setScopes(Google_Service_Calendar::CALENDAR);
    $client->setAuthConfig(__DIR__ . '/../config/credentials.json');
    return $client;
}

function obtenerDatosPaciente($idPaciente) {
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

function crearEvento($fecha, $horaInicio, $horaFin, $descripcion, $idPaciente) {
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
    return $eventoCreado->htmlLink; // Devuelve el enlace al evento en Google Calendar
}

// Ejemplo de uso
try {
    $idPaciente = $_SESSION["idPacientes"]; // ID del paciente desde la sesión
    $fecha = '2025-04-20';
    $horaInicio = '10:00';
    $horaFin = '11:00';
    $descripcion = 'Consulta general';

    $enlaceEvento = crearEvento($fecha, $horaInicio, $horaFin, $descripcion, $idPaciente);
    echo 'Evento creado: <a href="' . $enlaceEvento . '">Ver en Google Calendar</a>';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

