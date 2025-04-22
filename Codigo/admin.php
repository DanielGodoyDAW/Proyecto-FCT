<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Codigo/estilos/styleAdmin.css">
    <script defer src="/Codigo/validaciones/subseccionesAdmin/subseccion.js"></script>
    <title>Administración</title>
</head>

<body>
    <?php require_once '../Codigo/plantillas/header.php'; ?>

    <!-- Menú de navegación -->
    <nav class="menu-admin">
        <ul>
            <li><a href="#" data-seccion="busqueda" class="activo">Búsqueda de Paciente</a></li>
            <li><a href="#" data-seccion="historial">Creación Historial Clínico</a></li>
            <li><a href="#" data-seccion="promociones">Agregar Servicio</a></li>
        </ul>
    </nav>

    <main class="contenedor">
        <!-- Secciones de contenido -->
        <div id="busqueda" class="contenido-admin activo">
            <?php require_once '../Codigo/validaciones/subseccionesAdmin/busqueda.php'; ?>
        </div>
        <div id="historial" class="contenido-admin">
            <?php require_once '../Codigo/validaciones/subseccionesAdmin/crearHistorial.php'; ?>
        </div>
        <div id="promociones" class="contenido-admin">
            <?php require_once '../Codigo/validaciones/subseccionesAdmin/agregarServicio.php'; ?>
        </div>
    </main>

    <?php require_once '../Codigo/plantillas/footer.php'; ?>
</body>

</html>