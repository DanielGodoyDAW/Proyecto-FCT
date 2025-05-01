<?php
require_once __DIR__ . '/../../conexion/conexion.php';

$fechaSeleccionada = $_POST['fecha'] ?? date('Y-m-d');

// Tramos horarios (mañana)
$tramos = [
    "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30",
];

// Si NO es viernes, agregar tambien la tarde
if (!$esViernes) {
    $tramos = array_merge($tramos, [
        "16:00", "16:30", "17:00", "17:30", "18:00", "18:30"
    ]);
}

//consulta para ver si ya hay citas en esa fecha
$stmt = $conexion->prepare("SELECT hora FROM Citas WHERE fecha = ?");
$stmt->bind_param("s", $fechaSeleccionada);
$stmt->execute();
$res = $stmt->get_result();

$reservadas = [];
while ($row = $res->fetch_assoc()) { 
    $reservadas[] = $row['hora'];
}

// Mostrar formulario
echo '<h3>Horarios disponibles para ' . $fechaSeleccionada . ':</h3>';
echo '<form method="POST" action="/Codigo/validaciones/citas/crear_cita_admin.php">';
echo '<input type="hidden" name="fecha" value="' . $fechaSeleccionada . '">';

foreach ($tramos as $hora) {
    $horaCompleta = $hora . ':00';
    if (!in_array($horaCompleta, $reservadas)) {
        echo '<label><input type="radio" name="hora" value="' . $hora . '" required> ' . $hora . '</label><br>';
    }
}
echo '<hr>';

// Formulario paciente
echo '<h4>Datos del paciente:</h4>';
echo '<label>Nombre:</label><br><input type="text" name="nombre" required><br>';
echo '<label>Apellido 1:</label><br><input type="text" name="apellido1" required><br>';
echo '<label>Apellido 2:</label><br><input type="text" name="apellido2"><br>';
echo '<label>Teléfono:</label><br><input type="text" name="telefono" required><br>';
echo '<label>Email:</label><br><input type="email" name="email"><br>';
echo '<label><input type="checkbox" name="temporal" checked> Usuario temporal</label><br><br>';
echo '<button type="submit">Asignar cita</button>';
echo '</form>';
?>
