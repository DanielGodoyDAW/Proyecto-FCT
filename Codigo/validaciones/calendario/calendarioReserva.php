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
            require_once __DIR__ . '/../../conexion/conexion.php';

            // Determinar el mes y el año seleccionados
            if (isset($_POST['mes']) && isset($_POST['year'])) {
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

                // Consultar la cantidad de reservas y horarios disponibles para este día
                $queryReservas = "SELECT COUNT(*) AS totalReservas FROM Citas WHERE fecha = ?";
                $stmt = $conexion->prepare($queryReservas);
                $stmt->bind_param("s", $fecha);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $totalReservas = $row['totalReservas'];

                // Total de horarios posibles (mañana + tarde)
                $totalHorarios = 16; // 8 horarios por la mañana + 8 por la tarde

                if ($totalReservas == 0) {
                    $diasDisponibilidad[$fecha] = 'verde'; // Día completamente disponible
                } elseif ($totalReservas < $totalHorarios) {
                    $diasDisponibilidad[$fecha] = 'amarillo'; // Día parcialmente reservado
                } else {
                    $diasDisponibilidad[$fecha] = 'rojo'; // Día completamente reservado
                }
            }

            // Generar los botones de navegación
            echo '<form action="" method="post">';
            echo '<button type="submit" name="mes" value="' . $mesAnterior . '">Anterior</button>';
            echo '<input type="hidden" name="year" value="' . $yearAnterior . '">';
            echo '</form>';

            echo '<h3>' . date("F Y", strtotime($year . "-" . $mes . "-01")) . '</h3>';

            echo '<form action="" method="post">';
            echo '<button type="submit" name="mes" value="' . $mesSiguiente . '">Siguiente</button>';
            echo '<input type="hidden" name="year" value="' . $yearSiguiente . '">';
            echo '</form>';

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

                // Determinar la clase CSS según la disponibilidad
                $claseDisponibilidad = isset($diasDisponibilidad[$fecha]) ? $diasDisponibilidad[$fecha] : 'verde';

                if ($diaSemana > 0 && $diaSemana < 6) { // Días laborables
                    $calendario .= '<td>
                        <form action="" method="post" style="display:inline;">
                            <input type="hidden" name="fecha" value="' . $fecha . '">
                            <button type="submit" class="' . $claseDisponibilidad . '">' . $i . '</button>
                        </form>
                    </td>';
                } else { // Fines de semana
                    $calendario .= '<td class="calenReDiaNoSeleccionable">' . $i . '</td>';
                }

                if ($diaSemana == 0) {
                    $calendario .= "</tr>";
                }
            }

            // Completar la última fila del calendario
            if (date("w", strtotime($year . "-" . $mes . "-" . $ultimoDiaMes)) != 0) {
                for ($i = 7; $i > date("w", strtotime($year . "-" . $mes . "-" . $ultimoDiaMes)); $i--) {
                    $calendario .= "<td></td>";
                }
            }

            $calendario .= "</tr></table>";

            // Mostrar el calendario
            echo $calendario;
            ?>
        </div>
    </div>

</body>

</html>