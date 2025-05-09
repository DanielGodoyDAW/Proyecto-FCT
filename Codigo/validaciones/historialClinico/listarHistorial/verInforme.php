<link rel="stylesheet" href="/Codigo/estilos/styleAdmin.css">
<?php
require_once __DIR__ . '/../../../conexion/conexion.php';

if (session_status() === PHP_SESSION_NONE) session_start();
$idPaciente = $_SESSION['idPaciente'] ?? null;
if (!$idPaciente) {
    echo "<p>No hay paciente cargado.</p>";
    return;
}
//Buscamos al paciente
$stmt = $conexion->prepare("SELECT idHistorial FROM Pacientes WHERE idPacientes = ?");
$stmt->bind_param("i", $idPaciente);
$stmt->execute();
$result = $stmt->get_result();
$idHistorial = $result->fetch_assoc()['idHistorial'];


while ($fila = $result->fetch_assoc()) {

    $formatter = new \IntlDateFormatter(
        'es_ES', // Localización para español de España
        \IntlDateFormatter::LONG,
        \IntlDateFormatter::NONE,
        'Europe/Madrid', // Zona horaria
        \IntlDateFormatter::GREGORIAN,
        "d 'de' MMMM 'de' yyyy" // Formato personalizado
    );

    $fecha = new DateTime($fila['fecha']);
    $fechaFormateada2 = $formatter->format($fecha);

    // Textareas aplicados clase y nl2br para saltos de línea

    echo '<div class="columna">';
    echo '<h3>Consulta del ' . htmlspecialchars($fechaFormateada2) . '</h3>';
    echo '<table class="citas">';
    echo '<tr><th>Numero de Informe</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['idInforme'])) . '</td></tr>';
    echo '<tr><th>Correspondiente al Historial</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['idHistorial'])) . '</td></tr>';
    echo '<tr><th>A Fecha de</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['fecha'])) . '</td></tr>';
    echo '<tr><th>Motivo</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['motivo'])) . '</td></tr>';
    echo '<tr><th>Descripcion:</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['descripcion'])) . '</td></tr>';
    echo '<tr><th>Patologías</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['patologias'])) . '</td></tr>';
    echo '<tr><th>Observaciones</th><td>' . nl2br(htmlspecialchars($fila['observaciones'])) . '</td></tr>';
    echo '<tr><th>Patologías detectadas</th><td><ul style="margin:0;padding-left:18px;">';
    if ($fila['onicopatias']) echo '<li>Onicopatías</li>';
    if ($fila['queratopatias']) echo '<li>Queratopatías</li>';
    if ($fila['dermatopatias']) echo '<li>Dermatopatías</li>';
    if ($fila['prominenciasOseas']) echo '<li>Prominencias óseas</li>';
    if ($fila['altDigitales']) echo '<li>Alteraciones digitales</li>';
    echo '</ul></td></tr>';
    echo '<tr><th>Diagnóstico detallado</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['dx'])) . '</td></tr>';
    echo '<tr><th>Tratamiento</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['tratamiento'])) . '</td></tr>';
    echo '<tr><th>Receta</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['receta'])) . '</td></tr>';
    // Archivo adjunto
    if (!empty($fila['archivo'])) {
        echo '<tr><th>Archivo adjunto</th><td>';
        $ext = pathinfo($fila['archivo'], PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif'])) {
            echo '<img src="' . htmlspecialchars($fila['archivo']) . '" width="150">';
        } else {
            echo '<a href="' . htmlspecialchars($fila['archivo']) . '" target="_blank">Descargar archivo</a>';
        }
        echo '</td></tr>';
    }

    echo '</table>';
    echo '<div style="text-align:right; margin-top:10px;">';
    echo '<button class="btnH" onclick="mostrarHistorial(\'editar\')">✏️ Editar Historial</button>';
    echo "<button class='btnH' onclick=\"location.href='/Codigo/admin.php'\">⬅ Volver</button>";
    echo '</div>';
    echo '</div>';
}
