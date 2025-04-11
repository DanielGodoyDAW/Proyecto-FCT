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
                $diaSemana = date("w", strtotime($year . "-" . $mes . "-" . $dia));

                if ($diaSemana == 1) {
                    $calendario .= "<tr>";
                }

                if ($diaSemana > 0 && $diaSemana < 6) { // Días laborables
                    if (strtotime($year . "-" . $mes . "-" . $dia) < strtotime(date('Y-m-d'))) {
                        $calendario .= '<td class="calenReDiaNoSeleccionable">' . $i . '</td>';
                    } else {
                        $calendario .= '<td class="calenReDiaVacio"><button type="submit" name="fecha" value="' . ($year . "-" . $mes . "-" . $dia) . '">' . $i . '</button></td>';
                    }
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

            // Mostrar el formulario con el calendario
            echo '<form action="validaciones/tramos_horarios.php" method="post">';
            echo $calendario;
            echo '</form>';
            ?>
        </div>
    </div>

</body>

</html>