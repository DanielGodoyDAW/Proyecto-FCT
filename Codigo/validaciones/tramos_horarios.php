<?php
//simulacion
// filepath: d:\Escritorio\instituto\2 Segundo DAW\Repositorio github\Proyecto FCT\Proyecto-FCT\Codigo\validaciones\tramos_horarios.php

// Obtener los datos enviados desde el cliente
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si se recibió la fecha
if (isset($data['fecha'])) {
    $fechaSeleccionada = $data['fecha']; // Fecha seleccionada (YYYY-MM-DD)

    // Aquí puedes trabajar con la fecha seleccionada
    // Por ejemplo, devolver los tramos horarios disponibles
    $array_tramos_reservaPacientes = array(
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

    // Devolver los tramos horarios como respuesta JSON
    echo json_encode($array_tramos_reservaPacientes);
} else {
    // Si no se recibió la fecha, devolver un error
    echo json_encode(['error' => 'No se recibió la fecha seleccionada']);
}
?>

