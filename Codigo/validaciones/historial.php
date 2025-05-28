<?php
//consulta a la bd y muestra del historial de citas del paciente, con las antiguas y las proximas

require_once __DIR__ . '/../conexion/conexion.php';


//si eres admin

if (isset($_SESSION["idAdmin"])) {
    //consulta para ver todas las citas del mes (pasadas o futuras) de cada paciente
    $query = "SELECT Citas.idCita, Citas.fecha, Citas.hora, Pacientes.nombre, Pacientes.apellido1, Pacientes.apellido2, Pacientes.telefono 
              FROM Citas 
              JOIN Pacientes ON Citas.idPacientes = Pacientes.idPacientes  
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
            <th>WhatsApp</th>
        </tr>';
    foreach ($proximasCitas as $cita) {

        $formatter = new \IntlDateFormatter(
            'es_ES', // Localización para español de España
            \IntlDateFormatter::LONG,
            \IntlDateFormatter::NONE,
            'Europe/Madrid', // Zona horaria
            \IntlDateFormatter::GREGORIAN,
            "d 'de' MMMM 'de' yyyy" // Formato personalizado
        );

        $fecha = new DateTime($cita['fecha']);
        $fechaFormateada = $formatter->format($fecha);

        $telefonoCompleto = $cita['telefono'];
        preg_match('/^(\+\d+)\s*(.*)$/', $telefonoCompleto, $matches);

        $extension = $matches[1] ?? '+34'; //por defecto si no se encuentra la extension
        $telefono = $matches[2] ?? ''; //numero sin la extension
        $wasap = "https://wa.me/" . $extension . $telefono; //extension de wasap concatenado con el numero sin espacios
        echo '<tr>
            <td>' . $fechaFormateada  . '</td>
            <td>' . $cita['hora'] . '</td>
            <td>' . $cita['nombre'] . '</td>
            <td>' . $cita['apellido1'] . ' ' . $cita['apellido2'] . '</td>
            <td>' . $cita['telefono'] . '</td>
            <td>
                <a href="' . $wasap . '" target="_blank">
                    <img class="redes" src="./imagenes/whatsapp.png" alt="WhatsApp">
                </a>
            </td>
        </tr>';
    }
    echo '</table>';
} else {
    //si eres paciente
    $idPaciente = $_SESSION["idPacientes"];

    //consulta para ver todas las citas del mes (pasadas o futuras) de un paciente
    // Se utiliza DATE_FORMAT para obtener el primer día del mes actual y LAST_DAY para obtener el último día del mes actual
    // Se utiliza el id del paciente para filtrar las citas
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
