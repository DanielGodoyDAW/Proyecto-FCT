<link rel="stylesheet" href="/Codigo/estilos/style.css">

<form action="/Codigo/validaciones/historialClinico/crearHistorial/validar_Crear_Informe.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idHistorial" value="<?= htmlspecialchars($idHistorial) ?>">

    <table id="tabla_nuevo_informe">
        <tr>
            <td><label for="fecha">Fecha:</label></td>
            <td><input type="date" name="fecha" value="<?= date('Y-m-d') ?>"></td>
        </tr>
        <tr>
            <td><label for="motivo">Motivo:</label></td>
            <td><textarea name="motivo" id="motivo"></textarea></td>
        </tr>
        <tr>
            <td><label for="descripcion">Descripción:</label></td>
            <td><textarea name="descripcion" id="descripcion"></textarea></td>
        </tr>
        <tr>
            <td><label for="observaciones">Observaciones:</label></td>
            <td><textarea name="observaciones" id="observaciones"></textarea></td>
        </tr>
        <?php
        $checkboxes = ['onicopatias', 'queratopatias', 'dermatopatias', 'prominenciasOseas', 'altDigitales'];
        foreach ($checkboxes as $check) {
            echo '<tr><td></td><td><input type="checkbox" name="' . $check . '" value="1"> ' . ucfirst($check) . '</td></tr>';
        }
        ?>
        <tr>
            <td><label for="archivo">Adjuntar archivo:</label></td>
            <td><input type="file" name="archivo" id="archivo"></td>
        </tr>
        <tr>
            <td><label for="dx">Diagnóstico:</label></td>
            <td><textarea name="dx" id="dx"></textarea></td>
        </tr>
        <tr>
            <td><label for="tratamiento">Tratamiento:</label></td>
            <td><textarea name="tratamiento" id="tratamiento"></textarea></td>
        </tr>
        <tr>
            <td><label for="receta">Receta:</label></td>
            <td><textarea name="receta" id="receta"></textarea></td>
        </tr>
    </table>
    <button class="btnH" type="submit">Crear nuevo informe</button>
</form>