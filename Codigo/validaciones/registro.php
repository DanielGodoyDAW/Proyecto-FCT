<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/registro.js"></script>
    <link rel="stylesheet" href="/Codigo/estilos/stylesRegistro.css">
    <title>Registrarse</title>
    <style>
        input:invalid {
            border: 2px solid red;
        }

        input:valid {
            border: 2px solid green;
        }
    </style>
</head>

<body>
    <?php require_once '../plantillas/header.php'; ?>
    <form action="./validaciones/validacionRegistro.php" method="post" id="validacionRegistro" novalidate>
        <div class="contenedorRegistro">
            <p>Por favor, rellena el siguiente formulario para registrarte.</p>
            <table class="tablaRegistro">
                <tr>
                    <td><label for="c1">Nombre</label></td>
                    <td>
                        <input type="text" id="c1" name="nombre" placeholder="Nombre" pattern="[A-Z][A-Za-z]{2,9}"
                            title="El nombre debe tener entre 3 y 10 caracteres, el primero con mayúscula." required>
                    </td>
                </tr>
                <tr>
                    <td><label for="c2">Primer apellido</label></td>
                    <td>
                        <input type="text" id="c2" name="apellido1" placeholder="Primer apellido" pattern="[A-Za-z]{4,8}"
                            title="El primer apellido debe tener entre 4 y 8 caracteres, el primero con mayúscula." required>
                    </td>
                </tr>
                <tr>
                    <td><label for="c3">Segundo apellido</label></td>
                    <td>
                        <input type="text" id="c3" name="apellido2" placeholder="Segundo apellido" pattern="[A-Za-z]{4,8}"
                            title="El segundo apellido debe tener entre 4 y 8 caracteres, el primero con mayúscula.">
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
                        <input type="email" id="c5" name="email" placeholder="Email" pattern="[A-Za-z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,4}"
                            title="El email no es valido" required>
                    </td>
                </tr>
                <tr>
                    <td><label for="c6">Teléfono</label></td>
                    <td>
                        <input type="tel" id="c6" name="telefono" placeholder="Teléfono" pattern="\+\d{2} \d{3} \d{3} \d{3}"
                            title="El telefono debe empezar en +99 y tener este formato +99 999 999 999" required>
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
                    <td><input type="password" id="c9" name="pass" minlength="8" placeholder="Contraseña" required></td>
                </tr>
                <tr>
                    <td><label for="c10">Confirmar Contraseña:</label></td>
                    <td><input type="password" id="c10" name="confirmar_pass" minlength="8" placeholder="Confirmar Contraseña" required></td>
                </tr>
            </table>
            <button class="btnRegis" type="submit" name="enviar">Registrarse</button>
        </div>   
    </form>
    <div id="error"></div>
    <?php require_once '../plantillas/footer.php'; ?>
</body>

</html>