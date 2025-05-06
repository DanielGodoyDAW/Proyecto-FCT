<?php
session_start(); // Iniciar la sesión

// Conectar a la base de datos
require_once '../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["paciente"]) && isset($_POST["password"])) {
    $email = htmlspecialchars($_POST["paciente"]);
    $password = htmlspecialchars($_POST["password"]);

    // Consultar si el usuario es un administrador
    $queryAdmin = "SELECT * FROM Admin WHERE email ='". $email."'";
    $result = mysqli_query($conexion, $queryAdmin);
    
    if(mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        // Verificar la contraseña
        if (password_verify($password, $admin['pass'])) {
            // Iniciar sesión
            $_SESSION['idAdmin'] = $admin['idAdmin'];
            $_SESSION['nombre'] = $admin['nombre'];
            $_SESSION['apellido1'] = $admin['apellido1'];
            $_SESSION['apellido2'] = $admin['apellido2'];
            header("Location: ../citas.php"); // Redirigimos a la primera pagina de la web
            exit();
        } else {
            header("Location: ../index.php?error=2"); // Contraseña incorrecta
            exit();
        }
    }

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
    $queryPaciente = "SELECT idPacientes, nombre, apellido1, apellido2, sexo, pass FROM Pacientes WHERE email = ?";
    $stmtPaciente = $conexion->prepare($queryPaciente);
    $stmtPaciente->bind_param("s", $email);
    $stmtPaciente->execute();
    $resultPaciente = $stmtPaciente->get_result();

    if ($resultPaciente->num_rows > 0) {
        $paciente = $resultPaciente->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $paciente['pass'])) {
            // Iniciar sesión
            $_SESSION['idPacientes'] = $paciente['idPacientes'];
            $_SESSION['nombre'] = $paciente['nombre'];
            $_SESSION['apellido1'] = $paciente['apellido1'];
            $_SESSION['apellido2'] = $paciente['apellido2'];
            $_SESSION['sexo'] = $paciente['sexo'];
            header("Location: ../citas.php");
            exit();
        } else {
            header("Location: ../index.php?error=1"); // Contraseña incorrecta
            exit();
        }
    } else {
        header("Location: ../index.php?error=1"); // Usuario no encontrado
        exit();
    }
} else {
    header("Location: ../index.php?error=1"); // Usuario no encontrado
    exit();
}
