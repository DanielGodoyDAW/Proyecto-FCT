<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';
require_once __DIR__ . '/../../googleCalendar/google_calendar.php';

// 1. Recoger datos del formulario
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$nombre = $_POST['nombre'];
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'] ?? '';
$telefono = '+34 ' . preg_replace('/\s+/', '', $_POST['telefono']); //asignamos el prefijo de España por defecto
$email = $_POST['email'] ?: 'temporal_' . uniqid() . '@carmen.godoy'; //le asinamos un email temporal por si no tienen ninguno
$temporal = isset($_POST['temporal']);
$fechaNacim = '1900-01-01';
$sexo = 'O';
$dni = 'TEMP' . substr(md5(uniqid()), 0, 8);
$pass = password_hash('temporal123', PASSWORD_DEFAULT);

// 2. Insertar paciente
$stmtPaciente = $conexion->prepare("
    INSERT INTO Pacientes (nombre, apellido1, apellido2, email, telefono, fechaNacim, sexo, dni, pass)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmtPaciente->bind_param("sssssssss", $nombre, $apellido1, $apellido2, $email, $telefono, $fechaNacim, $sexo, $dni, $pass);

if (!$stmtPaciente->execute()) {
    die("Error al crear paciente temporal: " . $stmtPaciente->error);
}
$idPaciente = $stmtPaciente->insert_id;

// 3. Insertar cita
$stmtCita = $conexion->prepare("
    INSERT INTO Citas (fecha, hora, idPacientes, idAdmin, estado, confirmada)
    VALUES (?, ?, ?, ?, 'pendiente', 1)
");
$idAdmin = $_SESSION['idAdmin'];
$stmtCita->bind_param("ssii", $fecha, $hora, $idPaciente, $idAdmin);

if (!$stmtCita->execute()) {
    die("Error al crear cita: " . $stmtCita->error);
}
$idCita = $stmtCita->insert_id;

// 4. Crear evento en Google Calendar
try {
    $horaFin = date("H:i", strtotime($hora . " +30 minutes"));
    $anotaciones = "Cita reservada manualmente por el admin.";
    $bloqueada = 0; // No es bloqueada en este caso
    $google_event_id = crearEvento($fecha, $hora, $horaFin, $anotaciones, $idPaciente, $bloqueada);

    // 5. Guardar ID del evento en la BD
    $update = $conexion->prepare("UPDATE Citas SET google_event_id = ? WHERE idCita = ?");
    $update->bind_param("si", $google_event_id, $idCita);
    $update->execute();
} catch (Exception $e) {
    error_log("Error creando evento en Google Calendar: " . $e->getMessage());
}

// 6. Redirigir con mensaje
echo "<script>alert('Cita creada con éxito.');</script>";
header("Location: /Proyecto-FCT/Codigo/citas.php");
exit;
?>
