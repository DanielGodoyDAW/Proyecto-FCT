<!DOCTYPE html>
<html lang="es">
<?php set_time_limit(300); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinica de Podologia</title>
    <link rel="stylesheet" href="estilos/styleColores.css">
    <link rel="stylesheet" href="estilos/style.css">
    <link rel="icon" href="imagenes/logo_sin_fondo.ico" type="image/x-icon">
    <script src="./validaciones/recuperarContra/recuperar_contrasena.js"></script>
</head>

<body>
    <?php require_once './plantillas/header.php'; ?>
    <main>
        <!-- Formulario de inicio de sesion -->
        <div class="contenedorLogin" id="login">
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
                <!-- Error si escribimos algun campo erroneo -->
                <?php if (isset($_GET['error'])) { ?>
                    <div id="error-message">Usuario o contraseña incorrectos</div>
                <?php } ?>
                <br>
                <input class="btnIS" type="submit" value="Iniciar Sesión">
            </form>
            <p><a class="decoracion" href="#" onclick="mostrarRecuperar()">¿Olvidaste tu contraseña?</a></p>
        </div>
        <!-- div oculto para el apartado de recuperar contraseña -->
        <div class="contenedorLogin" id="recuperar">
            <h2>Recuperar Contraseña</h2>
            <form action="./validaciones/recuperarContra/procesar_recuperacion.php" method="post">
                <table class="tablaLogin">
                    <tr>
                        <td><label for="email">Introduce tu correo electrónico:</label></td>
                    </tr>
                    <tr>
                        <td><input type="email" id="email" name="email" placeholder="Correo electrónico" required></td>
                    </tr>
                </table>
                <input class="btnPss" type="submit" value="Enviar enlace de recuperación">
            </form>
            <p><a class="decoracion" href="#" onclick="mostrarInicio()">Volver a Inicio</a></p>
        </div>
        <!-- Script para mostrar/ocultar formularios -->
        <?php if (isset($_GET['recuperar'])) {
            echo "<script>mostrarRecuperar();</script>";
        } ?>

    </main>
    <?php require_once './plantillas/footer.php'; ?>
</body>

</html>