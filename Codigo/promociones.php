<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Codigo/estilos/stylePromo.css">
    <title>Promociones</title>
</head>

<body>
<?php require_once '../Codigo/plantillas/header.php'; ?>
    <main class="contenedor">
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

        <!-- Seccion para administrar promociones -->
        <?php require_once '../Codigo/validaciones/promociones/promociones_form.php'; ?>
        <?php require_once '../Codigo/validaciones/promociones/promociones_lista.php'; ?>
    </main>

    <!-- Seccion para ver las proximas citas -->
    <div class="historial">
        <h2>Historial</h2>
        <?php require_once '../Codigo/validaciones/historial.php'; ?>
    </div>
    <?php require_once '../Codigo/plantillas/footer.php'; ?>
</body>

</html>