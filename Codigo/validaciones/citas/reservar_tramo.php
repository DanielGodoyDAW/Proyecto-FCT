<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';
require_once __DIR__ . '/../../googleCalendar/google_calendar.php';
require_once __DIR__ . '/../../config/stripe_config.php'; // Configuración de Stripe

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPaciente = $_SESSION['idPacientes'];
    $fecha = $_POST['fecha'];
    $horaInicio = $_POST['hora'];
    $horaFin = date('H:i', strtotime($horaInicio) + 30 * 60); // Sumar 30 minutos
    $descripcion = 'Cita reservada por el paciente.';
    $bloqueada = isset($_POST['bloqueada']) ? 1 : 0; // Si es bloqueada, se establece a 1

    // Verificar que el tramo no esté reservado
    $query = "SELECT COUNT(*) AS total FROM Citas WHERE fecha = ? AND hora = ? AND bloqueada = 0";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ss", $fecha, $horaInicio);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result['total'] > 0) {
        echo '<script>alert("El tramo horario no está disponible.");</script>';
        echo '<script>window.location.href = "../../citas.php";</script>';
        exit();
    }

    // Crear el evento en Google Calendar
    try {
        $googleEventId = crearEvento($fecha, $horaInicio, $horaFin, $descripcion, $idPaciente, $bloqueada); // Devuelve el eventId
    } catch (Exception $e) {
        echo 'Error al crear el evento en Google Calendar: ' . $e->getMessage();
        exit();
    }

    // Insertar la nueva cita en la base de datos
    $estado = 'Pendiente';
    $insert = "INSERT INTO Citas (fecha, hora, estado, idPacientes, idAdmin, bloqueada, google_event_id) VALUES (?, ?, ?, ?, NULL, ?, ?)";
    $stmt = $conexion->prepare($insert);
    $stmt->bind_param("sssiss", $fecha, $horaInicio, $estado, $idPaciente, $bloqueada, $googleEventId);

    if ($stmt->execute()) {
        echo '<script>alert("Cita reservada exitosamente.");</script>';
        echo '<script>window.location.href = "../../citas.php";</script>'; // Redirigir a la página de citas
    } else {
        echo 'Error: No se pudo guardar la cita en la base de datos.';
    }
}

//para el pago

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $paymentIntentId = $_GET['payment_intent'];
    $fecha = $_GET['fecha'];
    $horaInicio = $_GET['hora'];

    // Verificar el estado del pago
    try {
        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
        if ($paymentIntent->status !== 'succeeded') {
            echo '<script>alert("El pago no se completó correctamente.");</script>';
            echo '<script>window.location.href = "../../citas.php";</script>';
            exit();
        }
    } catch (\Stripe\Exception\ApiErrorException $e) {
        echo 'Error al verificar el pago: ' . $e->getMessage();
        exit();
    }

    // Continuar con el proceso de reserva
    $idPaciente = $_SESSION['idPacientes'];
    $horaFin = date('H:i', strtotime($horaInicio) + 30 * 60); // Sumar 30 minutos
    $descripcion = 'Cita reservada por el paciente.';
    $bloqueada = 0;

    // Verificar que el tramo no esté reservado
    $query = "SELECT COUNT(*) AS total FROM Citas WHERE fecha = ? AND hora = ? AND bloqueada = 0";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ss", $fecha, $horaInicio);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result['total'] > 0) {
        echo '<script>alert("El tramo horario no está disponible.");</script>';
        echo '<script>window.location.href = "../../citas.php";</script>';
        exit();
    }

    // Crear el evento en Google Calendar
    try {
        $googleEventId = crearEvento($fecha, $horaInicio, $horaFin, $descripcion, $idPaciente, $bloqueada);
    } catch (Exception $e) {
        echo 'Error al crear el evento en Google Calendar: ' . $e->getMessage();
        exit();
    }

    // Insertar la nueva cita en la base de datos
    $estado = 'Pendiente';
    $insert = "INSERT INTO Citas (fecha, hora, estado, idPacientes, idAdmin, bloqueada, google_event_id) VALUES (?, ?, ?, ?, NULL, ?, ?)";
    $stmt = $conexion->prepare($insert);
    $stmt->bind_param("sssiss", $fecha, $horaInicio, $estado, $idPaciente, $bloqueada, $googleEventId);

    if ($stmt->execute()) {
        echo '<script>alert("Cita reservada exitosamente.");</script>';
        echo '<script>window.location.href = "../../citas.php";</script>';
    } else {
        echo 'Error: No se pudo guardar la cita en la base de datos.';
    }
}

?>
