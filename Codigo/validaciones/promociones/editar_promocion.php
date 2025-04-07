<?php
//require_once './conexion/conexion.php'; // Conexión a la base de datos

$id = $_GET['id'];
$sql = "SELECT * FROM promociones WHERE idPromocion = $id";
$result = $conexion->query($sql);
$promocion = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_FILES['imagen']['name'];

    if ($imagen) {
        $target_dir = "../imagenes/promociones/";
        $target_file = $target_dir . basename($imagen);
        move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file);

        $sql = "UPDATE promociones SET titulo = '$titulo', descripcion = '$descripcion', imagen = '$imagen' WHERE idPromocion = $id";
    } else {
        $sql = "UPDATE promociones SET titulo = '$titulo', descripcion = '$descripcion' WHERE idPromocion = $id";
    }

    $conn->query($sql);
    header('Location: ../admin.php');
    exit();
}
?>

<form action="" method="POST" enctype="multipart/form-data">
    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo" value="<?php echo $promocion['titulo']; ?>" required>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion" required><?php echo $promocion['descripcion']; ?></textarea>

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" name="imagen" accept="image/*">

    <button type="submit">Guardar Cambios</button>
</form>