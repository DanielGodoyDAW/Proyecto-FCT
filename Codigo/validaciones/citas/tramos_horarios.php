<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Verificar si se recibió la fecha
    if (isset($_POST['fecha'])) {
        $fechaSeleccionada = $_POST['fecha']; // Fecha seleccionada (YYYY-MM-DD)

        // Definir los tramos horarios de la mañana y la tarde
        $tramosHorariosManana = array(
            "09:00" => "09:30",
            "09:30" => "10:00",
            "10:00" => "10:30",
            "10:30" => "11:00",
            "11:00" => "11:30",
            "11:30" => "12:00",
            "12:00" => "12:30",
            "12:30" => "13:00",
        );

        $tramosHorariosTarde = array(
            "16:00" => "16:30",
            "16:30" => "17:00",
            "17:00" => "17:30",
            "17:30" => "18:00",
            "18:00" => "18:30",
            "18:30" => "19:00",
        );

        // Consultar los horarios reservados para la fecha seleccionada
        $query = "SELECT hora FROM Citas WHERE fecha = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s", $fechaSeleccionada);
        $stmt->execute();
        $result = $stmt->get_result();

        // Crear un array con los horarios reservados
        $horariosReservados = [];
        while ($row = $result->fetch_assoc()) {
            $horariosReservados[] = $row['hora'];
        }

        // Filtrar los horarios disponibles
        $horariosLibresManana = [];
        $horariosLibresTarde = [];

        $horaActual = date('H:i:s'); // Obtener la hora actual
        if ($fechaSeleccionada == date('Y-m-d')) {
            foreach ($tramosHorariosManana as $inicio => $fin) {
                if (!in_array($inicio . ":00", $horariosReservados) && strtotime($inicio . ":00") > strtotime($horaActual)) { //añadimos ":00" para que coincida con el formato de la base de datos
                    $horariosLibresManana[$inicio] = $fin;
                }
            }

            foreach ($tramosHorariosTarde as $inicio => $fin) {
                if (!in_array($inicio . ":00", $horariosReservados) && strtotime($inicio . ":00") > strtotime($horaActual)) {
                    $horariosLibresTarde[$inicio] = $fin;
                }
            }
        } else {
            foreach ($tramosHorariosManana as $inicio => $fin) {
                if (!in_array($inicio . ":00", $horariosReservados)) { //añadimos ":00" para que coincida con el formato de la base de datos
                    $horariosLibresManana[$inicio] = $fin;
                }
            }

            foreach ($tramosHorariosTarde as $inicio => $fin) {
                if (!in_array($inicio . ":00", $horariosReservados)) {
                    $horariosLibresTarde[$inicio] = $fin;
                }
            }
        }

        $formatter = new \IntlDateFormatter(
            'es_ES', // Localización para español de España
            \IntlDateFormatter::LONG,
            \IntlDateFormatter::NONE,
            'Europe/Madrid', // Zona horaria
            \IntlDateFormatter::GREGORIAN,
            "d 'de' MMMM 'de' yyyy" // Formato personalizado
        );

        $fecha = new DateTime($fechaSeleccionada);
        $fechaFormateada = $formatter->format($fecha);


        // Mostrar los horarios libres en dos columnas
        echo '<h2>Selecciona un tramo horario</h2>';
        echo '<h3>Horarios disponibles para ' . $fechaFormateada . ':</h3>';
        echo '<div class="horarios-container">';

        // Columna de la mañana
        echo '<div class="horarios-columna">';
        echo '<h4>Horario de Mañana:</h4>';
        if (!empty($horariosLibresManana)) {
            echo '<form action="/Codigo/validaciones/pago/pago_cita.php" method="post">';
            //echo '<form action="/Codigo/validaciones/citas/reservar_tramo.php" method="post">';
            foreach ($horariosLibresManana as $inicio => $fin) {
                echo '<button type="submit" name="hora" value="' . $inicio . '" class="btn-horario">' . $inicio . ' - ' . $fin . '</button><br>';
            }
            echo '<input type="hidden" name="fecha" value="' . $fechaSeleccionada . '">';
            echo '</form>';
        } else {
            echo '<p>No hay horarios disponibles en la mañana.</p>';
        }
        echo '</div>';

        // Columna de la tarde
        echo '<div class="horarios-columna">';
        echo '<h4>Horario de Tarde:</h4>';
        if (date("w", strtotime($fechaSeleccionada)) != 5) {
            if (!empty($horariosLibresTarde)) {
                echo '<form action="/Codigo/validaciones/pago/pago_cita.php" method="post">';
                //echo '<form action="/Codigo/validaciones/citas/reservar_tramo.php" method="post">';
                foreach ($horariosLibresTarde as $inicio => $fin) {
                    echo '<button type="submit" name="hora" value="' . $inicio . '" class="btn-horario">' . $inicio . ' - ' . $fin . '</button><br>';
                }
                echo '<input type="hidden" name="fecha" value="' . $fechaSeleccionada . '">';
                echo '</form>';
            } else {
                echo '<p>No hay horarios disponibles en la tarde.</p>';
            }
        }else{
            echo '<p>Los Viernes por la tarde no hay consulta.</p>';
        }
        echo '</div>';

        echo '</div>'; // Cierre de horarios-container
    } else {
        // Si no se recibió la fecha, mostrar un mensaje de error
        echo '<p>Error: No se recibió la fecha seleccionada.</p>';
    }
}
