<?php
require_once __DIR__ . '/../../conexion/conexion.php';

//declaramos los tramos de horarios
$horariosManana = [
    "09:00:00", "09:30:00", "10:00:00", "10:30:00",
    "11:00:00", "11:30:00", "12:00:00", "12:30:00"
];

$horariosTarde = [
    "16:00:00", "16:30:00", "17:00:00",
    "17:30:00", "18:00:00", "18:30:00", "19:00:00"
];

$fechaSeleccionada = $_POST['fecha'] ?? null;
$diaSemana = date('N', strtotime($fechaSeleccionada));

if (isset($_POST['bloquear']) && isset($_POST['bloquear_citas'])) { 
    foreach ($_POST['bloquear_citas'] as $hora) { //para cada hora seleccionada
        $check = $conexion->prepare("SELECT idCita FROM Citas WHERE fecha = ? AND hora = ? AND bloqueada = 1"); //consulta para ver si ya existe una cita bloqueada
        $check->bind_param("ss", $fechaSeleccionada, $hora);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows == 0) { //si no existe la cita bloqueada
            $stmt = $conexion->prepare("INSERT INTO Citas (fecha, hora, estado, bloqueada, idAdmin) VALUES (?, ?, 'Bloqueada', 1, ?)"); //insertamos la cita bloqueada
            $stmt->bind_param("ssi", $fechaSeleccionada, $hora, $_SESSION['idAdmin']);
            $stmt->execute();
        }
    }

    echo '<script>window.location.href = "/Codigo/citas.php?seccionActiva=bloquearDEsbloCitas";</script>';
    exit;
}

// Obtener horas bloqueadas
$query = $conexion->prepare("SELECT hora FROM Citas WHERE fecha = ? AND bloqueada = 1 AND idPacientes IS NULL");
$query->bind_param("s", $fechaSeleccionada);
$query->execute();
$result = $query->get_result();

$bloqueadas = [];
while ($row = $result->fetch_assoc()) {
    $bloqueadas[] = $row['hora'];
}
?>

<link rel="stylesheet" href="/Codigo/estilos/styleColores.css">
<link rel="stylesheet" href="/Codigo/estilos/styleAdmin.css">
<h3>Bloquear Agenda</h3>
<div class="bloquear-container">
    <form method="POST">
        <input type="hidden" name="fecha" value="<?php echo htmlspecialchars($fechaSeleccionada); ?>">

        <?php if ($diaSemana >= 1 && $diaSemana <= 4) { ?> <!-- Lunes a Jueves -->
            <h4>Mañana</h4>
            <?php foreach ($horariosManana as $hora) { ?>
                <?php if (!in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="bloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php echo date("H:i", strtotime($hora)) . " - " . date("H:i", strtotime($hora) + 1800); ?>
                    </label><br>
                <?php } ?>
            <?php } ?>

            <h4>Tarde</h4> 
            <?php foreach ($horariosTarde as $hora) { ?> 
                <?php if ($hora === "19:00:00") continue; ?> <!-- Excluir 19:00:00 -->
                <?php if (!in_array($hora, $bloqueadas)) { ?> <!-- Si la hora no está bloqueada -->
                    <label>
                        <input type="checkbox" name="bloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php
                        if ($hora === "18:30:00") {
                            echo date("H:i", strtotime($hora)) . " - " . date("H:i", strtotime("19:00:00"));
                        } else {
                            echo date("H:i", strtotime($hora)) . " - " . date("H:i", strtotime($hora) + 1800);
                        }
                        ?>
                    </label><br>
                <?php } ?>
            <?php } ?>
        <?php } elseif ($diaSemana == 5) { ?> <!-- Viernes -->
            <h4>Mañana</h4>
            <?php foreach ($horariosManana as $hora) { ?>
                <?php if (!in_array($hora, $bloqueadas)) { ?>
                    <label>
                        <input type="checkbox" name="bloquear_citas[]" value="<?php echo $hora; ?>">
                        <?php echo date("H:i", strtotime($hora)) . " - " . date("H:i", strtotime($hora) + 1800); ?>
                    </label><br>
                <?php } ?>
            <?php } ?>
        <?php } ?>

        <br>
        <button type="submit" name="bloquear">Bloquear seleccionadas</button>
    </form>
</div>
