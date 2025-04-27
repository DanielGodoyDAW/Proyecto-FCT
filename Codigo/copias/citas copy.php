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
        <div id="admin-panel">
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
                        <div class="columna derecha-arriba">
                            <?php require_once './validaciones/citas/citas_Bloqueadas.php'; ?>
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
        </div>
    <?php } else { ?>
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
    <!--****************************** mas reciente ***************************************************-->
</html>

<!DOCTYPE html>
<html lang="es">
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once './conexion/conexion.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Codigo/estilos/styleColores.css">
    <?php if (isset($_SESSION["idAdmin"])) { ?>
        <link rel="stylesheet" href="/Codigo/estilos/styleCitasAdmin.css">
    <?php } else { ?>
        <link rel="stylesheet" href="/Codigo/estilos/styleCitasPaciente.css">
    <?php } ?>
    <script defer src="/Codigo/validaciones/citas/subsecciones_admin_citas.js"></script>
    <title>Reserva tu Cita</title>
</head>

<body>
    <?php require_once './plantillas/header.php'; ?>

    <?php if (isset($_POST['seccionActiva'])) { ?>
        <input type="hidden" id="seccionActivaPost" value="<?php echo $_POST['seccionActiva']; ?>">
    <?php } ?>

    <?php if (isset($_SESSION["idAdmin"])) { ?>
        <div id="admin-panel">
            <nav class="menu-citas">
                <ul>
                    <li><a href="#" data-seccion="bloquearDEsbloCitas">Bloquear o Desbloquear Agenda</a></li>
                    <li><a href="#" data-seccion="nuevaAlta" class="activo">Nueva Alta y Cita</a></li>
                    <li><a href="#" data-seccion="listadoPacientesT">Listado de Pacientes temporales</a></li>
                    <li><a href="#" data-seccion="proximasCitas">Próximas citas de este mes</a></li>
                    <li><a href="#" data-seccion="historialCitas">Historial de citas</a></li>
                </ul>
            </nav>

            <main class="contenedorAdmin">
                <div id="bloquearDEsbloCitas" class="contenido-admin">
                    <div class="filaAdmin">
                        <div class="columnaAdmin izquierda-arriba">
                            <?php
                            $modo = 'bloquear';
                            include '../Codigo/validaciones/calendario/calendarioReserva.php';
                            ?>
                        </div>
                        <div class="columnaAdmin derecha-arriba">
                            <?php require_once '../Codigo/validaciones/citas/citas_Bloqueadas.php'; ?>
                        </div>
                        <div class="columnaAdmin medio-izquierda">
                            <?php require_once './validaciones/citas/bloquear_citas.php'; ?>
                        </div>
                        <div class="columnaAdmin medio-derecha">
                            <?php require_once './validaciones/citas/desbloquear_citas.php'; ?>
                        </div>
                    </div>
                </div>

                <div id="nuevaAlta" class="contenido-admin">
                    <div class="filaAdmin">
                        <div class="columnaAdmin izquierda-arriba">
                            <?php
                            $modo = 'alta';
                            include '../Codigo/validaciones/calendario/calendarioReserva.php';
                            ?>
                        </div>
                        <div class="columnaAdmin derecha-arriba">
                            <?php require_once '../Codigo/validaciones/citas/citas_admin_gestion.php'; ?>
                        </div>
                    </div>
                </div>

                <div id="listadoPacientesT" class="contenido-admin">
                    <?php require_once '../Codigo/validaciones/citas/pacientes_temporales.php'; ?>
                </div>

                <div id="proximasCitas" class="contenido-admin">
                    <div class="filaAdmin">
                        <div class="columnaAdmin izquierda-arriba">
                            <h2>Próximas Citas</h2>
                            <?php require_once './validaciones/citas/proximas_citas.php'; ?>
                        </div>
                    </div>
                </div>

                <div id="historialCitas" class="contenido-admin">
                    <div class="filaAdmin">
                        <div class="columnaAdmin izquierda-arriba">
                            <h2>Historial de Citas</h2>
                            <?php require_once './validaciones/historial.php'; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    <?php } else { ?>
        <main class="contenedor">
            <div class="fila">
                <div class="columna izquierda-arriba">
                    <?php include 'validaciones/calendario/calendarioReserva.php'; ?>
                </div>

                <div class="columna derecha-arriba">
                    <ul id="tramos">
                        <?php require_once './validaciones/citas/tramos_horarios.php'; ?>
                    </ul>
                </div>
            </div>

            <div class="fila">
                <div class="columna izquierda-abajo">
                    <h2>Próximas Citas</h2>
                    <?php require_once './validaciones/citas/proximas_citas.php'; ?>
                </div>

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