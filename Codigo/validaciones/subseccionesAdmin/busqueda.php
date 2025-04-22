<div id="busqueda" class="fila">
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
                unset($_SESSION['impresion']);
            }
            ?>
        </div>
    </div>
</div>