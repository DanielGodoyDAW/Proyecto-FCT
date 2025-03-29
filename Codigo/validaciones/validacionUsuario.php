<?php
session_start(); // Iniciar la sesion

if(isset($_POST["paciente"]) && isset($_POST["password"])){
    $usuario = htmlspecialchars($_POST["paciente"]);
    $password = htmlspecialchars($_POST["password"]);

    // Conectar a la base de datos
    require_once './Validaciones/conexion.php';

    // Consultar si el usuario existe en la base de datos
    $query = "SELECT * FROM pacientes WHERE pacientes='$pacientes' AND password='$password'";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0){
        // Si el usuario existe, guardar los datos en la sesion
        $_SESSION["pacientes"] = $pacientes;
        header("Location: ../index.php"); // Redirigir a la pagina principal
    } else {
        // Si el usuario no existe, mostrar un mensaje de error
        echo "<script>alert('Usuario o contraseña incorrectos');</script>";
        header("Location: ../index.php"); // Redirigir a la pagina principal
    }
} else {
    // Si no se han enviado los datos del formulario, redirigir a la pagina principal
    header("Location: ../index.php");
}