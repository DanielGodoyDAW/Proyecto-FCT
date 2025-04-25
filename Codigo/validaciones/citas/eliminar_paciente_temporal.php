<?php
session_start(); 
require_once __DIR__ . '/../../conexion/conexion.php';

if (!isset($_SESSION['idAdmin'])) {
    header("Location: /Codigo/citas.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $idPaciente = $_POST['id'];

    // Obtener el ID del historial del paciente antes de borrar
    $stmt = $conexion->prepare("SELECT idHistorial FROM Pacientes WHERE idPacientes = ?");
    $stmt->bind_param("i", $idPaciente);
    $stmt->execute();
    $stmt->bind_result($idHistorial);
    $stmt->fetch();
    $stmt->close();

    // Borrar citas asociadas
    $conexion->query("DELETE FROM Citas WHERE idPacientes = $idPaciente");

    // Borrar paciente
    $conexion->query("DELETE FROM Pacientes WHERE idPacientes = $idPaciente");

    // Borrar historial
    if ($idHistorial) {
        $conexion->query("DELETE FROM Historial WHERE idHistorial = $idHistorial");
    }

    header("Location: /Codigo/citas.php?mensaje=Paciente+eliminado");
    exit;
} else {
    echo "Acceso denegado.";
}
?>
