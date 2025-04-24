<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Codigo/estilos/styleCalendario.css">
    <title>Calendario de Reserva</title>
</head>

<body>

    <div id="calendar-container">
        <div id="calendar-scroll">
            <?php

            $nombreMeses = [
                "1" => 'Enero',
                "2" => 'Febrero',
                "3" => 'Marzo',
                "4" => 'Abril',
                "5" => 'Mayo',
                "6" => 'Junio',
                "7" => 'Julio',
                "8" => 'Agosto',
                "9" => 'Septiembre',
                "10" => 'Octubre',
                "11" => 'Noviembre',
                "12" => 'Diciembre'
            ];

            require_once __DIR__ . '/../../conexion/conexion.php';

            if (isset($_POST["fecha"])) {
                $mes = date('m', strtotime($_POST["fecha"]));
                $year = date('Y', strtotime($_POST["fecha"]));
            } else if (isset($_POST['mes']) && isset($_POST['year'])) {
                $mes = $_POST['mes'];
                $year = $_POST['year'];
            } else {
                $mes = date('m');
                $year = date('Y');
            }

            // Calcular el mes anterior y el siguiente
            $mesAnterior = $mes - 1;
            $yearAnterior = $year;
            if ($mesAnterior < 1) {
                $mesAnterior = 12;
                $yearAnterior--;
            }

            $mesSiguiente = $mes + 1;
            $yearSiguiente = $year;
            if ($mesSiguiente > 12) {
                $mesSiguiente = 1;
                $yearSiguiente++;
            }

            // Calcular el último día del mes
            $ultimoDiaMes = date("t", strtotime($year . "-" . $mes . "-01"));

            // Consultar la disponibilidad de cada día del mes
            $diasDisponibilidad = [];
            for ($i = 1; $i <= $ultimoDiaMes; $i++) {
                $dia = str_pad($i, 2, "0", STR_PAD_LEFT); // Formatear el día con dos dígitos
                $fecha = "$year-$mes-$dia";

                // Determinar el día de la semana (1 = lunes, 7 = domingo)
                $diaSemana = date('N', strtotime($fecha));

                // Establecer el total de horarios según el día de la semana
                if ($diaSemana >= 1 && $diaSemana <= 4) { // Lunes a jueves
                    $totalHorarios = 14; // 8 por la mañana + 6 por la tarde
                } elseif ($diaSemana == 5) { // Viernes
                    $totalHorarios = 8; // Solo por la mañana
                } else { // Sábado y domingo
                    $totalHorarios = 0; // Sin horarios disponibles
                }

                // Consultar la cantidad de reservas y horarios disponibles para este día
                $queryReservas = "SELECT COUNT(*) AS totalReservas FROM Citas WHERE fecha = ?";
                $stmt = $conexion->prepare($queryReservas);
                $stmt->bind_param("s", $fecha);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $totalReservas = $row['totalReservas'];

                if ($totalReservas == 0) {
                    $diasDisponibilidad[$fecha] = 'verde'; // Día completamente disponible
                } elseif ($totalReservas < $totalHorarios) {
                    $diasDisponibilidad[$fecha] = 'amarillo'; // Día parcialmente reservado
                } else {
                    $diasDisponibilidad[$fecha] = 'rojo'; // Día completamente reservado
                }
            }

            // Generar los botones de navegación
            echo '<div class="navegacion-calendario">';
            echo '<form action="" method="post">';
            echo '<button type="submit" class="next-after" name="mes" value="' . $mesAnterior . '">Anterior</button>';
            echo '<input type="hidden" class="next-after" name="year" value="' . $yearAnterior . '">';
            echo '</form>';

            echo '<h3>' . $nombreMeses[(int)$mes] . " " . $year .  '</h3>';

            echo '<form action="" method="post">';
            echo '<button type="submit" class="next-after" name="mes" value="' . $mesSiguiente . '">Siguiente</button>';
            echo '<input type="hidden" class="next-after" name="year" value="' . $yearSiguiente . '">';
            echo '</form>';
            echo '</div>';

            // Generar la tabla del calendario
            $calendario = "<table class='tablaCalendario'><tr><th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th><th>Vie</th><th>Sab</th><th>Dom</th></tr>";
            if (strtotime($year . "-" . $mes . "-01") != 1) {
                $calendario .= "<tr>";
                if (date("w", strtotime($year . "-" . $mes . "-01")) == 0) {
                    for ($i = 1; $i <= 6; $i++) {
                        $calendario .= "<td></td>";
                    }
                } else {
                    for ($i = 1; $i < date("w", strtotime($year . "-" . $mes . "-01")); $i++) {
                        $calendario .= "<td></td>";
                    }
                }
            }

            // Generar los días del mes
            for ($i = 1; $i <= $ultimoDiaMes; $i++) {
                $dia = str_pad($i, 2, "0", STR_PAD_LEFT); // Formatear el día con dos dígitos
                $fecha = "$year-$mes-$dia";
                $diaSemana = date("w", strtotime($fecha));

                if ($diaSemana == 1) {
                    $calendario .= "<tr>";
                }

                $claseDisponibilidad = (strtotime($fecha) < strtotime(date("Y-m-d"))) ? 'calenReDiaNoSeleccionable' : (isset($diasDisponibilidad[$fecha]) ? $diasDisponibilidad[$fecha] : 'verde');

                if ($diaSemana > 0 && $diaSemana < 6 && date("Y-m-d") <= $fecha) {
                    $calendario .= '<td>
                        <form action="" method="post" style="display:inline;">
                            <input type="hidden" name="fecha" value="' . $fecha . '">
                            <button type="submit" class="' . $claseDisponibilidad . '">' . $i . '</button>
                        </form>
                    </td>';
                } else {
                    // Fines de semana o días pasados
                    $calendario .= '<td>
                        <button class="calenReDiaNoSeleccionable" title="No disponible" disabled>' . $i . '</button>
                    </td>';
                }

                if ($diaSemana == 0) {
                    $calendario .= "</tr>";
                }
            }

            if (date("w", strtotime($year . "-" . $mes . "-" . $ultimoDiaMes)) != 0) {
                for ($i = 7; $i > date("w", strtotime($year . "-" . $mes . "-" . $ultimoDiaMes)); $i--) {
                    $calendario .= "<td></td>";
                }
            }

            $calendario .= "</tr></table>";
            echo $calendario;
            ?>
        </div>
    </div>

</body>

</html>