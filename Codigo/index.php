<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinica de Podologia</title>
    <link rel="stylesheet" href="estilos/style.css">
</head>

<body>
    <?php require_once './plantillas/header.php'; ?>
    <main>
        <form class="formularioLogin" action="./validaciones/validacionUsuario.php" method="post">
            <?php if (isset($_GET['error'])) : ?>
                <p style="color: red;">Usuario o contraseña incorrectos</p>
            <?php endif; ?>
            <p></p>
            <br>
            <div class="contenedorLogin">
                <table class="tablaLogin">
                    <tr>
                        <th>Iniciar Sesión</th>
                    </tr>
                    <tr>
                        <td><input type="text" id="c1" name="paciente" placeholder="Usuario" required></td>
                    </tr>
                    <tr>
                        <td><input type="password" id="c2" name="password" placeholder="Contraseña" required></td>
                    </tr>
                </table>
                <input class="btnIS" type="submit" value="Iniciár Sesión">
            </div>

        </form>
        <!-- <br>
        <p>¿Aun no tienes una cuenta?</p>
        <a href="./validaciones/registro.php">
            <button type="button">Registrarse</button>
        </a> -->
    </main>
    <?php require_once './plantillas/footer.php'; ?>
</body>

</html>