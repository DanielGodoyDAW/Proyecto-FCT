<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if (!isset($_GET['token'])) {
    echo "Token no proporcionado.";
    exit;
}

$token = $_GET['token'];

$sql = "SELECT * FROM pacientes WHERE token_recuperacion = ? AND token_expira > NOW()";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Token inválido o expirado.";
    exit;
}

$usuario = $result->fetch_assoc();
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
        <form action="guardar_nueva_contra.php" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <label for="password">Nueva contraseña:</label>
            <input type="password" name="password" id="password" required minlength="8"><br>
            <label for="confirm_password">Confirmar contraseña:</label>
            <input type="password" name="confirm_password" id="confirm_password" required minlength="8"><br>
            <input class="btnPss" type="submit" value="Restablecer contraseña">
        </form>
    </div>
</body>
</html>
