<?php
// filepath: d:\Escritorio\instituto\2 Segundo DAW\Repositorio github\Proyecto FCT\Proyecto-FCT\Codigo\validaciones\calendario\get-availability.php

header('Content-Type: application/json');
require_once '../conexion.php'; // Asegúrate de que la conexión a la base de datos esté configurada correctamente

// Consulta para obtener la disponibilidad de los días
$query = "
    SELECT fecha, 
           CASE 
               WHEN COUNT(*) = 0 THEN 'available' 
               WHEN COUNT(*) < 5 THEN 'partial' 
               ELSE 'full' 
           END AS status
    FROM citas
    GROUP BY fecha
";

$result = $conn->query($query);

$availability = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $availability[] = [
            'date' => $row['fecha'], // Fecha del día
            'status' => $row['status'] // Estado del día (available, partial, full)
        ];
    }
}

// Devolver los datos en formato JSON
echo json_encode($availability);
?>