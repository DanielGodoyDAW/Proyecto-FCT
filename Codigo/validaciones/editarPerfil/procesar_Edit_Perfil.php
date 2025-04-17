<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';

if (isset($_SESSION['idPacientes'])) {
    $idUsuario = $_SESSION['idPacientes'];
} elseif (isset($_SESSION['idAdmin'])) {
    $idUsuario = $_SESSION['idAdmin'];
}

// Obtén los datos enviados desde el formulario
$email = $_POST['email'] ?? null;
$telefono = $_POST['telefono'] ?? null;
$extension = $_POST['extension'] ?? null; 
$sexo = $_POST['sexo'] ?? null;
$passwordActual = $_POST['passwordActual'] ?? null;
$nuevaContrasena = $_POST['nuevaContrasena'] ?? null;
$confirmarContrasena = $_POST['confirmarContrasena'] ?? null;

// Unificamos el teléfono con la extensión
$telefonoCompleto = $extension . ' ' . $telefono;
error_log("Teléfono completo a guardar: $telefonoCompleto");

// Verifica si se desea cambiar la contraseña
if (!empty($passwordActual) || !empty($nuevaContrasena) || !empty($confirmarContrasena)) {
    // Verifica que las contraseñas coincidan
    if ($nuevaContrasena !== $confirmarContrasena) {
        die('Error: Las contraseñas no coinciden.');
    }

    // Verifica la contraseña actual
    $query = "SELECT pass FROM Pacientes WHERE idPacientes = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $idUsuario);
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
    $stmt->bind_param('si', $hashedPassword, $idUsuario);

    if (!$stmt->execute()) {
        die('Error: No se pudo actualizar la contraseña.');
    }
}

// Actualiza email, teléfono y sexo
$query = "UPDATE Pacientes SET email = ?, telefono = ?, sexo = ? WHERE idPacientes = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('sssi', $email, $telefonoCompleto, $sexo, $idUsuario);

if ($stmt->execute()) {
    // Actualiza el sexo en sesión si aplica
    $_SESSION['sexo'] = $sexo;

    echo '<script>
        alert("Perfil actualizado correctamente.");
        window.location.href = "../../editar_perfil.php";
    </script>';
    exit;
} else {
    die('Error: No se pudo actualizar el perfil.');
}
?>
