<script defer src="/Codigo/validaciones/historialClinico/editarHistorial/editarHistorial.js"></script>
<?php
$idPaciente = $_GET['idPaciente'] ?? $_POST['idPaciente'] ?? null;

if (!$idPaciente) {
    echo '<input type="hidden" name="idPaciente" value="">';
    return;
}
$stmt = $conexion->prepare("SELECT * FROM Historial WHERE idPaciente = ?");
$stmt->bind_param("i", $idPaciente);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $historial = $result->fetch_assoc();
} else {
    echo "<p>No se encontró historial clínico para el paciente.</p>";
    exit;
}
$patologiasMarcadas = isset($historial['patologias']) ? explode(',', $historial['patologias']) : [];
?>
<form action="/Codigo/validaciones/historialClinico/crearHistorial/validar_historial_clinico.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idPaciente" value="<?php echo htmlspecialchars($idPaciente); ?>">
    <table id="tabla_historial_clinico">
        <tr>
            <td><label for="motivo">Motivo de la consulta:</label></td>
            <td><textarea name="motivo" id="motivo"><?php echo htmlspecialchars($historial['motivo']) ?></textarea></td>
        </tr>
        <tr>
            <td><label for="antec_podologicos">Antec. podológicos:</label></td>
            <td><textarea name="antec_podologicos" id="antec_podologicos"><?php echo htmlspecialchars($historial['antec_podologicos']) ?></textarea></td>
        </tr>
        <tr>
            <td><label for="antec_quirurgicos">Antec. quirúrgicos:</label></td>
            <td><textarea name="antec_quirurgicos" id="antec_quirurgicos"><?php echo htmlspecialchars($historial['antec_quirurgicos']) ?></textarea></td>
        </tr>
        <tr>
            <td><label for="patologias">Patologías:</label></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="checkbox" name="patologias[]" value="Diabetes" <?= in_array("Diabetes", $patologiasMarcadas) ? 'checked' : '' ?>>Diabetes</td>
            <td><input type="checkbox" name="patologias[]" value="Colesterol" <?= in_array("Colesterol", $patologiasMarcadas) ? 'checked' : '' ?>>Colesterol</td>
            <td><input type="checkbox" name="patologias[]" value="HTA" <?= in_array("HTA", $patologiasMarcadas) ? 'checked' : '' ?>>HTA</td>
        </tr>
        <tr>
            <td></td>
            <td><input type="checkbox" name="patologias[]" value="Alt. Coagulacion" <?= in_array("Alt. Coagulacion", $patologiasMarcadas) ? 'checked' : '' ?>>Alt. Coagulación</td>
            <td><input type="checkbox" name="patologias[]" value="Artrosis" <?= in_array("Artrosis", $patologiasMarcadas) ? 'checked' : '' ?>>Artrosis</td>
            <td><input type="checkbox" name="patologias[]" value="Embarazo/Lactancia" <?= in_array("Embarazo/Lactancia", $patologiasMarcadas) ? 'checked' : '' ?>>Embarazo/Lactancia</td>
        </tr>
        <tr>
            <td>Agregar patologia</td>
            <td><button id="agregarPatologia">Añadir</button></td>
        </tr>
        <tr>
            <td><label for="antecedentes">Antec. familiares:</label></td>
            <td><input type="text" name="antecedentes" id="antecedentes"><?php echo htmlspecialchars($historial['antecedentes']) ?></td>
        </tr>
        <tr>
            <td><label for="alergias">Alergias:</label></td>
            <td><input type="text" name="alergias" id="alergias"><?php echo htmlspecialchars($historial['alergias']) ?></td>
        </tr>
        <tr>
            <td><label for="farmacologia">Farmacologia:</label></td>
            <td><input type="text" name="farmacologia" id="farmacologia"><?php echo htmlspecialchars($historial['farmacologia']) ?></td>
        </tr>
        <tr>
            <td><label for="desarrolloPSi">Desarrollo psicomotriz:</label></td>
            <td><input type="text" name="desarrolloPSi" id="desarrolloPSi"><?php echo htmlspecialchars($historial['desarrolloPSi']) ?></td>
        </tr>
        <tr>
            <td><label for="observaciones">observaciones:</label></td>
            <td><textarea name="observaciones" id="observaciones"><?php echo htmlspecialchars($historial['observaciones']) ?></textarea></td>
        </tr>
    </table>
    <table id="inspeccion">
        <tr>
            <td><label for="archivo">Adjuntar Archivo:</label></td>
            <td><input type="file" name="archivo" id="archivo"></td>
        </tr>
        <tr>
            <td>Visualización imagen</td>
            <td>
                <?php
                if (!empty($historial['archivo'])) {
                    $rutaCompleta = $_SERVER['DOCUMENT_ROOT'] . $historial['archivo'];
                    if (file_exists($rutaCompleta)) {
                        echo '<img src="' . htmlspecialchars($historial['archivo']) . '" alt="Archivo adjunto" style="max-width: 300px; max-height: 200px;">';
                    } else {
                        echo '<p>El archivo no existe físicamente.</p>';
                    }
                } else {
                    echo '<p>No hay archivo disponible.</p>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="checkbox" name="onicopatias" value="onicopatias" <?php echo $historial['onicopatias'] ? 'checked' : '' ?>>Onicopatías</td>
        </tr>
        <tr>
            <td></td>
            <td><input type="checkbox" name="queratopatias" value="queratopatias" <?php echo $historial['queratopatias'] ? 'checked' : '' ?>>Queratopatias</td>
        </tr>
        <tr>
            <td></td>
            <td><input type="checkbox" name="dermatopatias" value="dermatopatias" <?php echo $historial['dermatopatias'] ? 'checked' : '' ?>>Dermatopatias</td>
        </tr>
        <tr>
            <td></td>
            <td><input type="checkbox" name="prominenciasOseas" value="prominenciasOseas" <?php echo $historial['prominenciasOseas'] ? 'checked' : '' ?>>Prominencias Oseas</td>
        </tr>
        <tr>
            <td></td>
            <td><input type="checkbox" name="altDigitales" value="altDigitales" <?php echo $historial['altDigitales'] ? 'checked' : '' ?>>Alt Digitales</td>
        </tr>
        <tr>
            <td><label for="dx">Descripcion:</label></td>
            <td><textarea name="dx" id="dx"></textarea><?php echo htmlspecialchars($historial['dx']) ?></td>
        </tr>
    </table>
    <table id="table-tratamiento">
        <tr>
            <td><label for="tratamiento">Tratamiento:</label></td>
            <td><textarea name="tratamiento" id="tratamiento"><?php echo htmlspecialchars($historial['tratamiento']) ?></textarea></td>
        </tr>
        <tr>
            <td><label for="receta">Receta:(Posologia/Duracion tto)</label></td>
            <td><textarea name="receta" id="receta"></textarea><?php echo htmlspecialchars($historial['receta']) ?></td>
        </tr>
    </table>
    <table id="seguimiento">
        <tr>
            <td><label for="fecha">Fecha:</label></td>
            <td><input type="date" name="fecha" id="fecha"><?php echo htmlspecialchars($historial['fecha']) ?></td>
        </tr>
        <tr>
            <td><label for="seguimiento">Seguimiento:</label></td>
            <td><textarea name="seguimiento" id="seguimiento"><?php echo htmlspecialchars($historial['seguimiento']) ?></textarea></td>
        </tr>
    </table>
    <button type="submit" name="">Editar</button>
</form>