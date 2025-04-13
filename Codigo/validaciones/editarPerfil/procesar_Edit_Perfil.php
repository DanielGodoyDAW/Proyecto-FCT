<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['idPacientes'])) {
    die('Error: Usuario no autenticado.');
}

$idPaciente = $_SESSION['idPacientes'];

// Obtén los datos enviados desde el formulario
$email = $_POST['email'] ?? null;
$telefono = $_POST['telefono'] ?? null;
$sexo = $_POST['sexo'] ?? null; // Obtén directamente el valor de sexo
$passwordActual = $_POST['passwordActual'] ?? null;
$nuevaContrasena = $_POST['nuevaContrasena'] ?? null;
$confirmarContrasena = $_POST['confirmarContrasena'] ?? null;

// Verifica que el valor del sexo sea válido
if (!in_array($sexo, ['H', 'M', 'O'])) {
    die('Error: Valor de sexo no válido.');
}

// Verifica si se desea cambiar la contraseña
if (!empty($passwordActual) || !empty($nuevaContrasena) || !empty($confirmarContrasena)) {
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

    if (!$stmt->execute()) {
        die('Error: No se pudo actualizar la contraseña.');
    }
}

// Actualiza otros campos (correo, telefono y sexo)
$query = "UPDATE Pacientes SET email = ?, telefono = ?, sexo = ? WHERE idPacientes = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('sssi', $email, $telefono, $sexo, $idPaciente);

if ($stmt->execute()) {

    // Actualiza el valor de sexo en la sesión
    $_SESSION['sexo'] = $sexo;
    
    echo '<script>
        alert("Perfil actualizado correctamente.");
        window.location.href = "../../editar_perfil.php"; // Redirigir después de mostrar el alert
    </script>';
    exit; 
} else {
    die('Error: No se pudo actualizar el perfil.');
}
?>