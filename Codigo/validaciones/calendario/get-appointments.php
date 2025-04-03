<?php
$date = $_GET['date'];

// Ejemplo de citas, luego habra que conectar la bd
$appointments = [
    '2025-04-06' => [
        ['time' => '09:00', 'description' => 'Consulta General'],
        ['time' => '11:00', 'description' => 'Revisión Dental']
    ],
    '2025-04-10' => [
        ['time' => '10:00', 'description' => 'Vacunación'],
        ['time' => '14:00', 'description' => 'Consulta Pediátrica']
    ]
];

header('Content-Type: application/json');
echo json_encode(isset($appointments[$date]) ? $appointments[$date] : []);
?>