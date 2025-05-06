<?php
require_once __DIR__ . '/../../conexion/conexion.php';

$idPromocion = $_GET['idPromocion'] ?? null; //usamos el get, para recogerlos del formulario de js

if (!$idPromocion) {
    die('Error: ID de promoción no proporcionado.');
}

// Obtener los datos de la promoción (Servicio)
$query = "SELECT titulo, descripcion, duracion, imagen FROM promociones WHERE idPromocion = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $idPromocion);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Error: Servicio no encontrado.');
}

$promocion = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Promoción</title>
    <link rel="stylesheet" href="/Codigo/estilos/stylePromo.css">
    <link rel="stylesheet" href="/Codigo/estilos/styleColores.css">
</head>

<body>
    <h2>Editar Servicio</h2>
    <div class="form-container">
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
                    <td><label for="duracion">Duracion:</label></td>
                    <td><input type="text" id="duracion" name="duracion" value="<?php echo htmlspecialchars($promocion['duracion']); ?>"></td>
                </tr>
                <tr>
                    <td><label for="imagen">Imagen:</label></td>
                    <td><input type="file" id="imagen" name="imagen" accept="image/*"></td>
                </tr>
                <tr>
                    <td colspan="2"><label for="imagen">Imagen Actual:</label></td>
                    <td colspan="2">
                        <?php if (!empty($promocion['imagen'])) { ?>
                            <img src="<?php echo '/Codigo' . htmlspecialchars($promocion['imagen']); ?>" alt="Imagen de la promoción" style="max-width: 100px; max-height: 100px;">
                        <?php } else { ?>
                            Sin imagen
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td><button type="submit" class="btnGuardar">Guardar</button></td>
                    <td><button type="button" class="btnCancelar" onclick="window.close()">Cancelar</button></td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>