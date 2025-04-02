<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css">
    <link rel="stylesheet" href="/Codigo/estilos/styleAdmin.css">
    <title>Admin</title>
</head>

<body>
    <?php require_once '../plantillas/header.php'; ?>
    <main class="contenedor">
        <!-- Seccion izquierda Calendario -->
        <div class="seccion calendario">
            <?php include '../validaciones/calendario/calendarioReserva.php'; ?>
        </div>

        <!-- Seccion derecha Tramos horarios -->
        <div class="seccion horarios">
            <h2>Selecciona un tramo horario</h2>
            <ul id="tramos">
                <?php require_once '../validaciones/tramos_horarios.php'; ?>
            </ul>
        </div>
    </main>
    <div class="historial">
        <?php require_once '../validaciones/historial.php'; ?>
    </div>
    <?php require_once '../plantillas/footer.php'; ?>
</body>

</html>