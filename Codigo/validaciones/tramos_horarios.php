<?php
require_once __DIR__ . '/../conexion/conexion.php';

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

        // Obtener el día de la semana (0 = domingo, 1 = lunes, ..., 6 = sábado)
        $diaSemana = date('w', strtotime($fechaSeleccionada));

        // Si es viernes (5), solo mostrar los horarios de la mañana
        if ($diaSemana == 5) {
            $tramosHorarios = $tramosHorariosManana;
        } else {
            // Combinar los horarios de la mañana y la tarde
            $tramosHorarios = array_merge($tramosHorariosManana, $tramosHorariosTarde);
        }

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
        $horariosLibres = [];
        foreach ($tramosHorarios as $inicio => $fin) {
            if (!in_array($inicio, $horariosReservados)) {
                $horariosLibres[$inicio] = $fin;
            }
        }

        // Mostrar los horarios libres como botones
        echo '<h3>Horarios disponibles para ' . $fechaSeleccionada . ':</h3>';
        if (!empty($horariosLibres)) {
            echo '<form action="/Codigo/validaciones/reservar_tramo.php" method="post">';
            foreach ($horariosLibres as $inicio => $fin) {
                echo '<button type="submit" name="hora" value="' . $inicio . '" class="btn-horario">' . $inicio . ' - ' . $fin . '</button><br>';
            }
            echo '<input type="hidden" name="fecha" value="' . $fechaSeleccionada . '">';
            echo '</form>';
        } else {
            echo '<p>No hay horarios disponibles para esta fecha.</p>';
        }
    } else {
        // Si no se recibió la fecha, mostrar un mensaje de error
        echo '<p>Error: No se recibió la fecha seleccionada.</p>';
    }
}
?>
