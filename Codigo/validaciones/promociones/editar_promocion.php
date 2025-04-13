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
    <link rel="stylesheet" href="/Codigo/estilos/styleCalendario.css">
</head>

<body>
    <h2>Editar Promoción</h2>
    <form action="procesar_editar_promocion.php" method="POST">
        <table>
            <tr>
                <td><input type="hidden" name="idPromocion" value="<?php echo htmlspecialchars($idPromocion); ?>"></td>
            </tr>
            <tr>
                <td><label for="titulo">Título:</label></td>
                <td><input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($promocion['titulo']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="descripcion">Descripción:</label></td>
                <td><textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($promocion['descripcion']); ?></textarea></td>
            </tr>
            <tr>
                <td><label for="fechaInicio">Fecha de Inicio:</label></td>
                <td><input type="date" id="fechaInicio" name="fechaInicio" value="<?php echo htmlspecialchars($promocion['fechaInicio']); ?>"></td>
            </tr>
            <tr>
                <td><label for="fechaFin">Fecha de Fin:</label></td>
                <td><input type="date" id="fechaFin" name="fechaFin" value="<?php echo htmlspecialchars($promocion['fechaFin']); ?>"></td>
            </tr>
            <tr>
                <td><label for="descuento">Descuento:</label></td>
                <td><input type="number" id="descuento" name="descuento" value="<?php echo htmlspecialchars($promocion['descuento']); ?>" min="0" max="100"></td>
            </tr>
            <tr>
                <td><button type="submit" class="btnGuardar">Guardar Cambios</button></td>
                <td><button type="button" class="btnCancelar" onclick="window.close()">Cancelar</button></td>
            </tr>
        </table>
    </form>
</body>

</html>