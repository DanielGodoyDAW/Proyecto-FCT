<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idCita'])) {
    $idCita = $_POST['idCita'];

    // Eliminar la cita de la base de datos
    $query = "DELETE FROM Citas WHERE idCita = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $idCita);

    if ($stmt->execute()) {
        echo "<script>alert('Cita cancelada correctamente.'); window.location.href='/Codigo/citas.php';</script>";
    } else {
        echo "<script>alert('Error al cancelar la cita.'); window.history.back();</script>";
    }
}
?>