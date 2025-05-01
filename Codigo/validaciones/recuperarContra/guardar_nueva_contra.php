<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si el token y las contraseñas están presentes
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    // Validar los campos
    if (empty($token) || empty($password) || empty($confirm)) {
        echo "<script>alert('Todos los campos son obligatorios.'); window.history.back();</script>";
        exit;
    }

    // Si la contraseña no es identica a la confirmación, mostrar un mensaje de error
    if ($password !== $confirm) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
        exit;
    }

    // Verificar si el token es válido y no ha expirado
    $sql = "SELECT * FROM pacientes WHERE token_recuperacion = ? AND token_expira > NOW()";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si no se encuentra el token o ha expirado, mostrar un mensaje de error
    if ($result->num_rows === 0) {
        echo "<script>alert('Token inválido o expirado.'); window.location.href='/Codigo/index.php';</script>";
        exit;
    }

    // Si el token es válido, proceder a actualizar la contraseña
    $hash = password_hash($password, PASSWORD_BCRYPT);

    // Actualizar la contraseña en la base de datos
    $update = $conexion->prepare("UPDATE pacientes SET pass = ?, token_recuperacion = NULL, token_expira = NULL WHERE token_recuperacion = ?");
    $update->bind_param("ss", $hash, $token);
    $update->execute();

    echo "<script>alert('Contraseña restablecida correctamente.'); window.location.href='http://localhost:3000/Codigo/index.php';</script>";
}
