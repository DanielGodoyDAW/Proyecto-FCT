<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';
require_once __DIR__ . '/../../googleCalendar/google_calendar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPaciente = $_SESSION['idPacientes'];
    $fecha = $_POST['fecha'];
    $horaInicio = $_POST['hora'];
    $horaFin = date('H:i', strtotime($horaInicio) + 30 * 60); // Sumar 30 minutos
    $descripcion = 'Cita reservada por el paciente.';
    $bloqueada = isset($_POST['bloqueada']) ? 1 : 0; // Si es bloqueada, se establece a 1

    // Guardar la cita en la base de datos (ya implementado)

    // Crear el evento en Google Calendar
    try {
        $enlaceEvento = crearEvento($fecha, $horaInicio, $horaFin, $descripcion, $idPaciente, $bloqueada);
        echo 'Evento creado: <a href="' . $enlaceEvento . '">Ver en Google Calendar</a>';
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

// Verificar si hay sesión activa
if (!isset($_SESSION['idPacientes']) && !isset($_SESSION['idAdmin'])) {
    die('Error: Debes iniciar sesión para reservar un tramo.');
}

// Obtener el ID del paciente o administrador
$idPaciente = isset($_SESSION['idPacientes']) ? $_SESSION['idPacientes'] : null;
$idAdmin = isset($_SESSION['idAdmin']) ? $_SESSION['idAdmin'] : null;

// Si es el administrador, marcar la cita como bloqueada
$bloqueada = ($idAdmin && !$idPaciente) ? 1 : 0;

// Verificar si se recibieron la fecha y la hora
if (!isset($_POST['fecha']) || !isset($_POST['hora'])) {
    die('Error: Datos incompletos. Asegúrate de enviar la fecha y la hora.');
}

$fecha = $_POST['fecha'];
$hora = $_POST['hora'];

// Verificar que el tramo no esté reservado
$query = "SELECT COUNT(*) AS total FROM Citas WHERE fecha = ? AND hora = ? AND bloqueada = 0";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ss", $fecha, $hora);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($result['total'] > 0) {
    echo '<script>alert("El tramo horario no está disponible.");</script>';
    echo '<script>window.location.href = "/Codigo/citas.php";</script>';
    exit();
} else {
    // Insertar la nueva cita en la base de datos
    $estado = 'Pendiente';
    $insert = "INSERT INTO Citas (fecha, hora, estado, idPacientes, idAdmin, bloqueada) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($insert);
    $stmt->bind_param("sssiii", $fecha, $hora, $estado, $idPaciente, $idAdmin, $bloqueada);

    if ($stmt->execute()) {
        echo '<script>alert("Cita reservada exitosamente.");</script>';
        echo '<script>window.location.href = "/Codigo/citas.php";</script>'; // Redirigir a la pagina de citas
    } else {
        echo 'Error: No se pudo guardar la cita en la base de datos.';
    }
}

?>
