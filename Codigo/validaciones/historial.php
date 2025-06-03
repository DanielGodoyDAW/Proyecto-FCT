<?php
// Muestra el historial de citas para el paciente o el administrador, con formato adaptado para móvil o escritorio

require_once __DIR__ . '/../conexion/conexion.php';
require_once __DIR__ . '/../utilidades.php';

//citas para móviles
function mostrarCitasComoTarjetas(array $listaCitas, bool $esAdministrador = false) {
    foreach ($listaCitas as $cita) {
        echo '<div class="tarjeta-cita">';
        echo '<p><strong>Fecha:</strong> ' . formatearFecha($cita['fecha']) . '</p>';
        echo '<p><strong>Hora:</strong> ' . $cita['hora'] . '</p>';
        echo '<p><strong>Nombre:</strong> ' . $cita['nombre'] . '</p>';
        echo '<p><strong>Apellidos:</strong> ' . $cita['apellido1'] . ' ' . $cita['apellido2'] . '</p>';

        if ($esAdministrador) {
            echo '<p><strong>Teléfono:</strong> ' . $cita['telefono'] . '</p>';
            echo '<p><a href="' . formatearWhatsApp($cita['telefono']) . '" target="_blank"><img class="redes" src="./imagenes/whatsapp.png" alt="WhatsApp"></a></p>';
        }

        echo '</div>';
    }
}

// citas en formato de escritorio
function mostrarCitasComoTabla(array $listaCitas, bool $esAdministrador = false) {
    echo '<table class="citas" border="1">
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Nombre</th>
            <th>Apellidos</th>';
    if ($esAdministrador) {
        echo '<th>Teléfono</th><th>WhatsApp</th>';
    }
    echo '</tr>';

    foreach ($listaCitas as $cita) {
        echo '<tr>';
        echo '<td>' . formatearFecha($cita['fecha']) . '</td>';
        echo '<td>' . $cita['hora'] . '</td>';
        echo '<td>' . $cita['nombre'] . '</td>';
        echo '<td>' . $cita['apellido1'] . ' ' . $cita['apellido2'] . '</td>';
        if ($esAdministrador) {
            echo '<td>' . $cita['telefono'] . '</td>';
            echo '<td><a href="' . formatearWhatsApp($cita['telefono']) . '" target="_blank"><img class="redes" src="./imagenes/whatsapp.png" alt="WhatsApp"></a></td>';
        }
        echo '</tr>';
    }

    echo '</table>';
}

// Detecta si el usuario accede desde móvil
$esDispositivoMovil = isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Mobile|Android|iPhone|iPad/i', $_SERVER['HTTP_USER_AGENT']);

// Consulta para administradores
if (isset($_SESSION["idAdmin"])) {
    $sqlCitasAdmin = "SELECT Citas.idCita, Citas.fecha, Citas.hora, Pacientes.nombre, Pacientes.apellido1, Pacientes.apellido2, Pacientes.telefono 
                      FROM Citas 
                      JOIN Pacientes ON Citas.idPacientes = Pacientes.idPacientes  
                      ORDER BY Citas.fecha ASC";
    $stmt = $conexion->prepare($sqlCitasAdmin);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $citasTotales = [];
    while ($fila = $resultado->fetch_assoc()) {
        $citasTotales[] = $fila;
    }

    // Muestra como tarjetas en móvil, o tabla en escritorio
    $esDispositivoMovil ? mostrarCitasComoTarjetas($citasTotales, true) : mostrarCitasComoTabla($citasTotales, true);

} else {
    // Consulta para paciente autenticado
    $idPaciente = $_SESSION["idPacientes"];

    $sqlCitasPaciente = "SELECT Citas.idCita, Citas.fecha, Citas.hora, Pacientes.nombre, Pacientes.apellido1, Pacientes.apellido2 
                         FROM Citas 
                         JOIN Pacientes ON Citas.idPacientes = Pacientes.idPacientes 
                         WHERE Citas.fecha BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE()) 
                         AND Citas.idPacientes = ? 
                         ORDER BY Citas.fecha ASC";
    $stmt = $conexion->prepare($sqlCitasPaciente);
    $stmt->bind_param("i", $idPaciente);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $citasDelPaciente = [];
    while ($fila = $resultado->fetch_assoc()) {
        $citasDelPaciente[] = $fila;
    }

    // Mostrar según el tipo de dispositivo
    $esDispositivoMovil ? mostrarCitasComoTarjetas($citasDelPaciente) : mostrarCitasComoTabla($citasDelPaciente);
}
?>
