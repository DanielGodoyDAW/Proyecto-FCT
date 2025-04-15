<?php
require_once __DIR__ . '/../../conexion/conexion.php';
require_once __DIR__ . '/enviarMail.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Correo inválido.'); window.location.href='/Codigo/index.php';</script>";
        exit;
    }

    // Verifica si el correo existe
    $sql = "SELECT * FROM pacientes WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(32));
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $update = $conexion->prepare("UPDATE pacientes SET token_recuperacion = ?, token_expira = ? WHERE email = ?");
        $update->bind_param("sss", $token, $expira, $email);
        $update->execute();

        $resultadoCorreo = enviarCorreoRecuperacion($email, $token);

        if ($resultadoCorreo === true) {
            echo "<script>alert('Se ha enviado un enlace de recuperación a tu correo.'); window.close();</script>";
        } else {
            echo "<script>alert('Error: $resultadoCorreo'); window.location.href='/Codigo/validaciones/recuperarContra/recuperar_contrasena.html';</script>";
        }
    } else {
        echo "<script>alert('El correo no está registrado.'); window.location.href='/Codigo/validaciones/recuperarContra/recuperar_contrasena.html';</script>";
    }
}
