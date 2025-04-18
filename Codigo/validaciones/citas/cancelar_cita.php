<?php
session_start(); // Asegúrate de que la sesión está iniciada si usas $_SESSION

require_once __DIR__ . '/../../conexion/conexion.php';
require_once __DIR__ . '/../../googleCalendar/google_calendar.php';
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Eliminar evento de Google Calendar
function eliminarEventoGoogleCalendar($eventId)
{
    if (empty($eventId)) {
        throw new Exception("El ID del evento no puede estar vacío.");
    }

    $client = getClient();
    $service = new Google_Service_Calendar($client);
    $calendarId = 'danielgodoymedina@gmail.com';

    try {
        $service->events->delete($calendarId, $eventId);
    } catch (Exception $e) {
        throw new Exception("No se pudo eliminar el evento de Google Calendar: " . $e->getMessage());
    }
}

// Procesar cancelación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idCita'])) {
    $idCita = $_POST['idCita'];

    // Obtener info de la cita
    $stmt = $conexion->prepare("SELECT google_event_id, fecha, hora FROM Citas WHERE idCita = ?");
    $stmt->bind_param("i", $idCita);
    $stmt->execute();
    $result = $stmt->get_result();
    $eventData = $result->fetch_assoc();

    $googleEventId = $eventData['google_event_id'] ?? null;
    $fechaCita = $eventData['fecha'] ?? 'Desconocida';
    $horaCita = $eventData['hora'] ?? 'Desconocida';

    // Verificar si faltan menos de 24 horas para la cita | a futuro agregar el pago de un porcentaje
    $fechaHoraCita = new DateTime($fechaCita . ' ' . $horaCita);
    $fechaHoraActual = new DateTime();

    $diferencia = $fechaHoraActual->diff($fechaHoraCita);

    if ($fechaHoraActual > $fechaHoraCita || $diferencia->days < 1) {
        echo '<script>
            alert("No puedes cancelar una cita con menos de 24 horas de antelación.");
            window.location.href = "/Codigo/citas.php";
        </script>';
        exit;
    }

    // Obtener nombre del paciente
    $paciente = 'Desconocido';
    if (isset($_SESSION['idPacientes'])) {
        $stmt = $conexion->prepare("SELECT CONCAT(nombre, ' ', apellido1, ' ', apellido2) AS nombreCompleto FROM Pacientes WHERE idPacientes = ?");
        $stmt->bind_param("i", $_SESSION['idPacientes']);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuarioData = $result->fetch_assoc();
        $paciente = $usuarioData['nombreCompleto'] ?? 'Paciente desconocido';
    }

    // Borrar la cita
    $stmt = $conexion->prepare("DELETE FROM Citas WHERE idCita = ?");
    $stmt->bind_param("i", $idCita);

    if ($stmt->execute()) {
        // Eliminar evento de Google Calendar
        if (!empty($googleEventId)) {
            try {
                eliminarEventoGoogleCalendar($googleEventId);
            } catch (Exception $e) {
                error_log("Error al eliminar evento de Google Calendar: " . $e->getMessage());
            }
        }

        // Preparar y enviar correo
        $adminEmail = "danielgodoymedina@gmail.com";
        $subject = "Cancelación de cita (ID: $idCita)";
        $message = "
        <html>
        <head>
          <title>Cita Cancelada</title>
        </head>
        <body style='font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;'>
          <div style='background-color: #fff; border-radius: 8px; padding: 20px; max-width: 600px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
            <h2 style='color: #d9534f;'>Cita Cancelada</h2>
            <p>Se ha cancelado la cita con el ID <strong>$idCita</strong>.</p>
            <p><strong>Fecha:</strong> $fechaCita</p>
            <p><strong>Hora:</strong> $horaCita</p>
            <p><strong>Cancelada por:</strong> $paciente</p>";

        if (!empty($googleEventId)) {
            $message .= "<p>El evento en Google Calendar (ID: <code>$googleEventId</code>) fue eliminado.</p>";
        } else {
            $message .= "<p>No se encontró un evento de Google Calendar asociado a esta cita.</p>";
        }

        $message .= "
            <br>
            <p style='color: #777;'>Este correo es solo informativo. No respondas a este mensaje.</p>
          </div>
        </body>
        </html>";

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dgodmed486@g.educaand.es';
            $mail->Password = 'hjoi hosx csoe uqdr'; // Contraseña de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('danielgodoymedina@gmail.com', 'Clinica de Podologia Carmen Godoy');
            $mail->addAddress($adminEmail);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar el correo: " . $mail->ErrorInfo);
        }
    }

    // Limpiar cualquier salida y redirigir
    ob_clean();
    header("Location: /Codigo/citas.php");
    exit();
}
?>
