<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../conexion/conexion.php'; // Asegúrate de incluir tu conexión a la base de datos

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreoRecuperacion($email, $token) {
    global $conexion; 

    // Consulta para obtener los datos del paciente
    $sql = "SELECT nombre, apellido1, apellido2, sexo FROM pacientes WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $paciente = $result->fetch_assoc();

        // Determinar el saludo segun el sexo
        $saludo = "D."; 
        if ($paciente['sexo'] === 'F') {
            $saludo = "Dña.";
        } elseif ($paciente['sexo'] === 'O') {
            $saludo = "Estimad@";
        }

        $nombreCompleto = "$saludo " . $paciente['nombre'] . " " . $paciente['apellido1'] . " " . $paciente['apellido2'];

        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dgodmed486@g.educaand.es';
            $mail->Password = 'hjoi hosx csoe uqdr';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinatarios
            $mail->setFrom('danielgodoymedina@gmail.com', 'Clínica de Podología Carmen Godoy');
            $mail->addAddress($email); // Dirección del destinatario

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña';
            $mail->Body = "
                <p>$nombreCompleto ha solicitado la recuperación de su contraseña.</p>
                <p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
                <p><a href='http://localhost/Proyecto_FCT/Codigo/validaciones/recuperarContra/restablecer_contrasena.php?token=$token'>Restablecer contraseña</a></p>
                <p>Si no has solicitado este cambio, ignora este mensaje.</p>
            ";

            $mail->send();
            return true; // Correo enviado con éxito
        } catch (Exception $e) {
            return "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        return "No se encontraron datos del paciente con el correo proporcionado.";
    }
}

$resultadoCorreo = enviarCorreoRecuperacion($email, $token);

if ($resultadoCorreo === true) {
    echo "<script>
        alert('Se ha enviado un enlace de recuperación a tu correo.');
        window.location.href = '/Codigo/index.php'; // Redirige al usuario a la página principal
    </script>";
} else {
    echo "<script>
        alert('Hubo un error: $resultadoCorreo');
        window.location.href = '/Codigo/validaciones/recuperarContra/recuperar_contrasena.php'; // Redirige al formulario de recuperación
    </script>";
}

?>