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

$patologiasMarcadas = isset($historial['patologias']) ? array_map('trim', explode(',', $historial['patologias'])) : [];
?>
<script defer src="/Codigo/validaciones/historialClinico/editarHistorial/editarHistorial.js"></script>
<link rel="stylesheet" href="/Codigo/estilos/style.css">
<form action="/Codigo/validaciones/historialClinico/crearHistorial/validar_historial_clinico.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idPaciente" value="<?= htmlspecialchars($idPaciente) ?>">

    <table id="tabla_historial_clinico">
        <tr>
            <td><label for="motivo">Motivo de la consulta:</label></td>
            <td><textarea name="motivo" id="motivo"><?= htmlspecialchars($historial['motivo']) ?></textarea></td>
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
        <tr>
            <td>Agregar patologia</td>
            <td><button id="agregarPatologia">Añadir</button></td>
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
        <tr>
            <td><label for="observaciones">Observaciones:</label></td>
            <td><textarea name="observaciones" id="observaciones"><?= htmlspecialchars($historial['observaciones']) ?></textarea></td>
        </tr>
    </table>

    <table id="inspeccion">
        <tr>
            <td><label for="archivo">Adjuntar Archivo:</label></td>
            <td><input type="file" name="archivo" id="archivo"></td>
        </tr>
        <tr>
            <td>Visualización imagen:</td>
            <td>
                <?php
                if (!empty($historial['archivo'])) {
                    $ruta = $_SERVER['DOCUMENT_ROOT'] . $historial['archivo'];
                    if (file_exists($ruta)) {
                        echo '<img src="' . htmlspecialchars($historial['archivo']) . '" style="max-width:300px;">';
                    } else {
                        echo '<p>El archivo no existe físicamente.</p>';
                    }
                } else {
                    echo '<p>No hay archivo disponible.</p>';
                }
                ?>
            </td>
        </tr>
        <?php
        $checkboxes = ['onicopatias', 'queratopatias', 'dermatopatias', 'prominenciasOseas', 'altDigitales'];
        foreach ($checkboxes as $check) {
            echo '<tr><td></td><td><input type="checkbox" name="' . $check . '" value="' . $check . '" ' . ($historial[$check] ? 'checked' : '') . '> ' . ucfirst($check) . '</td></tr>';
        }
        ?>
        <tr>
            <td><label for="dx">Descripcion:</label></td>
            <td><textarea name="dx" id="dx"><?= htmlspecialchars($historial['dx']) ?></textarea></td>
        </tr>
    </table>

    <table id="table-tratamiento">
        <tr>
            <td><label for="tratamiento">Tratamiento:</label></td>
            <td><textarea name="tratamiento" id="tratamiento"><?= htmlspecialchars($historial['tratamiento']) ?></textarea></td>
        </tr>
        <tr>
            <td><label for="receta">Receta:(Posologia/Duracion tto)</label></td>
            <td><textarea name="receta" id="receta"><?= htmlspecialchars($historial['receta']) ?></textarea></td>
        </tr>
    </table>

    <table id="seguimiento">
        <tr>
            <td><label for="fecha">Fecha:</label></td>
            <td><input type="date" name="fecha" id="fecha" value="<?= htmlspecialchars($historial['fecha']) ?>"></td>
        </tr>
        <tr>
            <td><label for="seguimiento">Seguimiento:</label></td>
            <td><textarea name="seguimiento" id="seguimiento"><?= htmlspecialchars($historial['seguimiento']) ?></textarea></td>
        </tr>
    </table>

    <button type="submit">Guardar Cambios</button>
</form>

<div class="acciones-historial">
    <button class="btnH" onclick="location.href='/Codigo/admin.php'">Volver</button>
    <button class="btnH" onclick="mostrarHistorial('ver')">👁 Ver Historial</button>
</div>