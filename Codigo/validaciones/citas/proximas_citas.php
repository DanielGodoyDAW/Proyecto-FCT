<link rel="stylesheet" href="./estilos/styleColores.css">
<link rel="stylesheet" href="./estilos/styleCitas.css">
<?php
// Este archivo se encarga de mostrar las próximas citas y el historial de citas del paciente o administrador

require_once __DIR__ . '/../../conexion/conexion.php';
require_once __DIR__ . '/../../utilidades.php';

// Detecta si el usuario accede desde móvil
$esDispositivoMovil = isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Mobile|Android|iPhone|iPad/i', $_SERVER['HTTP_USER_AGENT']);

if (isset($_SESSION["idPacientes"])) {
    // Si el usuario es un paciente, se muestran solo sus citas
    $idPaciente = $_SESSION["idPacientes"];
    $query = "SELECT idCita, fecha, hora, nombre, apellido1, apellido2 FROM Citas INNER JOIN Pacientes ON Citas.idPacientes = Pacientes.idPacientes WHERE Citas.fecha >= CURDATE() AND Citas.idPacientes = ? ORDER BY Citas.fecha ASC";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $idPaciente);
    $esPaciente = true;
} else {
    // Si el usuario es un administrador, se muestran todas las citas desde hoy, con número de teléfono
    $query = "SELECT idCita, fecha, hora, nombre, apellido1, apellido2, telefono FROM Citas INNER JOIN Pacientes ON Citas.idPacientes = Pacientes.idPacientes WHERE Citas.fecha >= CURDATE() ORDER BY Citas.fecha ASC, Citas.hora ASC";
    $stmt = $conexion->prepare($query);
    $esPaciente = false;
}

$stmt->execute();
$result = $stmt->get_result();
$proximasCitas = [];
while ($row = $result->fetch_assoc()) {
    $proximasCitas[] = $row;
}

if (!$esDispositivoMovil) {
    // Mostrar la tabla de citas (vista de escritorio)
    echo '<table class="citas" border="1">';
    echo '<tr><th>Fecha</th><th>Hora</th><th>Nombre</th><th>Apellidos</th>';
    if (!$esPaciente) echo '<th>Teléfono</th><th>WhatsApp</th>';
    echo ($esPaciente ? '<th>Cancelar</th>' : '') . '</tr>';

    foreach ($proximasCitas as $cita) {
        echo '<tr>';
        echo '<td>' . formatearFecha($cita['fecha']) . '</td>';
        echo '<td>' . $cita['hora'] . '</td>';
        echo '<td>' . $cita['nombre'] . '</td>';
        echo '<td>' . $cita['apellido1'] . ' ' . $cita['apellido2'] . '</td>';

        if (!$esPaciente) {
            // Si es admin, mostrar teléfono y botón de WhatsApp
            echo '<td>' . $cita['telefono'] . '</td>';
            echo '<td><a href="' . formatearWhatsApp($cita['telefono']) . '" target="_blank"><img class="redes" src="./imagenes/whatsapp.png" alt="WhatsApp"></a></td>';
        } else {
            // Si es paciente, mostrar botón para cancelar cita
            echo '<td><form action="' . ruta_relativa('validaciones/citas/cancelar_cita.php') . '" method="post" onsubmit="return confirm(\'¿Estás seguro de que deseas cancelar esta cita?\');">';
            echo '<input type="hidden" name="idCita" value="' . $cita['idCita'] . '">';
            echo '<button type="submit" class="btnCancelar">Cancelar</button>';
            echo '</form></td>';
        }
        echo '</tr>';
    }
    echo '</table>';
} else {
    // Vista alternativa (responsive) para dispositivos móviles
    foreach ($proximasCitas as $cita) {
        echo '<div class="tarjeta-cita">';
        echo '<div><strong>Fecha:</strong> ' . htmlspecialchars(formatearFecha($cita['fecha'])) . '</div>';
        echo '<div><strong>Hora:</strong> ' . htmlspecialchars($cita['hora']) . '</div>';
        echo '<div><strong>Nombre:</strong> ' . htmlspecialchars($cita['nombre']) . '</div>';
        echo '<div><strong>Apellidos:</strong> ' . htmlspecialchars($cita['apellido1'] . ' ' . $cita['apellido2']) . '</div>';

        if (!$esPaciente) {
            echo '<div><strong>Teléfono:</strong> ' . htmlspecialchars($cita['telefono']) . '</div>';
            echo '<div><a href="' . formatearWhatsApp($cita['telefono']) . '" target="_blank"><img class="redes" src="./imagenes/whatsapp.png" alt="WhatsApp"></a></div>';
        } else {
            echo '<form action="' . ruta_relativa('validaciones/citas/cancelar_cita.php') . '" method="post" onsubmit="return confirm(\'¿Estás seguro de que deseas cancelar esta cita?\');">';
            echo '<input type="hidden" name="idCita" value="' . $cita['idCita'] . '">';
            echo '<button type="submit" class="btnCancelar">Cancelar</button>';
            echo '</form>';
        }
        echo '</div>';
    }
}

?>