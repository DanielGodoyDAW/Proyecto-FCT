<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE pacientes SET password = ?, token_recuperacion = NULL, token_expira = NULL WHERE token_recuperacion = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $hashedPassword, $token);
    if ($stmt->execute()) {
        echo "<script>alert('Contraseña restablecida con éxito.'); window.location.href='/Codigo/index.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la contraseña.'); window.history.back();</script>";
    }
}
?>
