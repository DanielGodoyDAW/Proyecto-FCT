<?php
// Función para encriptar una contraseña
function encriptar_contraseña($contraseña) {
    return password_hash($contraseña, PASSWORD_BCRYPT);
}

// Función para actualizar la contraseña en la base de datos
function actualizar_contraseña($idAdmin, $contraseña_encriptada, $conexion) {
    $sql = "UPDATE Admin SET pass = ? WHERE idAdmin = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $contraseña_encriptada, $idAdmin);
    $stmt->execute();
    $stmt->close();
}

// Ejemplo de uso:
$idAdmin = 1;
$contraseña_original = "Contra+1234";
$contraseña_encriptada = encriptar_contraseña($contraseña_original);

// Conexión a la base de datos (modifica con tus propios datos de conexión)
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
actualizar_contraseña($idAdmin, $contraseña_encriptada, $conexion);

// Cerrar la conexión
$conexion->close();

echo "Contraseña encriptada y actualizada correctamente.";
?>