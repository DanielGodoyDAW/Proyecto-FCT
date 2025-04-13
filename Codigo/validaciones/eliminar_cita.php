<?php
//! habra que modificar todo cuando llegue aqui
// require_once __DIR__ . '/../conexion/conexion.php';

// header('Content-Type: application/json');

// // Verificar si los datos fueron enviados correctamente
// $data = json_decode(file_get_contents('php://input'), true);

// if (!isset($data['fecha']) || !isset($data['hora'])) {
//     echo json_encode(['success' => false, 'error' => 'Datos incompletos.']);
//     exit;
// }

// $fecha = $data['fecha'];
// $hora = $data['hora'];

// // Eliminar la cita de la base de datos
// $query = "DELETE FROM Citas WHERE fecha = ? AND hora = ?";
// $stmt = $conexion->prepare($query);
// $stmt->bind_param("ss", $fecha, $hora);

// if ($stmt->execute()) {
//     echo json_encode(['success' => true]);
// } else {
//     echo json_encode(['success' => false, 'error' => 'No se pudo eliminar la cita.']);
// }
?>