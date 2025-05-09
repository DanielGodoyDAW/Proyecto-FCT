<?php
require_once __DIR__ . '/../../../conexion/conexion.php';

if (session_status() === PHP_SESSION_NONE) session_start();
$idPaciente = $_SESSION['idPaciente'] ?? null;
if (!$idPaciente) {
    echo "<p>No hay paciente cargado.</p>";
    return;
}

// Obtener el idHistorial a partir del paciente
$stmt = $conexion->prepare("SELECT idHistorial FROM Pacientes WHERE idPacientes = ?");
$stmt->bind_param("i", $idPaciente);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "<p>No se encontró historial clínico para el paciente.</p>";
    return;
}
$idHistorial = $result->fetch_assoc()['idHistorial'];

// Obtener datos del historial
$stmt = $conexion->prepare("SELECT * FROM Historial WHERE idHistorial = ?");
$stmt->bind_param("i", $idHistorial);
$stmt->execute();
$result = $stmt->get_result();
$historial = $result->fetch_assoc();

// Verificar si se obtuvo del historial patologias hacemos un trim y un explode para convertirlo en array
$patologiasMarcadas = isset($historial['patologias']) ? array_map('trim', explode(',', $historial['patologias'])) : [];

//patologias predefinidas
$patologiasPredefinidas = ["Diabetes", "Colesterol", "HTA", "Alt. Coagulacion", "Artrosis", "Embarazo/Lactancia"];
//patologias personalizadas si es diferente a las predefinidas y no esta vacia
$patologiasPersonalizadas = array_diff($patologiasMarcadas, $patologiasPredefinidas);

?>
<script defer src="/Codigo/validaciones/historialClinico/editarHistorial/editarHistorial.js"></script>
<script defer src="/Codigo/validaciones/historialClinico/editarHistorial/agregarPatologia.js"></script>
<link rel="stylesheet" href="/Codigo/estilos/style.css">
<form action="/Codigo/validaciones/historialClinico/crearHistorial/validar_historial.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idPaciente" value="<?= htmlspecialchars($idPaciente) ?>">

    <table id="tabla_historial_clinico">
        <tr>
            <td><label for="fichaComentarioInicial">Descripcion</label></td>
            <td><textarea name="fichaComentarioInicial" id="fichaComentarioInicial"><?= htmlspecialchars($historial['fichaComentarioInicial']) ?></textarea></td>
        </tr>
        <tr>
            <td><label for="antec_podologicos">Antec. podológicos:</label></td>
            <td><textarea name="antec_podologicos" id="antec_podologicos"><?= htmlspecialchars($historial['antec_podologicos']) ?></textarea></td>
        </tr>
        <tr>
            <td><label for="antec_quirurgicos">Antec. quirúrgicos:</label></td>
            <td><textarea name="antec_quirurgicos" id="antec_quirurgicos"><?= htmlspecialchars($historial['antec_quirurgicos']) ?></textarea></td>
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
        <?php foreach ($patologiasPersonalizadas as $personalizada) { ?>
            <tr>
                <td></td>
                <td colspan="3">
                    <div class="patologia-input">
                        <input type="text" name="patologias[]" value="<?= htmlspecialchars($personalizada) ?>" style="width: 50%;">
                        <button type="button" class="eliminar-patologia" title="Eliminar">❌</button>
                    </div>
                </td>
            </tr>
        <?php }; ?>
        <tr>
            <td>Agregar patologia</td>
            <td colspan="3"><button id="agregarPatologia">Añadir</button></td>
        </tr>
        <tr>
            <td><label for="antecedentes">Antec. familiares:</label></td>
            <td><input type="text" name="antecedentes" id="antecedentes" value="<?= htmlspecialchars($historial['antecedentes']) ?>"></td>
        </tr>
        <tr>
            <td><label for="alergias">Alergias:</label></td>
            <td><input type="text" name="alergias" id="alergias" value="<?= htmlspecialchars($historial['alergias']) ?>"></td>
        </tr>
        <tr>
            <td><label for="farmacologia">Farmacologia:</label></td>
            <td><input type="text" name="farmacologia" id="farmacologia" value="<?= htmlspecialchars($historial['farmacologia']) ?>"></td>
        </tr>
        <tr>
            <td><label for="desarrolloPSi">Desarrollo psicomotriz:</label></td>
            <td><input type="text" name="desarrolloPSi" id="desarrolloPSi" value="<?= htmlspecialchars($historial['desarrolloPSi']) ?>"></td>
        </tr>
    </table>
    <table id="seguimiento">
        <tr>
            <td><label for="fecha">Fecha:</label></td>
            <td><input type="date" name="fecha" id="fecha" value="<?= htmlspecialchars($historial['fecha']) ?>"></td>
        </tr>
    </table>
    <button class="btnH" type="submit">Guardar Cambios</button>
</form>