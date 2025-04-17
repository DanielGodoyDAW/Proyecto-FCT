<?php
require_once __DIR__ . '/../../conexion/conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['idAdmin'])) {
    if (isset($_POST['bloquear']) && isset($_POST['fecha'])) {
        $fecha = $_POST['fecha'];
        $horas = $_POST['bloquear']; // Array de horas seleccionadas

        foreach ($horas as $hora) {
            $query = "INSERT INTO Citas (fecha, hora, bloqueada) VALUES (?, ?, 1)
                      ON DUPLICATE KEY UPDATE bloqueada = 1";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("ss", $fecha, $hora);
            $stmt->execute();
        }

        echo '<script>alert("Citas bloqueadas correctamente.");</script>';
        echo '<script>window.location.href = "/Codigo/citas.php";</script>';
    } else {
        echo '<script>alert("No se seleccionaron citas para bloquear.");</script>';
        echo '<script>window.location.href = "/Codigo/citas.php";</script>';
    }
} else {
    echo '<script>alert("Acceso no autorizado.");</script>';
    echo '<script>window.location.href = "/Codigo/index.php";</script>';
}