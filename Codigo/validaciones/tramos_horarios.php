<?php
require_once __DIR__ . '/../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Verificar si se recibió la fecha
    if (isset($_POST['fecha'])) {
        $fechaSeleccionada = $_POST['fecha']; // Fecha seleccionada (YYYY-MM-DD)

        // Definir los tramos horarios
        $tramosHorarios = array_merge(
            array(
                "09:00" => "09:30",
                "09:30" => "10:00",
                "10:00" => "10:30",
                "10:30" => "11:00",
                "11:00" => "11:30",
                "11:30" => "12:00",
                "12:00" => "12:30",
                "12:30" => "13:00",
            ),
            array(
                "16:00" => "16:30",
                "16:30" => "17:00",
                "17:00" => "17:30",
                "17:30" => "18:00",
                "18:00" => "18:30",
                "18:30" => "19:00",
            )
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
        $horariosLibres = [];
        foreach ($tramosHorarios as $inicio => $fin) {
            if (!in_array($inicio, $horariosReservados)) {
                $horariosLibres[$inicio] = $fin;
            }
        }

        // Mostrar los horarios libres en formato HTML
        echo '<h3>Horarios disponibles para ' . $fechaSeleccionada . ':</h3>';
        if (!empty($horariosLibres)) {
            echo '<ul>';
            foreach ($horariosLibres as $inicio => $fin) {
                echo '<li>' . $inicio . ' - ' . $fin . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No hay horarios disponibles para esta fecha.</p>';
        }
    } else {
        // Si no se recibió la fecha, mostrar un mensaje de error
        echo '<p>Error: No se recibió la fecha seleccionada.</p>';
    }
}

?>
