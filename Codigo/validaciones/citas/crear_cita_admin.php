<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';
require_once __DIR__ . '/../../googleCalendar/google_calendar.php';

// Recoger datos del formulario
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$nombre = $_POST['nombre'];
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'] ?? '';
$telefono = '+34 ' . preg_replace('/\s+/', '', $_POST['telefono']); //asignamos el prefijo de España por defecto
$email = $_POST['email'] ?: 'temporal_' . uniqid() . '@carmen.godoy'; //le asinamos un email temporal por si no tienen ninguno
$fechaNacim = '1900-01-01';
$sexo = 'O';
$dni = 'TEMP' . substr(md5(uniqid()), 0, 8);
$pass = password_hash('Contra+1234', PASSWORD_DEFAULT);
$temporal = 1; // Asignamos 1 para indicar que es temporal

// Insertar paciente
$stmtPaciente = $conexion->prepare("
    INSERT INTO Pacientes (nombre, apellido1, apellido2, email, telefono, fechaNacim, sexo, dni, pass, es_temporal)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmtPaciente->bind_param("sssssssssi", $nombre, $apellido1, $apellido2, $email, $telefono, $fechaNacim, $sexo, $dni, $pass, $temporal);

if (!$stmtPaciente->execute()) {
    echo "<script>alert('Error al crear paciente temporal: " . addslashes($stmtPaciente->error) . "'); window.history.back();</script>";
    exit;
}
$idPaciente = $stmtPaciente->insert_id;

// Insertar cita
$stmtCita = $conexion->prepare("
    INSERT INTO Citas (fecha, hora, idPacientes, idAdmin, estado, confirmada)
    VALUES (?, ?, ?, ?, 'pendiente', 1)
");
$idAdmin = $_SESSION['idAdmin'];
$stmtCita->bind_param("ssii", $fecha, $hora, $idPaciente, $idAdmin);

if (!$stmtCita->execute()) {
    echo "<script>alert('Error al crear cita: " . addslashes($stmtCita->error) . "'); window.history.back();</script>";
    exit;
}
$idCita = $stmtCita->insert_id;

// Crear evento en Google Calendar
try {
    $horaFin = date("H:i", strtotime($hora . " +30 minutes"));
    $anotaciones = "Cita reservada manualmente por el admin.";
    $bloqueada = 0; // No es bloqueada en este caso
    $google_event_id = crearEvento($fecha, $hora, $horaFin, $anotaciones, $idPaciente, $bloqueada);
    // Guardar ID del evento en la BD
    $update = $conexion->prepare("UPDATE Citas SET google_event_id = ? WHERE idCita = ?");
    $update->bind_param("si", $google_event_id, $idCita);
    $update->execute();
} catch (Exception $e) {
    error_log("Error creando evento en Google Calendar: " . $e->getMessage());
}

// Redirigir con mensaje
echo "<script>alert('Cita creada con éxito.'); window.location.href = '../../citas.php';</script>";
exit;
?>