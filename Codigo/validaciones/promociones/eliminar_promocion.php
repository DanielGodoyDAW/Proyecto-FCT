<?php
require_once './conexion/conexion.php'; // Conexión a la base de datos

$id = $_GET['id'];
$sql = "DELETE FROM promociones WHERE id = $id";
$conexion->query($sql);

header('Location: ../admin.php');
exit();
?>