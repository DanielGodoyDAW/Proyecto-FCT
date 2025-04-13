<!DOCTYPE html>
<html lang="es">
<?php set_time_limit(300); ?> <!-- esto esta puesto por fallo con el xampp -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinica de Podologia</title>
    <link rel="stylesheet" href="estilos/style.css">
    <!-- <script src="/Codigo/js/validacionUsuario.js"></script> para probar la validacion -->
</head>

<body>
    <?php require_once './plantillas/header.php'; ?>
    <main>
        <form class="formularioLogin" action="./validaciones/validacionUsuario.php" id="validacionUsuario" method="post">
            <?php if (isset($_GET['error'])) : ?>
                <div style="text-align: center; margin-top: 10px;">
                    <p style="color: red;">Usuario o contraseña incorrectos</p>
                </div>
            <?php endif; ?>
            <br>
            <div class="contenedorLogin">
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
                <input class="btnIS" type="submit" value="Iniciár Sesión">
            </div>
        </form>
        <div id="error-message"></div>
    </main>
    <?php require_once './plantillas/footer.php'; ?>
</body>

</html>