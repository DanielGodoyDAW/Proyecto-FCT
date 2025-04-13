<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if (isset($_GET['idPromocion'])) {
    $idPromocion = intval($_GET['idPromocion']);
    $sql = "DELETE FROM promociones WHERE idPromocion = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idPromocion);

    if ($stmt->execute()) {
        echo "Promoción eliminada correctamente.";
    } else {
        echo "Error al eliminar la promoción.";
    }
} else {
    echo "ID de promoción no proporcionado.";
}
?>