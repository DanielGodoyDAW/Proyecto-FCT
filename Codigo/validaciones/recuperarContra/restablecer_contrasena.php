<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if (!isset($_GET['token'])) {
    echo "Token no proporcionado.";
    exit;
}

$token = $_GET['token'];

$sql = "SELECT email FROM pacientes WHERE token_recuperacion = ? AND token_expira > NOW()";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "El enlace de recuperación no es válido o ha expirado.";
    exit;
}

$email = $result->fetch_assoc()['email'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="/Codigo/estilos/styleRecuperarContra.css">
</head>
<body>
    <div class="containerRecuperar">
        <h2>Restablecer Contraseña</h2>
        <form action="guardar_nueva_contrasena.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <label for="password">Nueva Contraseña:</label>
            <input type="password" name="password" required minlength="8">
            <br>
            <input type="submit" value="Guardar nueva contraseña">
        </form>
    </div>
</body>
</html>
