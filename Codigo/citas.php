<!DOCTYPE html>
<html lang="es">
<?php require_once './conexion/conexion.php'; ?>

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
        <!-- Contenedor superior -->
        <div class="fila">
            <!-- Sección izquierda: Calendario -->
            <div class="columna izquierda">
                <?php include 'validaciones/calendario/calendarioReserva.php'; ?>
            </div>

            <!-- Sección derecha: Tramos horarios -->
            <div class="columna derecha">
                <h2>Selecciona un tramo horario</h2>
                <ul id="tramos">
                    <?php require_once './validaciones/tramos_horarios.php'; ?>
                </ul>
            </div>
        </div>

        <!-- Contenedor inferior -->
        <div class="fila">
            <!-- Sección izquierda: Próximas citas -->
            <div class="columna izquierda">
                <h2>Próximas Citas</h2>
                <ul id="proximas-citas"></ul>
                <?php require_once './validaciones/proximas_citas.php'; ?>
            </div>

            <!-- Sección derecha: Historial de citas -->
            <div class="columna derecha">
                <h2>Historial de Citas</h2>
                <ul id="historial-citas">
                    <li id="cita-Eliminar"></li>
                </ul>
                <?php require_once './validaciones/historial.php'; ?>
            </div>
        </div>
    </main>
    <?php require_once './plantillas/footer.php'; ?>
</body>

</html>