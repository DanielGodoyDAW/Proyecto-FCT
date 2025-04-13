<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['idPacientes'])) {
    die('Error: Usuario no autenticado.');
}

$idPaciente = $_SESSION['idPacientes'];

// Obtén los datos enviados desde el formulario
$passwordActual = $_POST['passwordActual'] ?? null;
$nuevaContrasena = $_POST['nuevaContrasena'] ?? null;
$confirmarContrasena = $_POST['confirmarContrasena'] ?? null;

// Verifica que las contraseñas coincidan
if ($nuevaContrasena !== $confirmarContrasena) {
    die('Error: Las contraseñas no coinciden.');
}

// Verifica la contraseña actual
$query = "SELECT pass FROM Pacientes WHERE idPacientes = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $idPaciente);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Error: Usuario no encontrado.');
}

$usuario = $result->fetch_assoc();
if (!password_verify($passwordActual, $usuario['pass'])) {
    die('Error: La contraseña actual es incorrecta.');
}

// Actualiza la contraseña en la base de datos
$hashedPassword = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
$query = "UPDATE Pacientes SET pass = ? WHERE idPacientes = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('si', $hashedPassword, $idPaciente);

if ($stmt->execute()) {
    echo '<script>alert("Contraseña cambiada exitosamente."); window.close();</script>';
} else {
    die('Error: No se pudo actualizar la contraseña.');
}
?>