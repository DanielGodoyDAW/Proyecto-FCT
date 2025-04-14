<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Codigo/estilos/styleAdmin.css">
    <title>Administracion</title>
</head>

<body>
    <?php require_once '../Codigo/plantillas/header.php'; ?>
    <main class="contenedor">
        <!-- Fila 1: Búsqueda de pacientes -->
        <div class="fila">
            <div class="seccion busqueda">
                <h2>Búsqueda de Paciente</h2>
                <?php require_once '../Codigo/validaciones/busqueda.php'; ?>
            </div>
            <div class="seccion resultado-busqueda">
                <h2>Resultado de la Búsqueda</h2>
                <div id="resultado-busqueda">
                    <?php
                    if (isset($_SESSION['impresion'])) {
                        echo $_SESSION['impresion'];
                        unset($_SESSION['impresion']); // Limpiar los resultados después de mostrarlos
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Fila 2: Promociones -->
        <div class="fila">
            <div class="seccion promociones">
                <h2>Agregar Promoción</h2>
                <?php require_once '../Codigo/validaciones/promociones/promociones_form.php'; ?>
            </div>
            <div class="seccion promociones-lista">
                <h2>Promociones Existentes</h2>
                <?php
                $mostrarEditar = true;
                require_once '../Codigo/validaciones/promociones/promociones_lista.php';
                ?>
            </div>
        </div>

        <!-- Fila 3: Tratamientos -->
        <div class="fila">
            <div class="seccion tratamientos">
                <h2>Creación de Tratamientos</h2>
                <?php require_once '../Codigo/validaciones/tratamientos.php'; ?>
            </div>
            <div class="seccion tratamientos-lista">
                <h2>Listado de Tratamientos</h2>
                <div id="listado-tratamientos"></div>
            </div>
        </div>
    </main>
    <?php require_once '../Codigo/plantillas/footer.php'; ?>
</body>

</html>