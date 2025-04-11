<?php
session_start();
require_once __DIR__ . '/../conexion/conexion.php';

header('Content-Type: application/json');

// Comprobamos si hay sesión activa
if (!isset($_SESSION['idPacientes']) && !isset($_SESSION['idAdmin'])) {
    echo json_encode(['success' => false, 'error' => 'Debes iniciar sesión para reservar un tramo.']);
    exit;
}

$idPaciente = isset($_SESSION['idPacientes']) ? $_SESSION['idPacientes'] : null;
$idAdmin = isset($_SESSION['idAdmin']) ? $_SESSION['idAdmin'] : null;

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['fecha']) || !isset($data['hora'])) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos.']);
    exit;
}

$fecha = $data['fecha'];
$hora = $data['hora'];

// Verificar que el tramo esté libre
$query = "SELECT COUNT(*) AS total FROM Citas WHERE fecha = ? AND hora = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ss", $fecha, $hora);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($result['total'] > 0) {
    echo json_encode(['success' => false, 'error' => 'Este horario ya está reservado.']);
    exit;
}

// Insertar la nueva cita
$estado = 'Pendiente';
$insert = "INSERT INTO Citas (fecha, hora, estado, idPacientes, idAdmin) VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($insert);
$stmt->bind_param("sssii", $fecha, $hora, $estado, $idPaciente, $idAdmin);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'mensaje' => '¡Cita reservada con éxito!']);
} else {
    echo json_encode(['success' => false, 'error' => 'Error al guardar la cita en la base de datos.']);
}
?>