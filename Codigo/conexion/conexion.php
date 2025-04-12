<?php 
$host = "localhost"; // Nombre del host
$user = "root"; // Usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$db = "clinica_podologia"; // Nombre de la base de datos clinica_podologia

// Crear la conexión
$conexion = new mysqli($host, $user, $password, $db,3310); //conexion sobremesa
//$conexion = new mysqli($host, $user, $password, $db); //conexion portatil

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>