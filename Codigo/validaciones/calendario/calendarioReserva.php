<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Codigo/estilos/styleColores.css">
    <link rel="stylesheet" href="/Codigo/estilos/styleCalendario.css">
    <title>Calendario de Reserva</title>
</head>

<body>

    <div id="calendar-container">
        <div id="calendar-scroll">
            <?php

            require_once __DIR__ . '/../../conexion/conexion.php';

            //array con los nombres de los meses
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

            $ultimoDiaMes = date("t", strtotime("$year-$mes-01"));

            $diasDisponibilidad = [];
            for ($i = 1; $i <= $ultimoDiaMes; $i++) {
                $dia = str_pad($i, 2, "0", STR_PAD_LEFT);
                $fecha = "$year-$mes-$dia";

                $diaSemana = date('N', strtotime($fecha));

                if ($diaSemana >= 1 && $diaSemana <= 4) {
                    $totalHorarios = 14;
                } elseif ($diaSemana == 5) {
                    $totalHorarios = 8;
                } else {
                    $totalHorarios = 0;
                }

                //consulta para ver si ya hay citas en esa fecha
                $queryReservas = "SELECT COUNT(*) AS totalReservas FROM Citas WHERE fecha = ?";
                $stmt = $conexion->prepare($queryReservas);
                $stmt->bind_param("s", $fecha);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $totalReservas = $row['totalReservas'];

                if ($totalReservas == 0) {
                    $diasDisponibilidad[$fecha] = 'verde';
                } elseif ($totalReservas < $totalHorarios) {
                    $diasDisponibilidad[$fecha] = 'amarillo';
                } else {
                    $diasDisponibilidad[$fecha] = 'rojo';
                }
            }

            // Navegacion meses
            echo '<div class="navegacion-calendario">';
            echo '<form action="" method="post">';
            echo '<button type="submit" class="next-after" name="mes" value="' . $mesAnterior . '">Anterior</button>';
            echo '<input type="hidden" name="year" value="' . $yearAnterior . '">';
            echo '</form>';

            echo '<h3>' . $nombreMeses[(int)$mes] . ' ' . $year . '</h3>';

            echo '<form action="" method="post">';
            echo '<button type="submit" class="next-after" name="mes" value="' . $mesSiguiente . '">Siguiente</button>';
            echo '<input type="hidden" name="year" value="' . $yearSiguiente . '">';
            echo '</form>';
            echo '</div>';

            // Calendario
            $calendario = "<table class='tablaCalendario'><tr><th>Lun</th><th>Mar</th><th>Mie</th><th>Jue</th><th>Vie</th><th>Sab</th><th>Dom</th></tr>";
            if (strtotime("$year-$mes-01") != 1) {
                $calendario .= "<tr>";
                if (date("w", strtotime("$year-$mes-01")) == 0) {
                    for ($i = 1; $i <= 6; $i++) $calendario .= "<td></td>";
                } else {
                    for ($i = 1; $i < date("w", strtotime("$year-$mes-01")); $i++) $calendario .= "<td></td>";
                }
            }

            for ($i = 1; $i <= $ultimoDiaMes; $i++) {
                $dia = str_pad($i, 2, "0", STR_PAD_LEFT);
                $fecha = "$year-$mes-$dia";
                $diaSemana = date("w", strtotime($fecha));

                if ($diaSemana == 1) $calendario .= "<tr>";

                $claseDisponibilidad = (strtotime($fecha) < strtotime(date("Y-m-d"))) ? 'calenReDiaNoSeleccionable' : ($diasDisponibilidad[$fecha] ?? 'verde');

                if ($diaSemana > 0 && $diaSemana < 6 && date("Y-m-d") <= $fecha) {
                    $calendario .= '<td>
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="fecha" value="' . $fecha . '">
                        <button type="submit" class="' . $claseDisponibilidad . '">' . $i . '</button>
                    </form>
                </td>';
                } else {
                    $calendario .= '<td>
                    <button class="calenReDiaNoSeleccionable" title="No disponible" disabled>' . $i . '</button>
                </td>';
                }

                if ($diaSemana == 0) $calendario .= "</tr>";
            }

            if (date("w", strtotime("$year-$mes-$ultimoDiaMes")) != 0) {
                for ($i = 7; $i > date("w", strtotime("$year-$mes-$ultimoDiaMes")); $i--) $calendario .= "<td></td>";
            }

            $calendario .= "</tr></table>";
            echo $calendario;
            ?>
        </div>
    </div>

</body>

</html>