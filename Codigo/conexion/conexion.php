<?php 
$host = "localhost"; // Nombre del host
$user = "root"; // Usuario de la base de datos
$password = ""; // Contraseña de la base de datos
$db = "clinica_podologia"; // Nombre de la base de datos clinica_podologia

// Crear la conexión
$con = new mysqli($host, $user, $password, $db);

// Verificar la conexión
if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}
?>