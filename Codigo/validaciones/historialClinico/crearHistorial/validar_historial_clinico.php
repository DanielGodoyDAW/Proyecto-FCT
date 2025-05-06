<?php
require_once __DIR__ . '/../../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPaciente = $_POST['idPaciente'] ?? null;
    if (!$idPaciente) {
        die("ID de paciente no proporcionado.");
    }

    $campos = [
        'motivo', 'antec_podologicos', 'antec_quirurgicos', 'patologias',
        'antecedentes', 'alergias', 'farmacologia', 'desarrolloPSi', 'observaciones',
        'archivo', 'onicopatias', 'queratopatias', 'dermatopatias', 'prominenciasOseas',
        'altDigitales', 'dx', 'tratamiento', 'receta', 'fecha', 'seguimiento'
    ];

    $valores = ['idPaciente'];
    $marcadores = ['?'];
    $tipos = 'i'; // idPaciente es int
    $datos = [$idPaciente];

    foreach ($campos as $campo) {
        if (isset($_POST[$campo])) {
            $valores[] = $campo;
            $marcadores[] = '?';
            $datos[] = $_POST[$campo];
            $tipos .= is_int($_POST[$campo]) ? 'i' : 's';
        } elseif (in_array($campo, ['onicopatias', 'queratopatias', 'dermatopatias', 'prominenciasOseas', 'altDigitales'])) {
            // checkboxes no enviados los marcamos como 0
            $valores[] = $campo;
            $marcadores[] = '?';
            $datos[] = 0;
            $tipos .= 'i';
        }
    }

    $sql = "INSERT INTO Historial (" . implode(', ', $valores) . ") VALUES (" . implode(', ', $marcadores) . ")";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación: " . $conexion->error);
    }

    $stmt->bind_param($tipos, ...$datos);

    if ($stmt->execute()) {
        echo "Historial guardado correctamente.";
    } else {
        echo "Error al guardar historial: " . $stmt->error;
    }
}
?>
