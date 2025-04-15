<!DOCTYPE html>
<html lang="es">
<?php set_time_limit(300); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinica de Podologia</title>
    <link rel="stylesheet" href="estilos/style.css">
    <link rel="stylesheet" href="/Codigo/estilos/styleCalendario.css">
    <script src="/Codigo/validaciones/recuperarContra/recuperar_contrasena.js"></script>
</head>

<body>
    <?php require_once './plantillas/header.php'; ?>
    <main>
        <div class="contenedorLogin">
            <form class="formularioLogin" action="./validaciones/validacionUsuario.php" id="validacionUsuario" method="post">
                <table class="tablaLogin">
                    <tr>
                        <th>Iniciar Sesión</th>
                    </tr>
                    <tr>
                        <td><input type="text" id="c1" name="paciente" placeholder="Email" minlength="3" maxlength="50" required></td>
                    </tr>
                    <tr>
                        <td><input type="password" id="c2" name="password" placeholder="Contraseña" minlength="8" maxlength="20" required></td>
                    </tr>
                </table>
                <p><a href="#" onclick="nuevaVentana()">¿Olvidaste tu contraseña?</a></p>
                <input class="btnIS" type="submit" value="Iniciar Sesión">
                <?php if (isset($_GET['error'])) : ?>
                    <div id="error-message">Usuario o contraseña incorrectos</div>
                <?php endif; ?>
            </form>
        </div>
    </main>
    <?php require_once './plantillas/footer.php'; ?>
</body>

</html>