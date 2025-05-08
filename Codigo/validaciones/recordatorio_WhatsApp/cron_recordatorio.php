<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$db = 'clinica_podologia';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// UltraMsg API Config
$env = parse_ini_file(__DIR__ . '/../../config.env'); 

$instance_id = $env['ULTRAMSG_INSTANCE_ID'];
$token = $env['ULTRAMSG_API_TOKEN'];

// Conexión a base de datos
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (Exception $e) {
    die('Error al conectar a la base de datos: ' . $e->getMessage());
}

// Consulta de citas para mañana
$sql = "
    SELECT 
        P.nombre,
        P.apellido1,
        P.apellido2,
        P.telefono,
        C.hora,
        C.fecha
    FROM 
        Citas C
    JOIN 
        Pacientes P ON C.idPacientes = P.idPacientes
    WHERE 
        C.fecha = CURDATE() + INTERVAL 1 DAY
        AND C.bloqueada = 0
        AND C.confirmada = 1
";

$stmt = $pdo->query($sql);
$citas = $stmt->fetchAll();

foreach ($citas as $cita) {
    $nombreCompleto = $cita['nombre'] . ' ' . $cita['apellido1'];
    if (!empty($cita['apellido2'])) {
        $nombreCompleto .= ' ' . $cita['apellido2'];
    }
    $telefono = preg_replace('/\s+/', '', $cita['telefono']); // Limpiar espacios
    $hora = substr($cita['hora'], 0, 5); // HH:MM

    $mensaje = "Hola {$nombreCompleto}, te recordamos que mañana tienes una cita a las {$hora}h en la Clínica de Podología.";

    // Llamada a la API de UltraMsg
    $url = "https://api.ultramsg.com/{$instance_id}/messages/chat";
    $data = [
        'token' => $token,
        'to' => $telefono,
        'body' => $mensaje
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Log básico
    echo "Enviado a {$nombre} {$apellido} ({$telefono}) - Respuesta: {$response}\n";
}
?>
