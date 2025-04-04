<?php
session_start(); // Iniciar la sesión

// Conectar a la base de datos
require_once './conexion/conexion.php';

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

    // Consulta para verificar si el usuario es un paciente
    $queryPaciente = "SELECT idPacientes, nombre, sexo, pass FROM Pacientes WHERE email = ?";
    $stmtPaciente = $con->prepare($queryPaciente);
    $stmtPaciente->bind_param("s", $usuario);
    $stmtPaciente->execute();
    $resultPaciente = $stmtPaciente->get_result();
    
    if ($resultPaciente->num_rows > 0) {
        $paciente = $resultPaciente->fetch_assoc();
        if ($paciente['pass'] === $password) {
            // Contraseña correcta
            $_SESSION['idPacientes'] = $paciente['idPacientes'];
            $_SESSION['pacientes'] = $paciente['nombre'];
            $_SESSION['sexo'] = $paciente['sexo'];
            header("Location: ../citas.php");
            exit();
        } else {
            // Contraseña incorrecta
            echo "<script>alert('Contraseña incorrecta');</script>";
            header("Location: ../index.php");
            exit();
        }
    } else {
        // Usuario no encontrado
        echo "<script>alert('Usuario no encontrado');</script>";
        header("Location: ../index.php");
        exit();
    }
} 