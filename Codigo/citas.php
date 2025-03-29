<!DOCTYPE html>
<html lang="en">
<?php session_start();

if (!isset($_SESSION['idPaciente']) || !isset($_SESSION['nombrePaciente'])) {
    header("Location: index.php");
}

require_once "./validaciones/conexion.php";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva tu Cita</title>
</head>

<body>
    <?php require_once './plantillas/header.php'; ?>
    <main>
        <div id="calendarioReserva">
            <?php require_once './validaciones/calendarioReserva.php'; ?>
        </div>
    </main>
    <?php require_once './plantillas/footer.php'; ?>
</body>

</html>