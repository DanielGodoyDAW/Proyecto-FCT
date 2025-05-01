<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idPromocion'])) {
    $idPromocion = intval($_POST['idPromocion']); // para asegurar de que el ID sea un número entero
    $sql = "DELETE FROM promociones WHERE idPromocion = ?"; // Consulta para eliminar la promoción (servicio)
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idPromocion);

    if ($stmt->execute()) {
        header("Location: /Codigo/admin.php?mensaje=Promoción eliminada correctamente");
    } else {
        header("Location: /Codigo/admin.php?mensaje=Error al eliminar la promoción");
    }
    exit;
} else {
    header("Location: /Codigo/admin.php?mensaje=ID de promoción no proporcionado");
    exit;
}
?>