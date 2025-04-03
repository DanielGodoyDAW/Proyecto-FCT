<?php
session_start(); // Iniciar la sesión

// Conectar a la base de datos
require_once './Validaciones/conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["paciente"]) && isset($_POST["password"])) {
    $usuario = htmlspecialchars($_POST["paciente"]);
    $password = htmlspecialchars($_POST["password"]);

    // Consultar si el usuario es un administrador
    $queryAdmin = "SELECT * FROM Admin WHERE email = ? AND telefono = ?";
    $stmtAdmin = $con->prepare($queryAdmin);
    $stmtAdmin->bind_param("ss", $usuario, $password);
    $stmtAdmin->execute();
    $resultAdmin = $stmtAdmin->get_result();

    if ($resultAdmin->num_rows > 0) {
        // Si el usuario es administrador
        $admin = $resultAdmin->fetch_assoc();
        $_SESSION["admin"] = true;
        $_SESSION["nombreAdmin"] = $admin["nombre"];
        header("Location: ../admin.php"); // Redirigir a la página de administración
        exit();
    }

    // Consultar si el usuario es un paciente
    $queryPaciente = "SELECT * FROM Pacientes WHERE email = ? AND pass = ?";
    $stmtPaciente = $con->prepare($queryPaciente);
    $stmtPaciente->bind_param("ss", $usuario, $password);
    $stmtPaciente->execute();
    $resultPaciente = $stmtPaciente->get_result();

    if ($resultPaciente->num_rows > 0) {
        // Si el usuario es un paciente
        $paciente = $resultPaciente->fetch_assoc();
        $_SESSION["pacientes"] = $paciente["nombre"];
        $_SESSION["sexo"] = $paciente["sexo"];
        header("Location: ../index.php"); // Redirigir a la página principal
        exit();
    } else {
        // Si el usuario no existe, mostrar un mensaje de error
        echo "<script>alert('Usuario o contraseña incorrectos');</script>";
        header("Location: ../index.php"); // Redirigir a la página principal
        exit();
    }
} else {
    // Si no se han enviado los datos del formulario, redirigir a la página principal
    header("Location: ../index.php");
    exit();
}