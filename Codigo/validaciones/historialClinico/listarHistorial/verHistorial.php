<link rel="stylesheet" href="./estilos/styleColores.css">
<link rel="stylesheet" href="./estilos/styleAdmin.css">
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
        '<img class="whatsapp-icon" src="./imagenes/whatsapp.png" alt="WhatsApp">' .
        '</a></td></tr>';
    echo '<tr><th>DNI</th><td>' . htmlspecialchars($fila['dni']) . '</td></tr>';
    echo '<tr><th>Fecha de nacimiento</th><td>' . htmlspecialchars($fechaFormateada) . '</td></tr>';

    echo '<tr><th>Descripción</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['fichaComentarioInicial'])) . '</td></tr>';
    echo '<tr><th>Antecedentes podológicos</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['antec_podologicos'])) . '</td></tr>';
    echo '<tr><th>Antecedentes quirúrgicos</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['antec_quirurgicos'])) . '</td></tr>';
    echo '<tr><th>Patologías</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['patologias'])) . '</td></tr>';
    echo '<tr><th>Antecedentes familiares</th><td>' . nl2br(htmlspecialchars($fila['antecedentes'])) . '</td></tr>';
    echo '<tr><th>Alergias</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['alergias'])) . '</td></tr>';
    echo '<tr><th>Farmacología</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['farmacologia'])) . '</td></tr>';
    echo '<tr><th>Desarrollo psicomotriz</th><td class="texto-limitado">' . nl2br(htmlspecialchars($fila['desarrolloPSi'])) . '</td></tr>';

    echo '</table>';
    echo '</div>';
}
