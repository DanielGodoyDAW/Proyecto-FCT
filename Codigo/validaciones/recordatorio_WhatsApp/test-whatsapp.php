<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$db = 'clinica_podologia';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Token y Phone Number ID de WhatsApp Cloud API
$token = 'EAAKCUJWU1QwBOzJKZCBtF6QxSQy0yNvZAZCZBxbQ7xPRQkeknnsZClcUAPPuOscHNIFmwcbyIceygVspnhH3agBQcWimFZBkcmd5Kd6Jc3EqvYGP7qkzvGRn3GC6kSy7l9Fe1Sq8djZBw1IDeCSjCGnuWdlbhWxuCqlSzI3JXPjvzbJKutJtDKnjLghQC1CoficOWhZAmAsBowVgBF4ZD';
$phone_number_id = '698783146645157';

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
        C.fecha >= DATE(NOW() + INTERVAL 1 DAY) AND 
        C.fecha < DATE(NOW() + INTERVAL 2 DAY) AND
        C.bloqueada = 0
";

$stmt = $pdo->query($sql);
$citas = $stmt->fetchAll();

foreach ($citas as $cita) {
    $nombreCompleto = $cita['nombre'] . ' ' . $cita['apellido1'];
    if (!empty($cita['apellido2'])) {
        $nombreCompleto .= ' ' . $cita['apellido2'];
    }

    // Limpiar teléfono (asegúrate de que ya incluya el prefijo, como 34)
    $telefono = preg_replace('/\D+/', '', $cita['telefono']); // Limpiar espacios y caracteres no numéricos
    $hora = substr($cita['hora'], 0, 5); // HH:MM

    $mensaje = "Hola {$nombreCompleto}, te recordamos que mañana tienes una cita a las {$hora}h en la Clínica de Podología.";

    $data = [
        'messaging_product' => 'whatsapp',
        'to' => $telefono,
        'type' => 'text',
        'text' => ['body' => $mensaje]
    ];

    $ch = curl_init("https://graph.facebook.com/v19.0/{$phone_number_id}/messages");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        echo "❌ Error al enviar a {$nombreCompleto} ({$telefono}): $err\n";
    } else {
        echo "✅ Enviado a {$nombreCompleto} ({$telefono}) - Respuesta: {$response}\n";
    }
}

//ejecucion desde cmd
//C:\xampp\php\php.exe C:\xampp\htdocs\Proyecto-FCT\Codigo\validaciones\recordatorio_WhatsApp\test-whatsapp.php