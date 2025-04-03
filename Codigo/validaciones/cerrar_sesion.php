<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrar la sesion</title>
</head>
<body>
    <?php
    session_start(); // Iniciar la sesion
    session_unset(); // Limpiar las variables de sesion
    session_destroy(); // Destruir la sesion
    header("Location: ../index.php"); // Redirigir a la pagina principal
    ?>
</body>
</html>