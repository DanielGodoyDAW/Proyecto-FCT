<?php
require_once __DIR__ . '/../../conexion/conexion.php';
ob_start();

if (!isset($_GET['token']) || empty($_GET['token'])) {
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

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="/Codigo/estilos/styleRecuperarContra.css">
    <link rel="stylesheet" href="/Codigo/estilos/styleCalendario.css">
</head>

<body>
    <div class="containerRecuperar">
        <h2>Restablecer Contraseña</h2>
        <form id="formRestablecer" class="formularioRestablecer" action="/Codigo/validaciones/recuperarContra/guardar_nueva_contra.php" method="post">
            <table>
                <tr>
                    <td><input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>"></td>
                </tr>
                <tr>
                    <td><label for="password">Nueva contraseña:</label></td>
                    <td><input type="password" name="password" id="password" class="inputPassword" required minlength="8"></td>
                </tr>
                <tr>
                    <td><label for="confirm_password">Confirmar contraseña:</label></td>
                    <td><input type="password" name="confirm_password" id="confirm_password" class="inputPassword" required minlength="8"></td>
                </tr>
                <tr>
                    <td><input class="btnRestablecer" type="submit" value="Restablecer contraseña"></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>