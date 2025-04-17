<?php
require_once __DIR__ . '/../../conexion/conexion.php';
require_once __DIR__ . '/../../googleCalendar/google_calendar.php'; // Para usar getClient()
require_once __DIR__ . '/../../../vendor/autoload.php'; // Asegúrate de que esté cargado

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Eliminar el evento de Google Calendar
function eliminarEventoGoogleCalendar($eventId)
{
    if (empty($eventId)) {
        throw new Exception("El ID del evento no puede estar vacío.");
    }

    $client = getClient(); // Obtiene el cliente autenticado
    $service = new Google_Service_Calendar($client);

    $calendarId = 'danielgodoymedina@gmail.com'; // Mismo calendario usado en crearEvento()

    try {
        $service->events->delete($calendarId, $eventId);
    } catch (Exception $e) {
        throw new Exception("No se pudo eliminar el evento de Google Calendar: " . $e->getMessage());
    }
}

// Cuando se envía el formulario de cancelación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idCita'])) {
    $idCita = $_POST['idCita'];

    //Obtener el ID del evento de Google Calendar antes de borrar la cita
    $query = "SELECT google_event_id FROM Citas WHERE idCita = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $idCita);
    $stmt->execute();
    $result = $stmt->get_result();
    $eventData = $result->fetch_assoc();
    $googleEventId = $eventData['google_event_id'] ?? null;

    //Eliminar la cita de la base de datos
    $query = "DELETE FROM Citas WHERE idCita = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $idCita);

    if ($stmt->execute()) {

        //Eliminar también el evento de Google Calendar si existe
        if (!empty($googleEventId)) {
            try {
                eliminarEventoGoogleCalendar($googleEventId);
            } catch (Exception $e) {
                error_log("Error al eliminar evento de Google Calendar: " . $e->getMessage());
            }
        }

        // 2. Enviar email al administrador
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
            <p>Se ha cancelado la cita con el ID <strong>$idCita</strong>.</p>";

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
        </html>
        ";

        // Configuración de PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dgodmed486@g.educaand.es'; // Cambia esto por tu correo
            $mail->Password = 'hjoi hosx csoe uqdr'; // Cambia esto por tu contraseña de aplicación
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
    // Redirigir al usuario a la página de citas
    header("Location: /Codigo/citas.php");
    exit();
}
