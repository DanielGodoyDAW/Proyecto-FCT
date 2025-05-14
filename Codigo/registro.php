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
    <link rel="stylesheet" href="/Codigo/estilos/styleColores.css">
    <title>Registrarse</title>
</head>

<body>
    <?php require_once './plantillas/header.php'; ?>
    <form action="/Codigo/validaciones/validacionRegistro.php" method="post" id="validacionRegistro">
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
                    <td><label for="c1">Nombre: <span class="obligatorio">*</span></label></td>
                    <td>
                        <input type="text" id="c1" name="nombre" placeholder="Nombre" required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="El nombre debe empezar por mayuscula y debe tener entre 3 y 30 caracteres.">
                    </td>
                </tr>
                <tr>
                    <td><label for="c2">Primer apellido: <span class="obligatorio">*</span></label></td>
                    <td>
                        <input type="text" id="c2" name="apellido1" placeholder="Primer apellido" required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="El apellido debe empezar por mayuscula y debe tener entre 3 y 30 caracteres.">
                    </td>
                </tr>
                <tr>
                    <td><label for="c3">Segundo apellido: </label></td>
                    <td>
                        <input type="text" id="c3" name="apellido2" placeholder="Segundo apellido" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="El apellido debe empezar por mayuscula y debe tener entre 3 y 30 caracteres.">
                    </td>
                </tr>
                <tr>
                    <td><label for="c4">Dni: <span class="obligatorio">*</span></label></td>
                    <td>
                        <input type="text" id="c4" name="dni" placeholder="DNI" required pattern="\d{8}[A-Za-z]" title="El DNI debe contener 8 números seguidos de una letra (por ejemplo, 12345678A).">
                    </td>
                </tr>
                <tr>
                    <td><label for="c5">Email: <span class="obligatorio">*</span></label></td>
                    <td>
                        <input type="email" id="c5" name="email" placeholder="Email" required>
                    </td>
                </tr>
                <tr>
                    <td><label for="extension">Prefijo: <span class="obligatorio">*</span></label></td>
                    <td><select id="extension" name="extension" required>
                            <option value="+34" selected>+34 (España)</option>
                            <option value="+1">+1 (EE.UU.)</option>
                            <option value="+44">+44 (Reino Unido)</option>
                            <option value="+66">+66 (Tailandia)</option>
                            <option value="+52">+52 (México)</option>
                            <option value="+57">+57 (Colombia)</option>
                            <option value="+54">+54 (Argentina)</option>
                            <option value="+33">+33 (Francia)</option>
                            <option value="+49">+49 (Alemania)</option>
                            <option value="+39">+39 (Italia)</option>
                            <option value="+81">+81 (Japón)</option>
                            <option value="+82">+82 (Corea del Sur)</option>
                            <option value="+86">+86 (China)</option>
                            <option value="+91">+91 (India)</option>
                            <option value="+7">+7 (Rusia)</option>
                            <option value="+61">+61 (Australia)</option>
                            <option value="+55">+55 (Brasil)</option>
                            <option value="+27">+27 (Sudáfrica)</option>
                            <option value="+47">+47 (Noruega)</option>
                            <option value="+46">+46 (Suecia)</option>
                            <option value="+48">+48 (Polonia)</option>
                            <option value="+90">+90 (Turquía)</option>
                            <option value="+63">+63 (Filipinas)</option>
                            <option value="+64">+64 (Nueva Zelanda)</option>
                            <option value="+20">+20 (Egipto)</option>
                            <option value="+234">+234 (Nigeria)</option>
                            <option value="+62">+62 (Indonesia)</option>
                            <option value="+94">+94 (Sri Lanka)</option>
                            <option value="+98">+98 (Irán)</option>
                            <option value="+31">+31 (Países Bajos)</option>
                            <option value="+41">+41 (Suiza)</option>
                            <option value="+32">+32 (Bélgica)</option>
                            <option value="+351">+351 (Portugal)</option>
                            <option value="+45">+45 (Dinamarca)</option>
                            <option value="+420">+420 (República Checa)</option>
                            <option value="+421">+421 (Eslovaquia)</option>
                            <option value="+36">+36 (Hungría)</option>
                            <option value="+40">+40 (Rumanía)</option>
                            <option value="+56">+56 (Chile)</option>
                            <option value="+58">+58 (Venezuela)</option>
                            <option value="+593">+593 (Ecuador)</option>
                            <option value="+598">+598 (Uruguay)</option>
                            <option value="+505">+505 (Nicaragua)</option>
                            <option value="+506">+506 (Costa Rica)</option>
                            <option value="+507">+507 (Panamá)</option>
                        </select></td>
                </tr>
                <tr>
                    <td><label for="c6">Teléfono: <span class="obligatorio">*</span></label></td>
                    <td>
                        <input type="tel" id="c6" name="telefono" placeholder="Teléfono" required pattern="[0-9\s]+" title="Introduce un número de teléfono válido.">
                    </td>
                </tr>
                <tr>
                    <td><label for="c7">Fecha nacimiento: </label></td>
                    <td>
                        <input type="date" id="c7" name="fecha_nacimiento">
                    </td>
                </tr>
                <tr>
                    <td><label for="c8">Sexo: </label></td>
                    <td>
                        <select id="c8" name="sexo">
                            <option value="" selected>Selecciona una opción</option>
                            <option value="H">Hombre</option>
                            <option value="M">Mujer</option>
                            <option value="O">No Binario</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="c9">Contraseña: <span class="obligatorio">*</span></label></td>
                    <td>
                        <input type="password" id="c9" name="pass" placeholder="Contraseña" required pattern=".{8,}" title="Al menos 8 caracteres, una letra mayuscula, un numero y un caracter especial.">
                        <button type="button" id="mostrar_contrasena" onclick="alternarContrasena('c9')">Mostrar</button>
                    </td>
                </tr>
                <tr>
                    <td><label for="c10">Confirmar Contraseña: <span class="obligatorio">*</span></label></td>
                    <td>
                        <input type="password" id="c10" name="confirmar_pass" placeholder="Confirmar Contraseña" required pattern=".{8,}" title="Al menos 8 caracteres, una letra mayuscula, un numero y un caracter especial.">
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