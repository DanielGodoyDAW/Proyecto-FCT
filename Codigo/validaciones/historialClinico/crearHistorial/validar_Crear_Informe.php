<?php
require_once __DIR__ . '/../../../conexion/conexion.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$idHistorial = $_POST['idHistorial'] ?? null;
$fecha = $_POST['fecha'] ?? date('Y-m-d');
$motivo = $_POST['motivo'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$observaciones = $_POST['observaciones'] ?? '';
$dx = $_POST['dx'] ?? '';
$tratamiento = $_POST['tratamiento'] ?? '';
$receta = $_POST['receta'] ?? '';
$archivoRuta = null;

// Validación minima de datos
if (!$idHistorial || !$fecha) {
    echo "<script>alert('Faltan datos obligatorios.');</script>";
}

// Procesar archivo (si se sube uno)


if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    $nombreArchivo = time() . '_' . basename($_FILES['archivo']['name']);

    //si no existe la carpeta, la crea
    $carpetaArchivos = __DIR__ . '/../archivos/';
    if (!file_exists($carpetaArchivos)) {
        mkdir($carpetaArchivos, 0755, true);
    }

    $rutaDestino = $carpetaArchivos . $nombreArchivo;
    move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaDestino);

    $archivoRuta = '../../archivos/' . $nombreArchivo;
}


// Checkboxes
$onicopatias = isset($_POST['onicopatias']) ? 1 : 0;
$queratopatias = isset($_POST['queratopatias']) ? 1 : 0;
$dermatopatias = isset($_POST['dermatopatias']) ? 1 : 0;
$prominenciasOseas = isset($_POST['prominenciasOseas']) ? 1 : 0;
$altDigitales = isset($_POST['altDigitales']) ? 1 : 0;

// Comprobar si ya existe un informe ese mismo día para el historial
$stmt = $conexion->prepare("SELECT COUNT(*) as total FROM Informe WHERE idHistorial = ? AND fecha = ?");
$stmt->bind_param("is", $idHistorial, $fecha);
$stmt->execute();
$res = $stmt->get_result();
$existe = $res->fetch_assoc()['total'] ?? 0;

if ($existe > 0) {
    echo "<script>
        alert('Ya existe un informe para esa fecha.');
        window.history.back();
    </script>";
    exit;
}

// Insertar en la base de datos
$stmt = $conexion->prepare("INSERT INTO Informe (
    idHistorial, fecha, motivo, descripcion, observaciones,
    onicopatias, queratopatias, dermatopatias, prominenciasOseas, altDigitales,
    dx, tratamiento, receta, archivo
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    'isssssiiiiiiss',
    $idHistorial,
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
    $archivoRuta
);

if ($stmt->execute()) {
    header("Location: ./admin.php?mensaje=Informe creado correctamente");
    exit;
} else {
    echo "Error al insertar el informe: " . $stmt->error;
}
