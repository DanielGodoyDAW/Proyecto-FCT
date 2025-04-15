<?php
require_once './conexion/conexion.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verificar si el token es válido y no ha expirado
    $sql = "SELECT * FROM pacientes WHERE token_recuperacion = ? AND token_expira > NOW()";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nueva_contrasena = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Actualizar la contraseña en la base de datos
            $sql = "UPDATE pacientes SET pass = ?, token_recuperacion = NULL, token_expira = NULL WHERE token_recuperacion = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ss", $nueva_contrasena, $token);
            $stmt->execute();

            echo "Tu contraseña ha sido restablecida.";
        }
    } else {
        echo "El enlace de recuperación no es válido o ha expirado.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="estilos/style.css">
</head>

<body>
    <main>
        <div class="contenedorRestablecer">
            <form method="post">
                <h2>Restablecer Contraseña</h2>
                <label for="password">Nueva Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="Nueva contraseña" required>
                <input type="submit" value="Restablecer Contraseña">
            </form>
        </div>
    </main>
</body>

</html>