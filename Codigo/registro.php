<!DOCTYPE html>
<html lang="es">
<?php
$registro = $_SESSION['registro'] ?? [];
$errores = $_SESSION['errores'] ?? [];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/Codigo/js/registro.js"></script>
    <link rel="stylesheet" href="/Codigo/estilos/stylesRegistro.css">
    <link rel="stylesheet" href="/Codigo/estilos/styleCalendario.css">
    <title>Registrarse</title>
</head>

<body>
    <?php require_once './plantillas/header.php'; ?>
    <form action="/Codigo/validaciones/validacionRegistro.php" method="post" id="validacionRegistro" novalidate>
        <div class="contenedorRegistro">
            <?php if (!empty($errores)) { ?>
                <div id="error">
                    <?php foreach ($errores as $error) { ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php } ?>
                </div>
                <?php unset($_SESSION['errores']); ?>
            <?php } ?>
            <table class="tablaRegistro">
                <tr>
                    <td><label for="c1">Nombre</label></td>
                    <td>
                        <input type="text" id="c1" name="nombre" placeholder="Nombre" required>
                    </td>
                </tr>
                <tr>
                    <td><label for="c2">Primer apellido</label></td>
                    <td>
                        <input type="text" id="c2" name="apellido1" placeholder="Primer apellido" required>
                    </td>
                </tr>
                <tr>
                    <td><label for="c3">Segundo apellido</label></td>
                    <td>
                        <input type="text" id="c3" name="apellido2" placeholder="Segundo apellido">
                    </td>
                </tr>
                <tr>
                    <td><label for="c4">Dni</label></td>
                    <td>
                        <input type="text" id="c4" name="dni" placeholder="DNI" required>
                    </td>
                </tr>
                <tr>
                    <td><label for="c5">Email</label></td>
                    <td>
                        <input type="email" id="c5" name="email" placeholder="Email" required>
                    </td>
                </tr>
                <tr>
                    <td><label for="c6">Teléfono</label></td>
                    <td>
                        <input type="tel" id="c6" name="telefono" placeholder="Teléfono" required>
                    </td>
                </tr>
                <tr>
                    <td><label for="c7">Fecha nacimiento</label></td>
                    <td>
                        <input type="date" id="c7" name="fecha_nacimiento" required>
                    </td>
                </tr>
                <tr>
                    <td><label for="c8">Sexo</label></td>
                    <td>
                        <select id="c8" name="sexo" required>
                            <option value="Hombre">Hombre</option>
                            <option value="Mujer">Mujer</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="c9">Contraseña:</label></td>
                    <td>
                        <input type="password" id="c9" name="pass" placeholder="Contraseña" required>
                        <button type="button" id="mostrar_contrasena" onclick="alternarContrasena('c9')">Mostrar</button>
                    </td>
                </tr>
                <tr>
                    <td><label for="c10">Confirmar Contraseña:</label></td>
                    <td>
                        <input type="password" id="c10" name="confirmar_pass" placeholder="Confirmar Contraseña" required>
                        <button type="button" id="mostrar_confirmar_contrasena" onclick="alternarContrasena('c10')">Mostrar</button>
                    </td>
                </tr>
            </table>
            <button class="btnRegis" type="submit" name="enviar">Registrarse</button>
        </div>
    </form>
    <?php require_once './plantillas/footer.php'; ?>
</body>

</html>