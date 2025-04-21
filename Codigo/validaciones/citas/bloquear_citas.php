<?php

$horariosManana = [
    "09:00:00",
    "09:30:00",
    "10:00:00",
    "10:30:00",
    "11:00:00",
    "11:30:00",
    "12:00:00",
    "12:30:00"
];

$horariosTarde = [
    "16:00:00",
    "16:30:00",
    "17:00:00",
    "17:30:00",
    "18:00:00",
    "18:30:00",
    "19:00:00"
];

// Determinar el día de la semana (1 = lunes, 7 = domingo)
$diaSemana = date('N', strtotime($fechaSeleccionada));

if (isset($_POST['bloquear']) && isset($_POST['bloquear_citas'])) {
    foreach ($_POST['bloquear_citas'] as $hora) {
        // Verificar si ya existe cita bloqueada
        $check = $conexion->prepare("SELECT * FROM Citas WHERE fecha = ? AND hora = ? AND bloqueada = 1");
        $check->bind_param("ss", $fechaSeleccionada, $hora);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows == 0) {
            $stmt = $conexion->prepare("INSERT INTO Citas (fecha, hora, estado, bloqueada, idAdmin) VALUES (?, ?, 'Bloqueada', 1, ?)");
            $stmt->bind_param("ssi", $fechaSeleccionada, $hora, $_SESSION['idAdmin']);
            $stmt->execute();
        }
    }
}
// Obtener todas las citas bloqueadas de la fecha
$query = $conexion->prepare("SELECT hora FROM Citas WHERE fecha = ? AND bloqueada = 1 AND idPacientes IS NULL");
$query->bind_param("s", $fechaSeleccionada);
$query->execute();
$result = $query->get_result();

$bloqueadas = [];
while ($row = $result->fetch_assoc()) {
    $bloqueadas[] = $row['hora'];
}
?>
<link rel="stylesheet" href="/Codigo/estilos/styleAdmin.css">
<h3>Bloquear nuevas citas</h3>
<div class="bloquear-container">
    <form method="POST">
        <input type="hidden" name="fecha" value="<?php echo $fechaSeleccionada; ?>">

        <?php if ($diaSemana >= 1 && $diaSemana <= 4) { ?>
            <h4>Mañana</h4>
            <?php foreach ($horariosManana as $hora) { ?>
                <?php if (!in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="bloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php echo date("H:i", strtotime($hora)); ?> - <?php echo date("H:i", strtotime($hora) + 30 * 60); ?>
                    </label><br>
                <?php } ?>
            <?php } ?>

            <h4>Tarde</h4>
            <?php foreach ($horariosTarde as $hora) { ?>
                <?php 
                // Si la hora es 19:00, no generes el checkbox
                if ($hora === "19:00:00") {
                    continue;
                }
                ?>

                <?php if (!in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="bloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php
                        // Si la hora es 18:30, imprime hasta 19:00
                        if ($hora === "18:30:00") {
                            echo date("H:i", strtotime($hora)) . " - " . date("H:i", strtotime("19:00:00"));
                        } else {
                            // Para las demás horas, suma 30 minutos
                            echo date("H:i", strtotime($hora)) . " - " . date("H:i", strtotime($hora) + 30 * 60);
                        }
                        ?>
                    </label><br>
                <?php } ?>
                <?php if (in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="desbloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php
                        // Si la hora es 19:00, no imprimas nada
                        if ($hora === "19:00:00") {
                            continue;
                        }

                        // Si la hora es 18:30, imprime hasta 19:00
                        if ($hora === "18:30:00") {
                            echo date("H:i", strtotime($hora)) . " - " . date("H:i", strtotime("19:00:00"));
                        } else {
                            // Para las demas horas, sumamos 30 minutos
                            echo date("H:i", strtotime($hora)) . " - " . date("H:i", strtotime($hora) + 30 * 60);
                        }
                        ?>
                        (Bloqueada)
                    </label><br>
                <?php } ?>
            <?php } ?>
        <?php } elseif ($diaSemana == 5) { ?>
            <h4>Mañana</h4>
            <?php foreach ($horariosManana as $hora) { ?>
                <?php if (!in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="bloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php echo date("H:i", strtotime($hora)); ?> - <?php echo date("H:i", strtotime($hora) + 30 * 60); ?>
                    </label><br>
                <?php } ?>
            <?php } ?>
        <?php } ?>

        <br>
        <button type="submit" name="bloquear">Bloquear seleccionadas</button>
    </form>
</div>