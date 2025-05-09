<?php
require_once __DIR__ . '/../../../conexion/conexion.php';

// Verificar si se obtuvo del historial patologias hacemos un trim y un explode para convertirlo en array
$patologiasMarcadas = isset($informe['patologias']) ? array_map('trim', explode(',', $informe['patologias'])) : [];

//patologias predefinidas
$patologiasPredefinidas = ["Diabetes", "Colesterol", "HTA", "Alt. Coagulacion", "Artrosis", "Embarazo/Lactancia"];
//patologias personalizadas si es diferente a las predefinidas y no esta vacia
$patologiasPersonalizadas = array_diff($patologiasMarcadas, $patologiasPredefinidas);
if ($ultimoInforme) {
?>
    <script defer src="/Codigo/validaciones/historialClinico/editarHistorial/editarHistorial.js"></script>
    <link rel="stylesheet" href="/Codigo/estilos/style.css">
    <form action="/Codigo/validaciones/historialClinico/crearHistorial/validar_Editar_Informe.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idPaciente" value="<?= htmlspecialchars($idPaciente) ?>">
        <input type="hidden" name="idInforme" value="<?= $ultimoInforme['idInforme'] ?>">
        <h3>Editar Informe</h3>
        <table class="tabla_historial_clinico">
            <tr>
                <td><label for="fecha">Fecha:</label></td>
                <td><?php
                    $fechaInput = '';
                    if (!empty($ultimoInforme['fecha'])) {
                        $fechaInput = (new DateTime($ultimoInforme['fecha']))->format('Y-m-d');
                    }
                    ?>
                    <input type="date" name="fecha" value="<?= $fechaInput ?>">
                </td>
            </tr>
            <tr>
                <td><label for="motivo">Motivo de la consulta:</label></td>
                <td><textarea name="motivo" id="motivo"><?= htmlspecialchars($ultimoInforme['motivo']) ?></textarea></td>
            </tr>
            <tr>
                <td><label for="descripcion">Descripcion</label></td>
                <td><textarea name="descripcion" id="descripcion"><?= htmlspecialchars($ultimoInforme['descripcion']) ?></textarea></td>
            </tr>
            <tr>
                <td><label for="observaciones">Observaciones:</label></td>
                <td><textarea name="observaciones" id="observaciones"><?= htmlspecialchars($ultimoInforme['observaciones']) ?></textarea></td>
            </tr>
            </tr>
            <?php
            $checkboxes = ['onicopatias', 'queratopatias', 'dermatopatias', 'prominenciasOseas', 'altDigitales'];
            foreach ($checkboxes as $check) {
                echo '<tr><td></td><td><input type="checkbox" name="' . $check . '" value="' . $check . '" ' . ($ultimoInforme[$check] ? 'checked' : '') . '> ' . ucfirst($check) . '</td></tr>';
            }
            ?>
        </table>
        <table class="tabla_historial_clinico" id="inspeccion">
            <tr>
                <td><label for="archivo">Adjuntar Archivo:</label></td>
                <td><input type="file" name="archivo" id="archivo"></td>
            </tr>
            <tr>
                <td>Visualización imagen:</td>
                <td>
                    <?php
                    if (!empty($ultimoInforme['archivo'])) {
                        $ruta = $_SERVER['DOCUMENT_ROOT'] . $ultimoInforme['archivo'];
                        if (file_exists($ruta)) {
                            echo '<img src="' . htmlspecialchars($ultimoInforme['archivo']) . '" style="max-width:300px;">';
                        } else {
                            echo '<p>El archivo no existe físicamente.</p>';
                        }
                    } else {
                        echo '<p>No hay archivo disponible.</p>';
                    }
                    ?>
                </td>
            </tr>
        </table>
        <table class="tabla_historial_clinico" id="patologias">
            <tr>
                <td><label for="dx">Diagnostico:</label></td>
                <td><textarea name="dx" id="dx"><?= htmlspecialchars($ultimoInforme['dx']) ?></textarea></td>
            </tr>
            <tr>
                <td><label for="tratamiento">Tratamiento:</label></td>
                <td><textarea name="tratamiento" id="tratamiento"><?= htmlspecialchars($ultimoInforme['tratamiento']) ?></textarea></td>
            </tr>
            <tr>
                <td><label for="receta">Receta:(Posologia/Duracion tto)</label></td>
                <td><textarea name="receta" id="receta"><?= htmlspecialchars($ultimoInforme['receta']) ?></textarea></td>
            </tr>
        </table>
        <button class="btnH" type="submit">Guardar Cambios</button>
    </form>
<?php
    echo "<h3>Agregar nuevo informe</h3>";
    include '../Codigo/validaciones/historialClinico/crearHistorial/crearInforme.php';
} else {
    echo "<p>No se encontró ningún informe. Agregar nuevo</p>";
    include '../Codigo/validaciones/historialClinico/crearHistorial/crearInforme.php';
}
