<?php
// Conexión a la base de datos
require_once './conexion/conexion.php';

// Obtener los datos enviados por el formulario
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$sexo = $_POST['sexo'];
$password = $_POST['password'];

// Validar los datos (puedes agregar más validaciones según sea necesario)
if (empty($email) || empty($telefono) || empty($sexo)) {
    die('Todos los campos son obligatorios.');
}

// Actualizar los datos en la base de datos
$sql = "UPDATE pacientes SET email = ?, telefono = ?, sexo = ?" . (!empty($password) ? ", password = ?" : "") . " WHERE id = ?";
$stmt = $conexion->prepare($sql);

// Si se envió una nueva contraseña, incluirla en la consulta
if (!empty($password)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param('ssssi', $email, $telefono, $sexo, $hashedPassword, $usuarioId);
} else {
    $stmt->bind_param('sssi', $email, $telefono, $sexo, $usuarioId);
}

if ($stmt->execute()) {
    echo "Perfil actualizado correctamente.";
} else {
    echo "Error al actualizar el perfil: " . $stmt->error;
}