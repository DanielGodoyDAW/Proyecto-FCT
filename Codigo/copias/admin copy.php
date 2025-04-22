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
                <?php require_once '../Codigo/validaciones/busqueda/busqueda.php'; ?>
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
                <h2>Agregar Servicio</h2> <!-- Cambiamos el nombre de promociones a servicios" -->
                <?php require_once '../Codigo/validaciones/promociones/promociones_form.php'; ?>
            </div>
            <div class="seccion promociones-lista">
                <h2>Servicios Existentes</h2>
                <?php
                $mostrarEditar = true;
                require_once '../Codigo/validaciones/promociones/promociones_lista.php';
                ?>
            </div>
        </div>

        <!-- Fila 3: Tratamientos -->
        <div class="fila">
            <div class="seccion historial">
                <h2>Creación Historial Clinico</h2>
                <?php require_once '../Codigo/validaciones/historialClinico/historial_clinico_form.php'; ?>
            </div>
            <div class="seccion historial-lista">
                <h2>Historiales Clinicos</h2>
                <div id="listado-historiales"></div>
            </div>
        </div>
    </main>
    <?php require_once '../Codigo/plantillas/footer.php'; ?>
</body>

</html>