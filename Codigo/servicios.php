<!DOCTYPE html>
<html lang="es">

<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once './conexion/conexion.php';
//para asegurarnos que el paciente temporal rellena sus datos minimos obligatorios
if (isset($_SESSION['idPacientes'])) {
    $id = $_SESSION['idPacientes'];
    $consulta = $conexion->prepare("SELECT es_temporal FROM Pacientes WHERE idPacientes = ?");
    $consulta->bind_param("i", $id);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
        $paciente = $resultado->fetch_assoc();
        if ($paciente['es_temporal']) {
            header("Location: editar_perfil.php?completar=1");
            exit();
        }
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Codigo/estilos/styleColores.css">
    <link rel="stylesheet" href="/Codigo/estilos/stylePromo.css">
    <title>Servicios</title>
</head>

<body>
    <?php require_once '../Codigo/plantillas/header.php'; ?>
    <main class="container promociones">
        <div class="promociones-lista">
            <h2>Servicios</h2>
            <?php
            $mostrarEditar = false;
            $mostrarImagen = true;
            require_once '../Codigo/validaciones/servicios/servicios_lista.php';
            ?>
        </div>

    </main>
    <?php require_once '../Codigo/plantillas/footer.php'; ?>
</body>

</html>