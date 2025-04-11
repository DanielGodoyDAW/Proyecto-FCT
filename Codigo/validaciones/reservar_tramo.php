<?php
session_start();
require_once __DIR__ . '/../conexion/conexion.php';
require_once __DIR__ . '/tramos_horarios.php'; // Incluir los tramos horarios

header('Content-Type: application/json');

// Comprobamos si hay sesión activa
if (!isset($_SESSION['idPacientes']) && !isset($_SESSION['idAdmin'])) {
    echo json_encode(['success' => false, 'error' => 'Debes iniciar sesión para reservar un tramo.']);
    exit;
}

// Asignar el ID del paciente o el administrador
$idPaciente = isset($_SESSION['idPacientes']) ? $_SESSION['idPacientes'] : null;
$idAdmin = isset($_SESSION['idAdmin']) ? $_SESSION['idAdmin'] : null;

// Si es el administrador, marcar la cita como bloqueada
$bloqueada = ($idAdmin && !$idPaciente) ? 1 : 0;

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['fecha']) || !isset($data['hora'])) {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos.']);
    exit;
}

$fecha = $data['fecha'];
$hora = $data['hora'];

// Verificar que el tramo esté libre (excluir horarios bloqueados)
$query = "SELECT COUNT(*) AS total FROM Citas WHERE fecha = ? AND hora = ? AND bloqueada = 1";
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
$insert = "INSERT INTO Citas (fecha, hora, estado, idPacientes, idAdmin, bloqueada) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($insert);
$stmt->bind_param("sssiii", $fecha, $hora, $estado, $idPaciente, $idAdmin, $bloqueada);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'mensaje' => '¡Cita reservada con éxito!']);
} else {
    echo json_encode(['success' => false, 'error' => 'Error al guardar la cita en la base de datos.']);
}

// Verificar si se recibió la fecha
if (!isset($_GET['fecha'])) {
    echo json_encode(['success' => false, 'error' => 'Fecha no especificada.']);
    exit;
}

$fechaSeleccionada = $_GET['fecha']; // Fecha seleccionada (YYYY-MM-DD)

// Obtener los horarios definidos en tramos_horarios.php
$tramosHorarios = array_merge($tramosHorariosManana, $tramosHorariosTarde);

try {
    // Consultar los horarios reservados o bloqueados para la fecha seleccionada
    $query = "SELECT hora FROM Citas WHERE fecha = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $fechaSeleccionada);
    $stmt->execute();
    $result = $stmt->get_result();

    // Crear un array con los horarios reservados o bloqueados
    $horariosReservados = [];
    while ($row = $result->fetch_assoc()) {
        $horariosReservados[] = $row['hora'];
    }

    // Filtrar los horarios disponibles
    $horariosLibres = [];
    foreach ($tramosHorarios as $inicio => $fin) {
        if (!in_array($inicio, $horariosReservados)) {
            $horariosLibres[$inicio] = $fin;
        }
    }

    // Devolver los horarios libres como respuesta JSON
    echo json_encode(['success' => true, 'horariosLibres' => $horariosLibres]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>