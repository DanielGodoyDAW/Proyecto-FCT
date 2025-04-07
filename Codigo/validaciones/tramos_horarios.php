<?php
require_once __DIR__ . '/../conexion/conexion.php';
// Obtener los datos enviados desde el cliente
$data = json_decode(file_get_contents('php://input'), true);
$rawData = file_get_contents('php://input');
file_put_contents('debug.log', $rawData, FILE_APPEND);

// Depuración: Guardar los datos recibidos en debug.log
file_put_contents('debug.log', print_r($data, true), FILE_APPEND);

// Verificar si se recibió la fecha
if (isset($data['fecha'])) {
    
    $fechaSeleccionada = $data['fecha']; // Fecha seleccionada (YYYY-MM-DD)

    // Obtener el dia de la semana (0 = domingo, 1 = lunes, ..., 6 = sábado)
    $diaSemana = date('w', strtotime($fechaSeleccionada));

    // Si es sábado (6) o domingo (0), devolver un mensaje
    if ($diaSemana == 0 || $diaSemana == 6) {
        echo json_encode(['error' => 'No hay horarios disponibles para esta fecha']);
        exit();
    }

    $tramosHorariosManana = array(
    
        "09:00" => "09:30",
        "09:30" => "10:00",
        "10:00" => "10:30",
        "10:30" => "11:00",
        "11:00" => "11:30",
        "11:30" => "12:00",
        "12:00" => "12:30",
        "12:30" => "13:00",
        "13:00" => "13:30",
        
    );
    $tramosHorariosTarde = array(
        "16:00" => "16:30",
        "16:30" => "17:00",
        "17:00" => "17:30",
        "17:30" => "18:00",
        "18:00" => "18:30",
        "18:30" => "19:00",
       
    );

    // Si es viernes (5), eliminar los horarios de la tarde
    if ($diaSemana == 5) {
        $tramosHorariosTarde = [];
    }

    $tramosHorarios = array_merge($tramosHorariosManana, $tramosHorariosTarde);

    // Consultar los horarios reservados para la fecha seleccionada
    $query = "SELECT hora FROM Citas WHERE fecha = ?";
    $stmt = $conexion->prepare($query);
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

