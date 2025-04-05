<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css">
    <link rel="stylesheet" href="/Codigo/estilos/styleAdmin.css">
    <title>Administracion</title>
</head>

<body>
    <?php require_once '../Codigo/plantillas/header.php'; ?>
    <main class="contenedor">
        <div class="orden arriba">
            <!-- Seccion izquierda busqueda -->
            <div class="seccion busqueda">
                <h2>Busqueda de paciente</h2>
                <?php require_once '../Codigo/validaciones/busqueda.php'; ?>
            </div>

            <!-- Seccion derecha tratamiento -->
            <div class="seccion tratamiento">
                <h2>Listado de tratamientos</h2>
                <?php require_once '../Codigo/validaciones/tratamientos.php'; ?>
            </div>
        </div>
        <div class="orden abajo">
            <!-- Seccion para administrar promociones -->
            <div class="seccion promociones">
                <?php require_once '../Codigo/validaciones/promociones/promociones_form.php'; ?>
            </div>
            <div class="seccion promociones-lista">
                <h2>Promociones Existentes</h2>
                <?php require_once '../Codigo/validaciones/promociones/promociones_lista.php'; ?>
            </div>
        </div>
        <!-- Seccion para ver las proximas citas -->
        <div class="historial">
            <h2>Historial</h2>
            <?php require_once '../Codigo/validaciones/historial.php'; ?>
        </div>
    </main>
    <?php require_once '../Codigo/plantillas/footer.php'; ?>
</body>

</html>