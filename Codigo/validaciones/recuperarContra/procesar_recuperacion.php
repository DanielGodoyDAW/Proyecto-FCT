<?php
require_once __DIR__ . '/../../conexion/conexion.php';
require_once __DIR__ . '/enviarMail.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Verifica si el campo de correo está vacío
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Correo inválido.'); window.location.href='../../index.php';</script>";
        exit;
    }

    // Verifica si el correo existe
    $sql = "SELECT * FROM pacientes WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(32)); // Genera un token aleatorio
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour")); // Establece la expiración del token a 1 hora

        $update = $conexion->prepare("UPDATE pacientes SET token_recuperacion = ?, token_expira = ? WHERE email = ?");
        $update->bind_param("sss", $token, $expira, $email);
        $update->execute();

        $resultadoCorreo = enviarCorreoRecuperacion($email, $token); // Llama a la función para enviar el correo

        if ($resultadoCorreo === true) {
            echo "<script>alert('Se ha enviado un enlace de recuperación a tu correo.'); window.location.href='../../index.php'</script>";
        } else {
            echo "<script>alert('Error: $resultadoCorreo'); window.location.href='../../index.php?recuperar=true';</script>";
        }
    } else {
        echo "<script>alert('El correo no está registrado.'); window.location.href='../../index.php?recuperar=true';</script>";
    }
}
