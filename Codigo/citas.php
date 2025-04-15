<!DOCTYPE html>
<html lang="es">
<?php require_once './conexion/conexion.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Codigo/estilos/styleCitas.css">
    <title>Reserva tu Cita</title>
</head>

<body>
    <?php require_once './plantillas/header.php'; ?>
    <main class="contenedor">
        <!-- Contenedor superior -->
        <div class="fila">
            <!-- Sección izquierda: Calendario -->
            <div class="columna izquierda-arriba">
                <?php include 'validaciones/calendario/calendarioReserva.php'; ?>
            </div>

            <!-- Sección derecha: Tramos horarios -->
            <div class="columna derecha-arriba">
                <ul id="tramos">
                    <?php
                    if (isset($_SESSION["idAdmin"])) {
                        require_once './validaciones/citas_Bloqueadas.php';
                    } else {
                        require_once './validaciones/tramos_horarios.php';
                    } ?>
                </ul>
            </div>
        </div>

        <!-- Contenedor inferior -->
        <div class="fila">
            <!-- Sección izquierda: Próximas citas -->
            <div class="columna izquierda-abajo">
                <h2>Próximas Citas</h2>
                <?php require_once './validaciones/proximas_citas.php'; ?>
            </div>

            <!-- Sección derecha: Historial de citas -->
            <div class="columna derecha-abajo">
                <h2>Historial de Citas</h2>
                <?php require_once './validaciones/historial.php'; ?>
            </div>
        </div>
    </main>
    <?php require_once './plantillas/footer.php'; ?>
</body>

</html>