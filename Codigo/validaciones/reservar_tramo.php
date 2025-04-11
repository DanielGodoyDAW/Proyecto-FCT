<?php
session_start();
require_once __DIR__ . '/../conexion/conexion.php';

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
$query = "SELECT COUNT(*) AS total FROM Citas WHERE fecha = ? AND hora = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ss", $fecha, $hora);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($result['total'] > 0) {
    die('Error: Este horario ya está reservado.');
}

// Insertar la nueva cita en la base de datos
$estado = 'Pendiente';
$insert = "INSERT INTO Citas (fecha, hora, estado, idPacientes, idAdmin, bloqueada) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($insert);
$stmt->bind_param("sssiii", $fecha, $hora, $estado, $idPaciente, $idAdmin, $bloqueada);

if ($stmt->execute()) {
    echo '<script>alert("Cita reservada exitosamente.");</script>';
    echo '<script>window.location.href = "../citas.php";</script>'; // Redirigir a la página de citas
} else {
    echo 'Error: No se pudo guardar la cita en la base de datos.';
}
?>