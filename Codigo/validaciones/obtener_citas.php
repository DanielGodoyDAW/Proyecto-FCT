<?php
//! habra que modificar cosas cuando llegue aqui o borrar si no hace falta
// session_start();
// require_once __DIR__ . '/../conexion/conexion.php';

// header('Content-Type: application/json');

// // Verificar conexión a la base de datos
// if (!$conexion) {
//     echo json_encode(['success' => false, 'error' => 'Error en la conexión a la base de datos.']);
//     exit;
// }

// // Comprobamos si hay sesión activa
// if (!isset($_SESSION['idPacientes']) && !isset($_SESSION['idAdmin'])) {
//     echo json_encode(['success' => false, 'error' => 'Debes iniciar sesión para ver las citas.']);
//     exit;
// }

// $idPaciente = isset($_SESSION['idPacientes']) ? $_SESSION['idPacientes'] : null;
// $idAdmin = isset($_SESSION['idAdmin']) ? $_SESSION['idAdmin'] : null;

// $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'proximas'; // Tipo de consulta: 'proximas' o 'historial'

// // Obtener la fecha actual
// $fechaActual = date('Y-m-d');

// try {
//     // Consultar las citas según el tipo y el rol del usuario
//     if ($idAdmin) {
//         // Si es administrador, mostrar todas las citas
//         if ($tipo === 'proximas') {
//             $query = "SELECT fecha, hora, estado, idPacientes FROM Citas WHERE fecha >= ? ORDER BY fecha, hora";
//         } else if ($tipo === 'historial') {
//             $query = "SELECT fecha, hora, estado, idPacientes FROM Citas WHERE fecha < ? ORDER BY fecha DESC, hora DESC";
//         } else {
//             echo json_encode(['success' => false, 'error' => 'Tipo de consulta no válido.']);
//             exit;
//         }
//         $stmt = $conexion->prepare($query);
//         $stmt->bind_param("s", $fechaActual);
//     } else if ($idPaciente) {
//         // Si es paciente, mostrar solo sus citas disponibles
//         if ($tipo === 'proximas') {
//             $query = "SELECT fecha, hora, estado FROM Citas WHERE idPacientes = ? AND fecha >= ? AND bloqueada = 0 ORDER BY fecha, hora";
//         } else if ($tipo === 'historial') {
//             $query = "SELECT fecha, hora, estado FROM Citas WHERE idPacientes = ? AND fecha < ? AND bloqueada = 0 ORDER BY fecha DESC, hora DESC";
//         } else {
//             echo json_encode(['success' => false, 'error' => 'Tipo de consulta no válido.']);
//             exit;
//         }
//         $stmt = $conexion->prepare($query);
//         $stmt->bind_param("ss", $idPaciente, $fechaActual);
//     } else {
//         echo json_encode(['success' => false, 'error' => 'No tienes permisos para ver las citas.']);
//         exit;
//     }

//     $stmt->execute();
//     $result = $stmt->get_result();

//     $citas = [];
//     while ($row = $result->fetch_assoc()) {
//         $citas[] = $row;
//     }

//     echo json_encode(['success' => true, 'citas' => $citas]);
// } catch (Exception $e) {
//     echo json_encode(['success' => false, 'error' => $e->getMessage()]);
//     exit;
// }
?>