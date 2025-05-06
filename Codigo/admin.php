<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Codigo/estilos/styleAdmin.css">
    <link rel="stylesheet" href="/Codigo/estilos/styleColores.css">
    <script defer src="/Codigo/validaciones/subseccionesAdmin/subseccion.js"></script>
    <script defer src="/Codigo/validaciones/subseccionesAdmin/subMenuHistorial.js"></script>
    <title>Administración</title>
</head>

<body>
    <?php require_once '../Codigo/plantillas/header.php'; ?>

    <!-- Menú de navegación -->
    <nav class="menu-admin">
        <ul>
            <li><a href="#" data-seccion="busqueda" class="activo">Búsqueda de Paciente</a></li>
            <li><a href="#" data-seccion="historial">Historial Clínico</a></li>
            <li><a href="#" data-seccion="promociones">Agregar Servicio</a></li>
        </ul>
    </nav>

    <main class="contenedor">
        <!-- Secciones de contenido -->
        <div id="busqueda" class="contenido-admin activo">
            <?php require_once '../Codigo/validaciones/subseccionesAdmin/busquedaP.php'; ?>
        </div>
        <div id="historial" class="contenido-admin">
            <nav class="submenu-historial">
                <ul>
                    <li><a href="#" data-subseccion="crear" class="activo">Crear</a></li>
                    <li><a href="#" data-subseccion="editar">Editar</a></li>
                    <li><a href="#" data-subseccion="ver">Ver</a></li>
                </ul>
            </nav>
            <div id="crear" class="subcontenido activo">
                <?php require_once '../Codigo/validaciones/historialClinico/crearHistorial/historial_clinico_form.php'; ?>
            </div>
            <div id="editar" class="subcontenido">
                <?php require_once '../Codigo/validaciones/historialClinico/editarHistorial/editarHistorial.php'; ?>
            </div>
            <div id="ver" class="subcontenido">
                <?php require_once '../Codigo/validaciones/historialClinico/listarHistorial/verHistorial.php'; ?>
            </div>
        </div>
        <div id="promociones" class="contenido-admin">
            <?php require_once '../Codigo/validaciones/subseccionesAdmin/agregarServicio.php'; ?>
        </div>
    </main>

    <?php require_once '../Codigo/plantillas/footer.php'; ?>
</body>

</html>