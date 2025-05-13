<?php
require_once __DIR__ . '/../../conexion/conexion.php';

$fechaSeleccionada = $_POST['fecha'] ?? date('Y-m-d');

// Calcular si es viernes
$esViernes = date('N', strtotime($fechaSeleccionada)) == 5;

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
 
// Mostrar formulario
echo '<h3>Horarios disponibles para ' . $fechaFormateada . ':</h3>';
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
echo '<label>Nombre:</label><br><input type="text" name="nombre" required pattern="[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,29}" 
title="Debe comenzar en mayúscula y tener entre 3 y 30 letras" placeholder="Nombre con Mayusculas"><br>';
echo '<label>Apellido 1:</label><br><input type="text" name="apellido1" required pattern="[A-ZÁÉÍÓÚÑ][a-záéíóúñ]{2,29}" 
title="Debe comenzar en mayúscula y tener entre 3 y 30 letras" placeholder="Apellido con Mayusculas"><br>';
echo '<label>Apellido 2:</label><br><input type="text" name="apellido2" pattern="[A-ZÁÉÍÓÚÑa-záéíóúñ]{2,30}" 
title="Debe tener entre 2 y 30 letras (opcional)" placeholder="Apellido con Mayusculas""><br>';
echo '<label>Teléfono:</label><br><input type="text" name="telefono" required pattern="^(\d{9}|\d{3} \d{3} \d{3})$"  
title="Debe contener exactamente 9 dígitos" placeholder="Formato 666 666 666"><br>';
echo '<label>Email:</label><br><input type="email" name="email" title="Debe tener formato usuario@dominio.com" placeholder="usuario@dominio.com"><br>';
echo '<label><input type="checkbox" name="temporal" checked> Usuario temporal</label><br><br>';
echo '<button type="submit">Asignar cita</button>';
echo '</form>';
?>
