<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../conexion/conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreoRecuperacion($email, $token) {
    global $conexion;

    $sql = "SELECT nombre, apellido1, apellido2, sexo FROM pacientes WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $paciente = $result->fetch_assoc();

        $saludo = "D.";
        if ($paciente['sexo'] === 'F') $saludo = "Dña.";
        elseif ($paciente['sexo'] === 'O') $saludo = "Estimad@";

        $nombreCompleto = "$saludo {$paciente['nombre']} {$paciente['apellido1']} {$paciente['apellido2']}";

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dgodmed486@g.educaand.es';
            $mail->Password = 'hjoi hosx csoe uqdr'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('danielgodoymedina@gmail.com', 'Clínica de Podología Carmen Godoy');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña';

            // Usa URL encode por si acaso
            $tokenEncoded = urlencode($token);

            $mail->Body = "
                <p>$nombreCompleto ha solicitado la recuperación de su contraseña.</p>
                <p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
                <p><a href='http://localhost/Proyecto_FTC/Proyecto_FCT/Codigo/validaciones/recuperarContra/restablecer_contrasena.php?token=$tokenEncoded'>Restablecer contraseña</a></p>
                <p>Si no has solicitado este cambio, ignora este mensaje.</p>";

            $mail->send();
            return true;

        } catch (Exception $e) {
            return "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        return "No se encontraron datos del paciente con el correo proporcionado.";
    }
}
