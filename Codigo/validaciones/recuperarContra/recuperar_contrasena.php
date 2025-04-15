<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
</head>
<body>
<main>
        <div class="contenedorRecuperar">
            <form action="procesar_recuperacion.php" method="post">
                <h2>Recuperar Contraseña</h2>
                <label for="email">Introduce tu correo electrónico:</label>
                <input type="email" id="email" name="email" placeholder="Correo electrónico" required>
                <input type="submit" value="Enviar enlace de recuperación">
            </form>
        </div>
    </main>
</body>
</html>