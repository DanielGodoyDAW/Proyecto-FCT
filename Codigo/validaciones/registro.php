<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/script.js"></script>
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
        <label for="c1">Nombre</label>
        <input type="text" id="c1" name="nombre" placeholder="Nombre" pattern="[A-Z][A-Za-z]{2,9}"
            title="El nombre debe tener entre 3 y 10 caracteres, el primero con mayúscula." required><br>
        <label for="c2">Primer apellido</label>
        <input type="text" id="c2" name="apellido1" placeholder="Primer apellido" pattern="[A-Za-z]{4,8}"
            title="El primer apellido debe tener entre 4 y 8 caracteres, el primero con mayúscula." required><br>
        <label for="c3">Segundo apellido</label>
        <input type="text" id="c3" name="apellido2" placeholder="Segundo apellido" pattern="[A-Za-z]{4,8}"
            title="El segundo apellido debe tener entre 4 y 8 caracteres, el primero con mayúscula."><br>
        <label for="c4">Dni</label>
        <input type="text" id="c4" name="dni" placeholder="DNI" required><br>
        <label for="c5">Email</label>
        <input type="email" id="c5" name="email" placeholder="Email" pattern="[A-Za-z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}"
            title="El email no es valido" required><br>
        <label for="c6">Teléfono</label>
        <input type="tel" id="c6" name="telefono" placeholder="Teléfono" pattern="\+\d{2} \d{3}-\d{3}-\d{3}"
            title="El telefono debe empezar en +99 y tener este formato +99 999-999-999" required><br>
        <label for="c7">Fecha nacimiento</label>
        <input type="date" id="c7" name="fecha_nacimiento" required><br>
        <label for="c8">Sexo</label>
        <select id="c8" name="sexo" required>
            <option value="Hombre">Hombre</option>
            <option value="Mujer">Mujer</option>
            <option value="Otro">Otro</option>
        </select><br>
    </form>
    <div id="error"></div>
    <br>
    <button type="submit" name="enviar">Registrarse</button>
    <?php require_once '../plantillas/footer.php'; ?>
</body>

</html>