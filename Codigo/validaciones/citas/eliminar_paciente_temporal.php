<?php
session_start(); 
require_once __DIR__ . '/../../conexion/conexion.php';
require_once __DIR__ . '/../../googleCalendar/google_calendar.php';
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//verificacion extra si no eres admin
if (!isset($_SESSION['idAdmin'])) {
    header("Location: ./citas.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idPacientes'])) {
    $idPaciente = $_POST['idPacientes'];

    // Verificar que sea un paciente temporal
    $stmtCheck = $conexion->prepare("SELECT es_temporal FROM Pacientes WHERE idPacientes = ?");
    $stmtCheck->bind_param("i", $idPaciente);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    $pacienteData = $resultCheck->fetch_assoc();
    $stmtCheck->close();

    if (!$pacienteData || $pacienteData['es_temporal'] != 1) {
        echo '<script>alert("No puedes eliminar pacientes normales desde aquí."); window.location.href = "./citas.php";</script>';
        exit;
    }

    // Obtener el ID del historial del paciente antes de borrar
    $stmt = $conexion->prepare("SELECT idHistorial FROM Pacientes WHERE idPacientes = ?");
    $stmt->bind_param("i", $idPaciente);
    $stmt->execute();
    $stmt->bind_result($idHistorial);
    $stmt->fetch();
    $stmt->close();

    // Buscar todos los eventos de Google Calendar de este paciente
    $stmtEventos = $conexion->prepare("SELECT google_event_id FROM Citas WHERE idPacientes = ?");
    $stmtEventos->bind_param("i", $idPaciente);
    $stmtEventos->execute();
    $resultEventos = $stmtEventos->get_result();

    while ($row = $resultEventos->fetch_assoc()) {
        if (!empty($row['google_event_id'])) {
            try {
                eliminarEventoGoogleCalendar($row['google_event_id']);
            } catch (Exception $e) {
                error_log("Error al eliminar evento de Google Calendar: " . $e->getMessage());
            }
        }
    }
    $stmtEventos->close();

    // Borrar citas asociadas
    $conexion->query("DELETE FROM Citas WHERE idPacientes = $idPaciente");

    // Borrar paciente
    $conexion->query("DELETE FROM Pacientes WHERE idPacientes = $idPaciente");

    // Borrar historial si existe
    if (!empty($idHistorial)) {
        $conexion->query("DELETE FROM Historial WHERE idHistorial = $idHistorial");
    }

    // Enviar correo al admin avisando de la eliminación
    $adminEmail = "danielgodoymedina@gmail.com"; // a futuro Cambiar por el correo real del admin
    $subject = "Paciente Temporal Eliminado";
    $message = "
    <html>
    <head>
      <title>Paciente Temporal Eliminado</title>
    </head>
    <body style='font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;'>
      <div style='background-color: #fff; border-radius: 8px; padding: 20px; max-width: 600px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
        <h2 style='color: #d9534f;'>Paciente Temporal Eliminado</h2>
        <p>Se ha eliminado el paciente temporal con ID <strong>$idPaciente</strong> del sistema.</p>
        <p>Se han cancelado todas sus citas en Google Calendar si existían.</p>
        <br>
        <p style='color: #777;'>Este es un correo informativo automático. No respondas a este mensaje.</p>
      </div>
    </body>
    </html>";

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dgodmed486@g.educaand.es'; 
        $mail->Password = 'hjoi hosx csoe uqdr'; // Contraseña de app
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('danielgodoymedina@gmail.com', 'Clinica de Podologia Carmen Godoy');
        $mail->addAddress($adminEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
    } catch (Exception $e) {
        error_log("Error al enviar correo de eliminación: " . $mail->ErrorInfo);
    }

    header("Location: ./citas.php?mensaje=Paciente+temporal+eliminado");
    exit;
} else {
    echo "Acceso denegado.";
}
?>
