<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../conexion/conexion.php';

$idAdmin = $_SESSION['idAdmin'];

// Variables obtenidas del formulario
$paciente = isset($_POST['paciente']) ? $_POST['paciente'] : ''; // ID del paciente de la búsqueda rápida
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$apellido1 = isset($_POST['apellido1']) ? $_POST['apellido1'] : '';
$apellido2 = isset($_POST['apellido2']) ? $_POST['apellido2'] : '';
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';

// Si se selecciona un paciente en la búsqueda rápida, ignorar los demás campos
if (!empty($paciente)) {
    $query = "SELECT * FROM Pacientes WHERE idPacientes = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $paciente);
} else {
    // Construir la consulta dinámica si no se selecciona un paciente en la búsqueda rápida
    $query = "SELECT * FROM Pacientes WHERE idPacientes != ?";
    $params = [$idAdmin];
    $types = "i";

    if (!empty($nombre)) {
        $query .= " AND nombre = ?";
        $params[] = $nombre;
        $types .= "s";
    }

    if (!empty($apellido1)) {
        $query .= " AND apellido1 = ?";
        $params[] = $apellido1;
        $types .= "s";
    }

    if (!empty($apellido2)) {
        $query .= " AND apellido2 = ?";
        $params[] = $apellido2;
        $types .= "s";
    }

    if (!empty($telefono)) {
        $query .= " AND telefono = ?";
        $params[] = $telefono;
        $types .= "s";
    }

    $stmt = $conexion->prepare($query);
    $stmt->bind_param($types, ...$params);
}

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();

// Generar el contenido para el div
$impresion = '';
if ($result->num_rows > 0) {
    $impresion .= '<h2>Datos del paciente:</h2>';
    while ($row = $result->fetch_assoc()) {
        $impresion .= '<ul>';
        foreach ($row as $key => $value) {
            // Excluir la columna "contraseña"
            if ($key === 'pass') {
                continue;
            }
            $impresion .= '<li><strong>' . ucfirst($key) . ':</strong> ' . htmlspecialchars($value) . '</li>';
        }
        $impresion .= '</ul>';
    }
} else {
    $impresion .= '<p>No se encontraron pacientes con los datos proporcionados.</p>';
}

// Guardar los resultados en la sesión y redirigir
$_SESSION['impresion'] = $impresion;
header('Location: /Codigo/admin.php');
exit;
?>
