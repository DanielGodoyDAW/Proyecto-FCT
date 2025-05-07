<link rel="stylesheet" href="/Codigo/estilos/styleAdmin.css">
<?php
require_once __DIR__ . '/../../../conexion/conexion.php';

if (session_status() === PHP_SESSION_NONE) session_start();
$idPaciente = $_SESSION['idPaciente'] ?? null;
if (!$idPaciente) {
    echo "<p>No hay paciente cargado.</p>";
    return;
}

$sql = "SELECT 
            H.*,
            P.nombre,
            P.apellido1,
            P.apellido2,
            P.telefono,
            P.dni,
            P.fechaNacim
        FROM Pacientes P
        LEFT JOIN Historial H ON P.idHistorial = H.idHistorial
        WHERE P.idPacientes = ?
        ORDER BY H.fecha DESC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $idPaciente);
$stmt->execute();
$result = $stmt->get_result();

while ($fila = $result->fetch_assoc()) {
    $nombreCompleto = $fila['nombre'] . ' ' . $fila['apellido1'];
    if (!empty($fila['apellido2'])) {
        $nombreCompleto .= ' ' . $fila['apellido2'];
    }

    $formatter = new \IntlDateFormatter(
        'es_ES', // Localización para español de España
        \IntlDateFormatter::LONG,
        \IntlDateFormatter::NONE,
        'Europe/Madrid', // Zona horaria
        \IntlDateFormatter::GREGORIAN,
        "d 'de' MMMM 'de' yyyy" // Formato personalizado
    );

    $fecha = new DateTime($fila['fechaNacim']);
    $fecha2 = new DateTime($fila['fecha']);
    $fechaFormateada = $formatter->format($fecha);
    $fechaFormateada2 = $formatter->format($fecha2);

    $telefonoCompleto = $fila['telefono'];
    preg_match('/^(\+\d+)\s*(.*)$/', $telefonoCompleto, $matches);

    $extension = $matches[1] ?? '+34'; //por defecto si no se encuentra la extension
    $telefono = $matches[2] ?? ''; //numero sin la extension
    $wasap = "https://wa.me/" . $extension . $telefono; //extension de wasap concatenado con el numero sin espacios

    // Textareas aplicados clase y nl2br para saltos de línea

    echo '<div class="columna">';
    echo '<h3>Consulta del ' . htmlspecialchars($fechaFormateada2) . '</h3>';
    echo '<table class="citas">';
    echo '<tr><th>Paciente</th><td>' . htmlspecialchars($nombreCompleto) . '</td></tr>';
    echo '<tr><th>Teléfono</th><td>' . htmlspecialchars($fila['telefono']) .
        '<a href="' . $wasap . '" target="_blank" title="Abrir chat en WhatsApp">' .
        '<img class="whatsapp-icon" src="/Codigo/imagenes/whatsapp.png" alt="WhatsApp">' .
        '</a></td></tr>';
    echo '<tr><th>DNI</th><td>' . htmlspecialchars($fila['dni']) . '</td></tr>';
    echo '<tr><th>Fecha de nacimiento</th><td>' . htmlspecialchars($fechaFormateada) . '</td></tr>';
    echo '<tr><th>Motivo</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['motivo'])) . '</td></tr>';
    echo '<tr><th>Descripción</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['descripcion'])) . '</td></tr>';
    echo '<tr><th>Antecedentes podológicos</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['antec_podologicos'])) . '</td></tr>';
    echo '<tr><th>Antecedentes quirúrgicos</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['antec_quirurgicos'])) . '</td></tr>';
    echo '<tr><th>Antecedentes familiares</th><td>' . htmlspecialchars($fila['antecedentes']) . '</td></tr>';
    echo '<tr><th>Alergias</th><td>' . htmlspecialchars($fila['alergias']) . '</td></tr>';
    echo '<tr><th>Farmacología</th><td>' . htmlspecialchars($fila['farmacologia']) . '</td></tr>';
    echo '<tr><th>Desarrollo psicomotriz</th><td>' . htmlspecialchars($fila['desarrolloPSi']) . '</td></tr>';
    echo '<tr><th>Observaciones</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['observaciones'])) . '</td></tr>';
    echo '<tr><th>Receta</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['receta'])) . '</td></tr>';
    echo '<tr><th>Seguimiento</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['seguimiento'])) . '</td></tr>';
    echo '<tr><th>Patologías detectadas</th><td><ul style="margin:0;padding-left:18px;">';
    if ($fila['onicopatias']) echo '<li>Onicopatías</li>';
    if ($fila['queratopatias']) echo '<li>Queratopatías</li>';
    if ($fila['dermatopatias']) echo '<li>Dermatopatías</li>';
    if ($fila['prominenciasOseas']) echo '<li>Prominencias óseas</li>';
    if ($fila['altDigitales']) echo '<li>Alteraciones digitales</li>';
    echo '</ul></td></tr>';

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
    echo '</div>';
    echo '</div>';
}
