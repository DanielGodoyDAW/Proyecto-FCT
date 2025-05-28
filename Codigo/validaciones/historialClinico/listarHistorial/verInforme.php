<link rel="stylesheet" href="/Codigo/estilos/styleColores.css">
<link rel="stylesheet" href="/Codigo/estilos/styleAdmin.css">

<?php
require_once __DIR__ . '/../../../conexion/conexion.php';

if (session_status() === PHP_SESSION_NONE) session_start();
$idPaciente = $_SESSION['idPaciente'] ?? null;
if (!$idPaciente) {
    echo "<p>No hay paciente cargado.</p>";
    return;
}

// Obtener idHistorial
$stmt = $conexion->prepare("SELECT idHistorial FROM Pacientes WHERE idPacientes = ?");
$stmt->bind_param("i", $idPaciente);
$stmt->execute();
$result = $stmt->get_result();
$idHistorial = $result->fetch_assoc()['idHistorial'] ?? null;

if (!$idHistorial) {
    echo "<p>No se encontró historial clínico.</p>";
    return;
}

// Si hay un informe específico por GET, lo buscamos
if (isset($_GET['idInforme']) && is_numeric($_GET['idInforme'])) {
    $stmt = $conexion->prepare("SELECT * FROM Informe WHERE idInforme = ? AND idHistorial = ?");
    $stmt->bind_param("ii", $_GET['idInforme'], $idHistorial);
} else {
    // Mostrar el último informe si no se seleccionó ninguno
    $stmt = $conexion->prepare("SELECT * FROM Informe WHERE idHistorial = ? ORDER BY fecha DESC LIMIT 1");
    $stmt->bind_param("i", $idHistorial);
}

$stmt->execute();
$result = $stmt->get_result();

if ($fila = $result->fetch_assoc()) {
    $formatter = new \IntlDateFormatter(
        'es_ES',
        \IntlDateFormatter::LONG,
        \IntlDateFormatter::NONE,
        'Europe/Madrid',
        \IntlDateFormatter::GREGORIAN,
        "d 'de' MMMM 'de' yyyy"
    );

    $fecha = new DateTime($fila['fecha']);
    $fechaFormateada = $formatter->format($fecha);

    echo '<div class="columna">';
    echo '<h3>Informe del ' . htmlspecialchars($fechaFormateada) . '</h3>';
    echo '<table class="citas">';
    echo '<tr><th>ID Informe</th><td>' . htmlspecialchars($fila['idInforme']) . '</td></tr>';
    echo '<tr><th>Motivo</th><td>' . nl2br(htmlspecialchars($fila['motivo'])) . '</td></tr>';
    echo '<tr><th>Descripción</th><td>' . nl2br(htmlspecialchars($fila['descripcion'])) . '</td></tr>';
    echo '<tr><th>Observaciones</th><td>' . nl2br(htmlspecialchars($fila['observaciones'])) . '</td></tr>';

    echo '<tr><th>Patologías detectadas</th><td><ul style="margin:0;padding-left:18px;">';
    if ($fila['onicopatias']) echo '<li>Onicopatías</li>';
    if ($fila['queratopatias']) echo '<li>Queratopatías</li>';
    if ($fila['dermatopatias']) echo '<li>Dermatopatías</li>';
    if ($fila['prominenciasOseas']) echo '<li>Prominencias óseas</li>';
    if ($fila['altDigitales']) echo '<li>Alteraciones digitales</li>';
    echo '</ul></td></tr>';

    echo '<tr><th>Diagnóstico</th><td>' . nl2br(htmlspecialchars($fila['dx'])) . '</td></tr>';
    echo '<tr><th>Tratamiento</th><td>' . nl2br(htmlspecialchars($fila['tratamiento'])) . '</td></tr>';
    echo '<tr><th>Receta</th><td>' . nl2br(htmlspecialchars($fila['receta'])) . '</td></tr>';

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
    echo '</div>';
} else {
    echo "<p>No se encontró el informe seleccionado.</p>";
}
?>
