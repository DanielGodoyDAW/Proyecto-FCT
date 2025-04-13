<?php
require_once __DIR__ . '/../../conexion/conexion.php'; 

$idPromocion = $_GET['idPromocion'] ?? null;

if (!$idPromocion) {
    die('Error: ID de promoción no proporcionado.');
}

// Obtener los datos de la promoción
$query = "SELECT titulo, descripcion, fechaInicio, fechaFin, descuento FROM promociones WHERE idPromocion = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $idPromocion);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Error: Promoción no encontrada.');
}

$promocion = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Promoción</title>
    <link rel="stylesheet" href="/Codigo/estilos/stylePromo.css">
</head>
<body>
    <h2>Editar Promoción</h2>
    <form action="procesar_editar_promocion.php" method="POST">
        <input type="hidden" name="idPromocion" value="<?php echo htmlspecialchars($idPromocion); ?>">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($promocion['titulo']); ?>" required>
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($promocion['descripcion']); ?></textarea>
        <label for="fechaInicio">Fecha de Inicio:</label>
        <input type="date" id="fechaInicio" name="fechaInicio" value="<?php echo htmlspecialchars($promocion['fechaInicio']); ?>">
        <label for="fechaFin">Fecha de Fin:</label>
        <input type="date" id="fechaFin" name="fechaFin" value="<?php echo htmlspecialchars($promocion['fechaFin']); ?>">
        <label for="descuento">Descuento:</label>
        <input type="number" id="descuento" name="descuento" value="<?php echo htmlspecialchars($promocion['descuento']); ?>" min="0" max="100">
        <button type="submit">Guardar Cambios</button>
        <button type="button" onclick="window.close()">Cancelar</button>
    </form>
</body>
</html>