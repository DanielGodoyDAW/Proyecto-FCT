<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$db = 'clinica_podologia';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// UltraMsg API Config
$env = parse_ini_file('C:/xampp/htdocs/Proyecto-FCT/config.env');
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
    $telefono = preg_replace('/\s+/', '', $cita['telefono']); // Limpiar espacios
    $hora = substr($cita['hora'], 0, 5); // HH:MM

    $mensaje = "Hola {$nombreCompleto}, te recordamos que mañana tienes una cita a las {$hora}h en la Clínica de Podología.";

    $params = array(
        'token' => $token,
        'to' => $telefono,
        'body' => $mensaje
    );

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ultramsg.com/{$instance_id}/messages/chat",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "Error al enviar a {$nombreCompleto} ({$telefono}): $err\n";
    } else {
        echo "Enviado a {$nombreCompleto} ({$telefono}) - Respuesta: {$response}\n";
    }
}


//para ejecutarlo desde la terminal cmd
//C:\xampp\php\php.exe C:\xampp\htdocs\Proyecto-FCT\Codigo\validaciones\recordatorio_WhatsApp\cron_recordatorio.php
