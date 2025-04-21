<?php
//consulta a la bd y muestra del historial de citas del paciente, con las antiguas y las proximas

require_once __DIR__ . '/../conexion/conexion.php';

//si eres admin

if (isset($_SESSION["idAdmin"])) {
    //consulta para ver todas las citas del mes (pasadas o futuras) de cada paciente
    $query = "SELECT Citas.idCita, Citas.fecha, Citas.hora, Pacientes.nombre, Pacientes.apellido1, Pacientes.apellido2, Pacientes.telefono 
              FROM Citas 
              JOIN Pacientes ON Citas.idPacientes = Pacientes.idPacientes 
              WHERE Citas.fecha >= CURDATE() 
              ORDER BY Citas.fecha ASC";
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
    // Mostrar las próximas citas
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
} else {
    //si eres paciente
    $idPaciente = $_SESSION["idPacientes"];

    $query = "SELECT Citas.idCita, Citas.fecha, Citas.hora, Pacientes.nombre, Pacientes.apellido1, Pacientes.apellido2 
          FROM Citas 
          JOIN Pacientes ON Citas.idPacientes = Pacientes.idPacientes 
          WHERE Citas.fecha BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE()) 
          AND Citas.idPacientes = ? 
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
    // Mostrar las próximas citas
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
}

?>
