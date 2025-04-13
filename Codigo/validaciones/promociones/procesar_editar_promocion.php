<?php
require_once __DIR__ . '/../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPromocion = $_POST['idPromocion'] ?? null;
    $titulo = $_POST['titulo'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $fechaInicio = $_POST['fechaInicio'] ?? null;
    $fechaFin = $_POST['fechaFin'] ?? null;
    $descuento = $_POST['descuento'] ?? null;

    if (!$idPromocion) {
        die('Error: ID de promoción no proporcionado.');
    }

    // Actualizar los datos en la base de datos
    $query = "UPDATE promociones SET titulo = ?, descripcion = ?, fechaInicio = ?, fechaFin = ?, descuento = ? WHERE idPromocion = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('sssssi', $titulo, $descripcion, $fechaInicio, $fechaFin, $descuento, $idPromocion);

    if ($stmt->execute()) {
        echo '<script>
            alert("Promoción actualizada correctamente.");
            window.close();
            window.opener.location.reload();
        </script>';
    } else {
        echo '<script>alert("Error al actualizar la promoción.");</script>';
    }
}
?>