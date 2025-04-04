<?php
require_once '../conexion/conexion.php'; // Asegúrate de que la ruta sea correcta
//simulacion
// filepath: d:\Escritorio\instituto\2 Segundo DAW\Repositorio github\Proyecto FCT\Proyecto-FCT\Codigo\validaciones\tramos_horarios.php

// Obtener los datos enviados desde el cliente
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si se recibió la fecha
if (isset($data['fecha'])) {
    $fechaSeleccionada = $data['fecha']; // Fecha seleccionada (YYYY-MM-DD)

    $tramosHorarios = array(
        "08:00" => "08:30",
        "08:30" => "09:00",
        "09:00" => "09:30",
        "09:30" => "10:00",
        "10:00" => "10:30",
        "10:30" => "11:00",
        "11:00" => "11:30",
        "11:30" => "12:00",
        "12:00" => "12:30",
        "12:30" => "13:00",
        "13:00" => "13:30",
        "13:30" => "14:00",
        "16:00" => "16:30",
        "16:30" => "17:00",
        "17:00" => "17:30",
        "17:30" => "18:00",
        "18:00" => "18:30",
        "18:30" => "19:00",
    );

    // Consultar los horarios reservados para la fecha seleccionada
    $query = "SELECT hora FROM Citas WHERE fecha = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $fechaSeleccionada);
    $stmt->execute();
    $result = $stmt->get_result();

    // Crear un array con los horarios reservados
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
    echo json_encode($horariosLibres);
} else {
    // Si no se recibió la fecha, devolver un error
    echo json_encode(['error' => 'No se recibió la fecha seleccionada']);
}
?>

