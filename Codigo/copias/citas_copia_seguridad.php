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
                    // if (isset($_SESSION["idAdmin"])) {
                    //     require_once './validaciones/citas/citas_Bloqueadas.php';
                    // } else {
                    //     require_once './validaciones/citas/tramos_horarios.php';
                    // } 
                    if (isset($_SESSION["idAdmin"])) {
                        echo '<h3>Gestión de citas (admin)</h3>';
                        require_once './validaciones/citas/citas_admin_gestion.php';
                        require_once './validaciones/citas/citas_Bloqueadas.php';
                    } else {
                        require_once './validaciones/citas/tramos_horarios.php';
                    }?>
                </ul>
            </div>
        </div>
        
        <?php if (isset($_SESSION["idAdmin"])) { ?>
            <div class="fila">
                <div class="columna medio-izquierda">
                    <?php require_once './validaciones/citas/bloquear_citas.php'; ?>
                </div>
                <div class="columna medio-derecha">
                    <?php require_once './validaciones/citas/desbloquear_citas.php'; ?>
                </div>
            </div>
        <?php } ?>

        <!-- Contenedor inferior -->
        <div class="fila">
            <!-- Sección izquierda: Próximas citas -->
            <div class="columna izquierda-abajo">
                <h2>Próximas Citas</h2>
                <?php require_once './validaciones/citas/proximas_citas.php'; ?>
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