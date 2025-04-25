<!DOCTYPE html>
<html lang="es">
<?php require_once './conexion/conexion.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Codigo/estilos/styleCitas.css">
    <?php if (isset($_SESSION["idAdmin"])) { ?>
        <link rel="stylesheet" href="/Codigo/estilos/styleCitasAdmin.css">
    <?php } elseif (isset($_SESSION["idPaciente"])) { ?>
        <link rel="stylesheet" href="/Codigo/estilos/styleCitasPaciente.css">
    <?php } ?>
    <script defer src="/Codigo/validaciones/citas/subsecciones_admin_citas.js"></script>
    <title>Reserva tu Cita</title>
</head>

<body>
    <?php require_once './plantillas/header.php'; ?>

    <?php if (isset($_SESSION["idAdmin"])) { ?>
        <nav class="menu-citas">
            <ul>
                <li><a href="#" data-seccion="nuevaAlta" class="activo">Nueva Alta y Cita</a></li>
                <li><a href="#" data-seccion="listadoPacientesT">Listado de Pacientes temporales</a></li>
                <li><a href="#" data-seccion="bloquearDEsbloCitas">Bloquear o Desbloquear Agenda</a></li>
                <li><a href="#" data-seccion="proximasCitas">Proximas citas de este mes</a></li>
                <li><a href="#" data-seccion="historialCitas">Historial de citas</a></li>
            </ul>
        </nav>

        <main class="contenedor">
            <div id="nuevaAlta" class="contenido-admin activo">
                <div class="fila">
                    <div class="columna izquierda-arriba">
                        <?php require_once '../Codigo/validaciones/citas/citas_Bloqueadas.php'; ?>
                    </div>
                    <div class="columna derecha-arriba">
                        <?php require_once '../Codigo/validaciones/citas/citas_admin_gestion.php'; ?>
                    </div>
                </div>
            </div>
            <div id="listadoPacientesT" class="contenido-admin">
                <?php require_once '../Codigo/validaciones/citas/pacientes_temporales.php'; ?>
            </div>
            <div id="bloquearDEsbloCitas" class="contenido-admin">
                <div class="fila">
                    <div class="columna izquierda-arriba">
                        <?php include '../Codigo/validaciones/calendario/calendarioReserva.php'; ?>
                    </div>
                    <div class="columna medio-izquierda">
                        <?php require_once './validaciones/citas/bloquear_citas.php'; ?>
                    </div>
                    <div class="columna medio-derecha">
                        <?php require_once './validaciones/citas/desbloquear_citas.php'; ?>
                    </div>
                </div>
            </div>
            <div id="proximasCitas" class="contenido-admin">
                <div class="fila">
                    <div class="columna izquierda-arriba">
                        <h2>Próximas Citas</h2>
                        <?php require_once './validaciones/citas/proximas_citas.php'; ?>
                    </div>
                </div>
            </div>
            <div id="historialCitas" class="contenido-admin">
                <div class="fila">
                    <div class="columna izquierda-arriba">
                        <h2>Historial de Citas</h2>
                        <?php require_once './validaciones/historial.php'; ?>
                    </div>
                </div>
            </div>
        </main>
    <?php } ?>

    <?php if (isset($_SESSION["idPaciente"])) { ?>
        <main class="contenedor">
            <!-- Contenedor superior -->
            <div class="fila">
                <!-- Sección izquierda: Calendario -->
                <div class="columna izquierda-arriba">
                    <?php include '../Codigo/validaciones/calendario/calendarioReserva.php'; ?>
                </div>

                <!-- Sección derecha: Tramos horarios -->
                <div class="columna derecha-arriba">
                    <ul id="tramos">
                        <?php require_once './validaciones/citas/tramos_horarios.php'; ?>
                    </ul>
                </div>
            </div>
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
    <?php } ?>
    <?php require_once './plantillas/footer.php'; ?>
</body>

</html>