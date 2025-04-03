<?php
require_once 'conexion.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_FILES['imagen']['name'];

    // Subir la imagen al servidor
    $target_dir = "../imagenes/promociones/";
    $target_file = $target_dir . basename($imagen);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file);

    // Insertar en la base de datos
    $sql = "INSERT INTO promociones (titulo, descripcion, imagen) VALUES ('$titulo', '$descripcion', '$imagen')";
    $conn->query($sql);

    header('Location: ../admin.php');
    exit();
}
?>