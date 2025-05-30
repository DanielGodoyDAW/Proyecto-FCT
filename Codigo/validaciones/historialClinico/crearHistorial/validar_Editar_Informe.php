<?php
require_once __DIR__ . '/../../../conexion/conexion.php';
if (session_status() === PHP_SESSION_NONE) session_start(); // Iniciar sesión si no está iniciada

// Obtener datos del formulario
$idInforme = $_POST['idInforme'] ?? null;
$fecha = $_POST['fecha'] ?? date('Y-m-d');
$motivo = $_POST['motivo'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$observaciones = $_POST['observaciones'] ?? '';
$dx = $_POST['dx'] ?? '';
$tratamiento = $_POST['tratamiento'] ?? '';
$receta = $_POST['receta'] ?? '';
$archivoRuta = null;

// Validación mínima de datos
//si no se envía el idInforme o la fecha, muestra un mensaje de alerta
if (!$idInforme || !$fecha) {
    echo "<script>alert('Faltan datos obligatorios.');</script>";
}

// Procesar archivo (si se sube uno)
if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    $nombreArchivo = basename($_FILES['archivo']['name']);

    //si no existe la carpeta, la crea
    $carpetaArchivos = __DIR__ . '/../archivos/';
    if (!file_exists($carpetaArchivos)) {
        mkdir($carpetaArchivos, 0755, true);
    }

    $rutaDestino = $carpetaArchivos . $nombreArchivo;
    move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaDestino);

    $archivoRuta = 'validaciones/historialClinico/archivos/' . $nombreArchivo;
}

// Checkboxes
$onicopatias = isset($_POST['onicopatias']) ? 1 : 0;
$queratopatias = isset($_POST['queratopatias']) ? 1 : 0;
$dermatopatias = isset($_POST['dermatopatias']) ? 1 : 0;
$prominenciasOseas = isset($_POST['prominenciasOseas']) ? 1 : 0;
$altDigitales = isset($_POST['altDigitales']) ? 1 : 0;

// Consulta UPDATE
$query = "UPDATE Informe SET
    fecha = ?, motivo = ?, descripcion = ?, observaciones = ?,
    onicopatias = ?, queratopatias = ?, dermatopatias = ?, prominenciasOseas = ?, altDigitales = ?,
    dx = ?, tratamiento = ?, receta = ?";

// Si se ha subido un archivo, añadirlo a la consulta
if ($archivoRuta) {
    $query .= ", archivo = ?";
}

$query .= " WHERE idInforme = ?";

$stmt = $conexion->prepare($query);

// Verificar si se ha subido un archivo y ajustar los parámetros de bind_param
if ($archivoRuta) {
    $stmt->bind_param(
        'ssssiiiiissssi',
        $fecha,
        $motivo,
        $descripcion,
        $observaciones,
        $onicopatias,
        $queratopatias,
        $dermatopatias,
        $prominenciasOseas,
        $altDigitales,
        $dx,
        $tratamiento,
        $receta,
        $archivoRuta,
        $idInforme
    );
    // Si no se ha subido un archivo, no incluirlo en los parámetros
} else {
    $stmt->bind_param(
        'ssssiiiiisssi',
        $fecha,
        $motivo,
        $descripcion,
        $observaciones,
        $onicopatias,
        $queratopatias,
        $dermatopatias,
        $prominenciasOseas,
        $altDigitales,
        $dx,
        $tratamiento,
        $receta,
        $idInforme
    );
}

if ($stmt->execute()) {
    header("Location: ../../../admin.php?mensaje=Informe actualizado correctamente");
    exit;
} else {
    echo "Error al actualizar el informe: " . $stmt->error;
}
