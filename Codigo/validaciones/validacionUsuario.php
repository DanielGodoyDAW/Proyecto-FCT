<?php
session_start(); // Iniciar la sesión

// Conectar a la base de datos
require_once '../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["paciente"]) && isset($_POST["password"])) {
    $email = htmlspecialchars($_POST["paciente"]);
    $password = htmlspecialchars($_POST["password"]);

    // Consultar si el usuario es un administrador
    $queryAdmin = "SELECT * FROM Admin WHERE email = ? AND pass = ?";
    $stmtAdmin = $con->prepare($queryAdmin);
    $stmtAdmin->bind_param("ss", $email, $password);
    $stmtAdmin->execute();
    $resultAdmin = $stmtAdmin->get_result();

    if ($resultAdmin->num_rows > 0) {
        // Si el usuario es administrador
        $admin = $resultAdmin->fetch_assoc();
        $_SESSION['idAdmin'] = $admin['idAdmin'];
        $_SESSION['nombre'] = $admin['nombre'];
        $_SESSION['apellido1'] = $admin['apellido1'];
        $_SESSION['apellido2'] = $admin['apellido2'];
        echo "Redirigiendo a admin.php"; // Depuración
        header("Location: ../admin.php"); // Redirigir a la página de administración
        exit();
    }

    // Consulta para verificar si el usuario es un paciente
    $queryPaciente = "SELECT idPacientes, nombre, apellido1, apellido2, sexo FROM Pacientes WHERE email = ? AND pass = ?";
    $stmtPaciente = $con->prepare($queryPaciente);
    $stmtPaciente->bind_param("ss", $email, $password);
    $stmtPaciente->execute();
    $resultPaciente = $stmtPaciente->get_result();

    if ($resultPaciente->num_rows > 0) {
        // Usuario es paciente
        $paciente = $resultPaciente->fetch_assoc();
        $_SESSION['idPacientes'] = $paciente['idPacientes'];
        $_SESSION['nombre'] = $paciente['nombre'];
        $_SESSION['apellido1'] = $paciente['apellido1'];
        $_SESSION['apellido2'] = $paciente['apellido2'];
        $_SESSION['sexo'] = $paciente['sexo'];
        echo "Redirigiendo a citas.php"; // Depuración
        header("Location: ../citas.php"); // Redirigir a la seccion de citas
        exit();
    }

    // Si las credenciales no son validas
    echo "Credenciales no válidas"; // Depuración
    header("Location: ../index.php?error=1");
    exit();
}
