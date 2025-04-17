<link rel="stylesheet" href="/Codigo/estilos/styleCitas.css">
<?php
// Este archivo se encarga de mostrar las próximas citas y el historial de citas del paciente o administrador

require_once __DIR__ . '/../conexion/conexion.php';

if (isset($_SESSION["idPacientes"])) {
    // Si el usuario es un paciente, se muestran solo sus citas
    $idPaciente = $_SESSION["idPacientes"];

    $query = "SELECT Citas.idCita, Citas.fecha, Citas.hora, Pacientes.nombre, Pacientes.apellido1, Pacientes.apellido2 
              FROM Citas 
              INNER JOIN Pacientes ON Citas.idPacientes = Pacientes.idPacientes 
              WHERE Citas.fecha >= CURDATE() AND Citas.idPacientes = ? 
              ORDER BY Citas.fecha ASC";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $idPaciente);
    $stmt->execute();
    $result = $stmt->get_result();

    $proximasCitas = [];
    while ($row = $result->fetch_assoc()) {
        $proximasCitas[] = [
            'idCita' => $row['idCita'],
            'fecha' => $row['fecha'],
            'hora' => $row['hora'],
            'nombre' => $row['nombre'],
            'apellido1' => $row['apellido1'],
            'apellido2' => $row['apellido2']
        ];
    }

    // Mostrar las próximas citas del paciente
    echo '<table class="citas" border="1">
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Nombre</th>
            <th>Apellidos</th>
        </tr>';
    foreach ($proximasCitas as $cita) {
        echo '<tr>
            <td>' . $cita['fecha'] . '</td>
            <td>' . $cita['hora'] . '</td>
            <td>' . $cita['nombre'] . '</td>
            <td>' . $cita['apellido1'] . ' ' . $cita['apellido2'] . '</td>
        </tr>';
    }
    echo '</table>';
} else {
    // Si el usuario es un administrador, se muestran todas las citas con el teléfono incluido y por orden de hora
    $query = "SELECT Citas.idCita, Citas.fecha, Citas.hora, Pacientes.nombre, Pacientes.apellido1, Pacientes.apellido2, Pacientes.telefono 
              FROM Citas 
              INNER JOIN Pacientes ON Citas.idPacientes = Pacientes.idPacientes 
              WHERE Citas.fecha >= CURDATE() 
              ORDER BY Citas.fecha ASC, Citas.hora ASC";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $proximasCitas = [];
    while ($row = $result->fetch_assoc()) {
        $proximasCitas[] = [
            'idCita' => $row['idCita'],
            'fecha' => $row['fecha'],
            'hora' => $row['hora'],
            'nombre' => $row['nombre'],
            'apellido1' => $row['apellido1'],
            'apellido2' => $row['apellido2'],
            'telefono' => $row['telefono']
        ];
    }

    // Mostrar las próximas citas con el teléfono
    echo '<table class="citas" border="1">
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Teléfono</th>
        </tr>';
    foreach ($proximasCitas as $cita) {
        echo '<tr>
            <td>' . $cita['fecha'] . '</td>
            <td>' . $cita['hora'] . '</td>
            <td>' . $cita['nombre'] . '</td>
            <td>' . $cita['apellido1'] . ' ' . $cita['apellido2'] . '</td>
            <td>' . $cita['telefono'] . '</td>
        </tr>';
    }
    echo '</table>';
}
?>