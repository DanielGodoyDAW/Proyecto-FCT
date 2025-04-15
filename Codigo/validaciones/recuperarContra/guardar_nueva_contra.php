<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($token) || empty($password) || empty($confirm)) {
        echo "<script>alert('Todos los campos son obligatorios.'); window.history.back();</script>";
        exit;
    }

    if ($password !== $confirm) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
        exit;
    }

    $sql = "SELECT * FROM pacientes WHERE token_recuperacion = ? AND token_expira > NOW()";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Token inválido o expirado.'); window.location.href='/Codigo/index.php';</script>";
        exit;
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);

    $update = $conexion->prepare("UPDATE pacientes SET contrasena = ?, token_recuperacion = NULL, token_expira = NULL WHERE token_recuperacion = ?");
    $update->bind_param("ss", $hash, $token);
    $update->execute();

    echo "<script>alert('Contraseña restablecida correctamente.'); window.location.href='/Codigo/index.php';</script>";
}
