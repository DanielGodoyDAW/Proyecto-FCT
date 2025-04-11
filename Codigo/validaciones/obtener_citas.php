<?php
session_start();
require_once __DIR__ . '/../conexion/conexion.php';

header('Content-Type: application/json');

// Comprobamos si hay sesión activa
if (!isset($_SESSION['idPacientes'])) {
    echo json_encode(['success' => false, 'error' => 'Debes iniciar sesión para ver tus citas.']);
    exit;
}

$idPaciente = $_SESSION['idPacientes'];
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'proximas'; // Tipo de consulta: 'proximas' o 'historial'

// Obtener la fecha actual
$fechaActual = date('Y-m-d');

// Consultar las citas según el tipo
if ($tipo === 'proximas') {
    $query = "SELECT fecha, hora, estado FROM Citas WHERE idPacientes = ? AND fecha >= ? ORDER BY fecha, hora";
} else if ($tipo === 'historial') {
    $query = "SELECT fecha, hora, estado FROM Citas WHERE idPacientes = ? AND fecha < ? ORDER BY fecha DESC, hora DESC";
} else {
    echo json_encode(['success' => false, 'error' => 'Tipo de consulta no válido.']);
    exit;
}

$stmt = $conexion->prepare($query);
$stmt->bind_param("ss", $idPaciente, $fechaActual);
$stmt->execute();
$result = $stmt->get_result();

$citas = [];
while ($row = $result->fetch_assoc()) {
    $citas[] = $row;
}

echo json_encode(['success' => true, 'citas' => $citas]);
?>