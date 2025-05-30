<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/styleColores.css">
    <link rel="stylesheet" href="./estilos/styleAdmin.css">
    <script defer src="./validaciones/subseccionesAdmin/subseccion.js"></script>
    <script defer src="./validaciones/subseccionesAdmin/subMenuHistorial.js"></script>
    <title>Administración</title>
</head>

<body>
    <?php require_once './plantillas/header.php'; ?>

    <!-- Menú de navegación -->
    <nav class="menu-admin">
        <ul>
            <li><a href="#" data-seccion="busqueda" class="activo">Búsqueda de Paciente</a></li>
            <li><a href="#" data-seccion="historial">Historial Clínico</a></li>
            <li><a href="#" data-seccion="servicios">Agregar Servicio</a></li>
        </ul>
    </nav>

    <main class="contenedor">
        <!-- Secciones de contenido -->
        <div class="busqueda-historial">
            <div id="busqueda" class="contenido-admin activo">
                <?php require_once './validaciones/subseccionesAdmin/busquedaP.php'; ?>
            </div>
            <div id="historial" class="contenido-admin">
                <nav class="submenu-historial">
                    <?php  ?>
                </nav>
                <div id="editar" class="subcontenido">
                    <?php require_once './validaciones/historialClinico/editarHistorial/mostrar_editar_Historial_Informe.php'; ?>
                </div>
                <div id="ver" class="subcontenido activo">
                    <?php require_once './validaciones/historialClinico/listarHistorial/listarHistorial.php'; ?>
                </div>
            </div>
        </div>
        <div id="servicios" class="contenido-admin">
            <?php require_once './validaciones/subseccionesAdmin/agregarServicio.php'; ?>
        </div>
    </main>

    <?php require_once './plantillas/footer.php'; ?>
</body>

</html>