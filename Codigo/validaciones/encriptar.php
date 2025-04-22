<?php
// Plantilla copiada de internet y modificada con mis datos para poder actualizar la bd con la contraseña encriptada
// Función para encriptar una contraseña
function encriptar_contraseña($contrasena) {
    return password_hash($contrasena, PASSWORD_BCRYPT);
}

// Función para actualizar la contraseña en la base de datos
function actualizar_contraseña($idAdmin, $contrasena_encriptada, $conexion) {
    $sql = "UPDATE Admin SET pass = ? WHERE idAdmin = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $contrasena_encriptada, $idAdmin);
    $stmt->execute();
    $stmt->close();
}

// Ejemplo de uso:
$idAdmin = 1;
$contrasena_original = "Contra+1234";
$contrasena_encriptada = encriptar_contraseña($contrasena_original);

// Conexión a la base de datos 
$host = "localhost";
$user = "root";
$pass = "";
$db = "clinica_podologia";
$conexion = new mysqli($host, $user, $pass, $db);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Actualizar la contraseña en la base de datos
actualizar_contraseña($idAdmin, $contrasena_encriptada, $conexion);

// Cerrar la conexión
$conexion->close();

echo "Contraseña encriptada y actualizada correctamente.";
?>