<div id="agregarServicio" class="fila">
    <div class="seccion promociones">
        <h2>Agregar Servicio</h2>
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