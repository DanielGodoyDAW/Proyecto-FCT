<div id="agregarServicio" class="fila">
    <div class="seccion promociones">
        <h2>Agregar Servicio</h2>
        <?php require_once '../Codigo/validaciones/servicios/servicios_form.php'; ?>
    </div>
    <div class="seccion promociones-lista">
        <h2>Servicios Existentes</h2>
        <?php
        $mostrarEditar = true;
        require_once '../Codigo/validaciones/servicios/servicios_lista.php';
        ?>
    </div>
</div>