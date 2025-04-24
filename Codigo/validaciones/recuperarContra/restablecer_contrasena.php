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
    <style>
        @font-face {
            font-family: 'Amazing Grotesk';
            src: url('/Codigo/fuenteTexto/amazing_grotesk/Amazing Grotesk Book.otf') format('woff2'),
                url('/Codigo/fuenteTexto/amazing_grotesk/Amazing Grotesk Ultra.otf') format('woff');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'Amazing Grotesk', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            background-image: url('/Codigo/imagenes/redimension3_fondo.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .containerRecuperar {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .btnRestablecer {
            background-color: #08A3A9;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            border-radius: 10px;
        }

        .btnRestablecer:hover {
            background-color: #0056b3;
        }
        button{
            background-color: #08A3A9;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            border-radius: 10px;
        }
        button:hover{
            background-color: #0056b3;
        }
    </style>
    <!-- Como no consigo que cargue archivos externo, por los puertos, lo declaro aqui -->
    <script>
        function alternarContrasena(id) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</head>

<body>
    <div class="containerRecuperar">
        <h2>Restablecer Contraseña</h2>
        <form id="formRestablecer" class="formularioRestablecer" action="/Proyecto-FCT/Codigo/validaciones/recuperarContra/guardar_nueva_contra.php" method="post">
            <table>
                <tr>
                    <td><input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>"></td>
                </tr>
                <tr>
                    <td><label for="password">Nueva contraseña:</label></td>
                    <td><input type="password" name="password" id="password" class="inputPassword" required minlength="8"></td>
                    <td><button type="button" onclick="alternarContrasena('password')">Mostrar</button></td>
                </tr>
                <tr>
                    <td><label for="confirm_password">Confirmar contraseña:</label></td>
                    <td><input type="password" name="confirm_password" id="confirm_password" class="inputPassword" required minlength="8"></td>
                    <td><button type="button" onclick="alternarContrasena('confirm_password')">Mostrar</button></td>
                </tr>
                <tr>
                    <td><input class="btnRestablecer" type="submit" value="Restablecer contraseña"></td>
                </tr>
            </table>
        </form>
    </div>
    
</body>

</html>