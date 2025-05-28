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
    <link rel="stylesheet" href="estilos/styleColores.css">
    <?php if (isset($_SESSION["idAdmin"])) { ?>
        <link rel="stylesheet" href="estilos/styleCitasAdmin.css">
    <?php } else { ?>
        <link rel="stylesheet" href="estilos/styleCitasPaciente.css">
    <?php } ?>
    <script defer src="/Codigo/validaciones/citas/subsecciones_admin_citas.js"></script>
    <title>Reserva tu Cita</title>
</head>

<body>
    <?php require_once './plantillas/header.php'; ?>
    <!-- Si el usuario logueado es admin, vera una cosa u otra -->
    <?php if (isset($_SESSION["idAdmin"])) { ?>
        <div id="admin-panel">
            <nav class="menu-citas">
                <ul>
                    <li><a href="#" data-seccion="bloquearDEsbloCitas" class="activo">Bloquear o Desbloquear Agenda y Asignar citas temporales</a></li>
                    <li><a href="#" data-seccion="listadoPacientesT">Listado de Pacientes Temporales</a></li>
                    <li><a href="#" data-seccion="proximasCitas">Próximas Citas de este mes</a></li>
                    <li><a href="#" data-seccion="historialCitas">Historial de Citas</a></li>
                </ul>
            </nav>

            <main class="contenedorAdmin">
                <!-- Seccion Bloquear y Desbloquear -->
                <!-- Parte de arriba con el calendario y los tramos -->
                <div id="bloquearDEsbloCitas" class="contenido-admin activo">
                    <div class="filaAdmin">
                        <div class="columnaAdmin">
                            <?php include '../Codigo/validaciones/calendario/calendarioReserva.php'; ?>
                        </div>
                        <div class="columnaAdmin">
                            <?php require_once '../Codigo/validaciones/citas/citas_Bloqueadas.php'; ?>
                        </div>
                    </div>
                <!-- Parte media para bloquear o desbloquear agenda -->
                    <div class="filaAdmin">
                        <div class="columnaAdmin">
                            <?php require_once './validaciones/citas/bloquear_citas.php'; ?>
                        </div>
                        <div class="columnaAdmin">
                            <?php require_once './validaciones/citas/desbloquear_citas.php'; ?>
                        </div>
                    </div>
                <!-- Parte de abajo para asignar Citas a pacientes temporales -->
                    <div class="filaAdmin">
                        <div class="columnaAdmin-full">
                            <?php require_once '../Codigo/validaciones/citas/citas_admin_gestion.php'; ?>
                        </div>
                    </div>
                </div>

                <!-- Seccion Listado de Pacientes Temporales -->
                <div id="listadoPacientesT" class="contenido-admin">
                    <div class="contenedorPacientesTemporales">
                        <h2>Pacientes Temporales</h2>
                        <?php require_once '../Codigo/validaciones/citas/pacientes_temporales.php'; ?>
                    </div>
                </div>

                <!-- Seccion Proximas Citas -->
                <div id="proximasCitas" class="contenido-admin">
                    <div class="filaAdmin">
                        <div class="columnaAdmin-citas">
                            <h2>Próximas Citas</h2>
                            <?php require_once './validaciones/citas/proximas_citas.php'; ?>
                        </div>
                    </div>
                </div>

                <!-- Seccion Historial de Citas -->
                <div id="historialCitas" class="contenido-admin">
                    <div class="filaAdmin">
                        <div class="columnaAdmin-citas">
                            <h2>Historial de Citas</h2>
                            <?php require_once './validaciones/historial.php'; ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>

    <?php } else { ?>
        <!-- Seccion Standar para pacientes -->
        <main class="contenedor">
            <div class="fila">
                <div class="columna">
                    <?php include 'validaciones/calendario/calendarioReserva.php'; ?>
                </div>
                <div class="columna">
                    <ul id="tramos">
                        <?php require_once './validaciones/citas/tramos_horarios.php'; ?>
                    </ul>
                </div>
            </div>

            <div class="fila">
                <div class="columna">
                    <h2>Próximas Citas</h2>
                    <?php require_once './validaciones/citas/proximas_citas.php'; ?>
                </div>
                <div class="columna">
                    <h2>Historial de Citas</h2>
                    <?php require_once './validaciones/historial.php'; ?>
                </div>
            </div>
        </main>
    <?php } ?>

    <?php require_once './plantillas/footer.php'; ?>
</body>

</html>