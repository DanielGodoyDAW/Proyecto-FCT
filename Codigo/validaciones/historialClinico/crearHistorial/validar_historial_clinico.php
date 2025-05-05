<?php
require_once __DIR__ . '/../../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPaciente = $_POST['idPaciente'] ?? null;
    if (!$idPaciente) {
        die("ID de paciente no proporcionado.");
    }

    // Recoger datos del formulario
    $motivo = $_POST['motivo'] ?? '';
    $antec_podologicos = $_POST['antec_podologicos'] ?? '';
    $antec_quirurgicos = $_POST['antec_quirurgicos'] ?? '';
    $antecedentes = $_POST['antecedentes'] ?? '';
    $alergias = $_POST['alergias'] ?? '';
    $farmacologia = $_POST['farmacologia'] ?? '';
    $desarrolloPSi = $_POST['desarrolloPSi'] ?? '';
    $observaciones = $_POST['observaciones'] ?? '';
    $dx = $_POST['dx'] ?? '';
    $tratamiento = $_POST['tratamiento'] ?? '';
    $receta = $_POST['receta'] ?? '';
    $fecha = $_POST['fecha'] ?? null;
    $seguimiento = $_POST['seguimiento'] ?? '';
    $patologias = isset($_POST['patologias']) ? implode(',', $_POST['patologias']) : '';

    // Checkboxes binarios
    $onicopatias = isset($_POST['onicopatias']) ? 1 : 0;
    $queratopatias = isset($_POST['queratopatias']) ? 1 : 0;
    $dermatopatias = isset($_POST['dermatopatias']) ? 1 : 0;
    $prominenciasOseas = isset($_POST['prominenciasOseas']) ? 1 : 0;
    $altDigitales = isset($_POST['altDigitales']) ? 1 : 0;

    // Manejo de archivo
    $archivo = null;
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = basename($_FILES['archivo']['name']);
        $directorioDestino = __DIR__ . '/../historiales/';
        $rutaDestino = $directorioDestino . $nombreArchivo;

        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0777, true);
        }

        if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaDestino)) {
            $archivo = $nombreArchivo;
        }
    }

    // Inserción a la base de datos
    $stmt = $conexion->prepare("INSERT INTO Historial (
        idPaciente, motivo, antec_podologicos, antec_quirurgicos, patologias,
        antecedentes, alergias, farmacologia, desarrolloPSi, observaciones,
        archivo, onicopatias, queratopatias, dermatopatias, prominenciasOseas,
        altDigitales, dx, tratamiento, receta, fecha, seguimiento
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "isssssssssssiiisssss",
        $idPaciente, $motivo, $antec_podologicos, $antec_quirurgicos, $patologias,
        $antecedentes, $alergias, $farmacologia, $desarrolloPSi, $observaciones,
        $archivo, $onicopatias, $queratopatias, $dermatopatias, $prominenciasOseas,
        $altDigitales, $dx, $tratamiento, $receta, $fecha, $seguimiento
    );

    if ($stmt->execute()) {
        echo "<p>✅ Historial guardado correctamente.</p>";
        echo '<a href="/admin.php">Volver</a>';
    } else {
        echo "<p>❌ Error al guardar historial: " . $stmt->error . "</p>";
    }
}
?>
