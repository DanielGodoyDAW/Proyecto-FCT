<?php

//! para modificar o borrar
// session_start();
// require_once __DIR__ . '/../conexion/conexion.php';

// header('Content-Type: application/json');

// // Verificar si el usuario es administrador
// if (!isset($_SESSION['idAdmin'])) {
//     echo json_encode(['success' => false, 'error' => 'No tienes permisos para realizar esta acción.']);
//     exit;
// }

// $data = json_decode(file_get_contents('php://input'), true);

// if (!isset($data['fecha']) || !isset($data['hora']) || !isset($data['estado'])) {
//     echo json_encode(['success' => false, 'error' => 'Datos incompletos.']);
//     exit;
// }

// $fecha = $data['fecha'];
// $hora = $data['hora'];
// $estado = $data['estado'];

// // Actualizar el estado de la cita
// $query = "UPDATE Citas SET estado = ? WHERE fecha = ? AND hora = ?";
// $stmt = $conexion->prepare($query);
// $stmt->bind_param("sss", $estado, $fecha, $hora);

// if ($stmt->execute()) {
//     echo json_encode(['success' => true, 'mensaje' => 'Estado actualizado correctamente.']);
// } else {
//     echo json_encode(['success' => false, 'error' => 'Error al actualizar el estado de la cita.']);
// }
?>