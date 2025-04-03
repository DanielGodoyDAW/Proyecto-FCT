<!DOCTYPE html>
<html lang="en">
<?php session_start();

// if (!isset($_SESSION['idPaciente']) || !isset($_SESSION['nombrePaciente'])) {
//     header("Location: index.php");
// }

// require_once "./validaciones/conexion.php";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css">
    <link rel="stylesheet" href="/Codigo/estilos/styleCitas.css">
    <title>Reserva tu Cita</title>
</head>

<body>
    <?php require_once './plantillas/header.php'; ?>
    <main class="contenedor">
        <!-- Seccion izquierda Calendario -->
        <div class="seccion calendario">
            <?php include 'validaciones/calendario/calendarioReserva.php'; ?>
        </div>

        <!-- Seccion derecha Tramos horarios -->
        <div class="seccion horarios">
            <h2>Selecciona un tramo horario</h2>
            <ul id="tramos">
                <?php require_once './validaciones/tramos_horarios.php'; ?>
            </ul>
        </div>
    </main>
    <main class="contenedor">
        <!-- Seccion Proximas citas -->
        <div class="seccion prox-citas">
            <h2>Proximas Citas</h2>
                <?php require_once './validaciones/proximas_citas.php'; ?>
        </div>
        <!-- Seccion Historial de citas -->
    <div class="seccion reserva">
        <h2>Historial de Citas</h2>
        <?php require_once './validaciones/historial.php'; ?> <!-- en historial una consulta para ver solo las activas o proximas -->
    </div>
    </main>
    <?php require_once './plantillas/footer.php'; ?>
</body>

</html>