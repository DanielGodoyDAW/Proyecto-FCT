<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? null;
    $nuevaPassword = $_POST['password'] ?? null;

    if (!$token || !$nuevaPassword) {
        echo "Datos incompletos.";
        exit;
    }

    $hash = password_hash($nuevaPassword, PASSWORD_BCRYPT);

    $sql = "UPDATE pacientes SET password = ?, token_recuperacion = NULL, token_expira = NULL WHERE token_recuperacion = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $hash, $token);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Contraseña actualizada correctamente.'); window.location.href='/Codigo/index.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar la contraseña.'); window.history.back();</script>";
    }
}
