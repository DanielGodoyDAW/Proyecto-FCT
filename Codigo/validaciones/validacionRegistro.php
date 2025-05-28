<?php

require_once __DIR__ . '/../conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errores = [];

    // Validar DNI
    if (empty($_POST['dni'])) {
        $errores[] = "El DNI es obligatorio.";
    } else {
        // Consulta a la base de datos para verificar si el DNI ya está registrado
        $dni = mysqli_real_escape_string($conexion, $_POST['dni']);
        $sql = "SELECT * FROM pacientes WHERE dni = '$dni'";
        $resultado = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($resultado) > 0) {
            $errores[] = "El DNI ya está registrado.";
        }
    }

    // Validar nombre
    if (!preg_match('/^[A-ZÁÉÍÓÚÑ][A-Za-zÁÉÍÓÚáéíóúñ\s]{2,29}$/', $_POST['nombre'])) {
        $errores[] = "El nombre debe tener entre 3 y 30 caracteres, comenzando con mayúscula.";
    }

    // Validar primer apellido
    if (!preg_match('/^[A-ZÁÉÍÓÚÑ][A-Za-zÁÉÍÓÚáéíóúñ\s]{2,29}$/', $_POST['apellido1'])) {
        $errores[] = "El primer apellido debe tener entre 3 y 30 caracteres, comenzando con mayúscula.";
    }

    // Validar segundo apellido (opcional)
    if (!empty($_POST['apellido2']) && !preg_match('/^[A-ZÁÉÍÓÚÑ][A-Za-zÁÉÍÓÚáéíóúñ\s]{2,29}$/', $_POST['apellido2'])) {
        $errores[] = "El segundo apellido debe tener entre 3 y 30 caracteres, comenzando con mayúscula.";
    }

    // Validar email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    } else {
        // Consulta a la base de datos para verificar si el email ya esta registrado
        $email = mysqli_real_escape_string($conexion, $_POST['email']);
        $sqlEmail = "SELECT * FROM pacientes WHERE email = '$email'";
        $resultadoEmail = mysqli_query($conexion, $sqlEmail);
        if (mysqli_num_rows($resultadoEmail) > 0) {
            $errores[] = "El email ya está registrado.";
        }
    }

    // Validar teléfono
    if (!preg_match('/^[0-9\s]+$/', $_POST['telefono'])) {
        $errores[] = "El número de teléfono no es válido.";
    }

    if (empty($_POST['extension']) || !preg_match('/^\+\d{1,3}$/', $_POST['extension'])) {
        $errores[] = "Por favor, selecciona una extensión válida.";
    }

    $extension = trim($_POST['extension'] ?? '');
    $telefono = preg_replace('/\s+/', '', $_POST['telefono'] ?? ''); // Elimina espacios
    $telefonoCompleto = $extension . ' ' . $telefono;

    if (strlen($telefonoCompleto) > 15) {
        $errores[] = "El número de teléfono completo no puede exceder los 15 caracteres.";
    }

    // Validar fecha de nacimiento
    if (isset($_POST['fecha_nacimiento']) && !empty($_POST['fecha_nacimiento'])) {
        try {
            $fecha_nacimiento = new DateTime($_POST['fecha_nacimiento']);
            $fecha_actual = new DateTime();
            $fecha_minima = (new DateTime())->modify('-13 years'); // Fecha minima para mayores de 13 años

            if ($fecha_nacimiento >= $fecha_actual) {
                $errores[] = "La fecha de nacimiento no puede ser la actual, ni una fecha futura.";
            } elseif ($fecha_nacimiento > $fecha_minima) {
                $errores[] = "Debes tener al menos 13 años para registrarte.";
            }
        } catch (Exception $e) {
            $errores[] = "La fecha de nacimiento no tiene un formato válido.";
        }
    }

    // Validar sexo
    $sexo = $_POST['sexo'] ?? 'O'; // Por defecto, asignar 'O' (Otro)
    if ($sexo === 'Seleccione una opción' || !in_array($sexo, ['H', 'M', 'O'])) {
        $sexo = 'O'; // Si no selecciona un valor válido, asignar 'O'
    }

    // Validar contraseña
    if (empty($_POST['pass']) || strlen($_POST['pass']) < 8) {
        $errores[] = "Al menos 8 caracteres, una letra mayuscula, un numero y un caracter especial.";
    } elseif ($_POST['pass'] !== $_POST['confirmar_pass']) {
        $errores[] = "Las contraseñas no coinciden.";
    }

    // Mostrar errores o procesar datos
    if (!empty($errores)) {
        // Convierte los errores en un string para mostrarlos en un alert
        $erroresString = implode("\\n", $errores);

        // Redirige al formulario de registro con un alert
        echo "<script>
            alert('$erroresString');
            window.location.href = '/Codigo/registro.php';
        </script>";
        exit();
    } else {
        // Encriptar la contraseña
        $password_encriptada = password_hash($_POST['pass'], PASSWORD_DEFAULT);

        // Construir la consulta SQL dinámicamente con SET
        $sql = "INSERT INTO pacientes SET 
          nombre = ?, 
          apellido1 = ?";

        $parametros = [$_POST['nombre'], $_POST['apellido1']];
        $tipos = "ss";

        // Agregar campos opcionales dinámicamente
        if (!empty($_POST['apellido2'])) {
            $sql .= ", apellido2 = ?";
            $parametros[] = $_POST['apellido2'];
            $tipos .= "s";
        }
        if (!empty($_POST['email'])) {
            $sql .= ", email = ?";
            $parametros[] = $_POST['email'];
            $tipos .= "s";
        }
        if (!empty($telefonoCompleto)) {
            $sql .= ", telefono = ?";
            $parametros[] = $telefonoCompleto;
            $tipos .= "s";
        }
        if (!empty($_POST['fecha_nacimiento'])) {
            $sql .= ", fechaNacim = ?";
            $parametros[] = $_POST['fecha_nacimiento'];
            $tipos .= "s";
        }
        $sql .= ", sexo = ?";
        $parametros[] = $sexo;
        $tipos .= "s";

        if (!empty($_POST['dni'])) {
            $sql .= ", dni = ?";
            $parametros[] = $_POST['dni'];
            $tipos .= "s";
            //guardamos el dni original
            $sql .= ", dni_original = ?";
            $parametros[] = $_POST['dni'];  // mismo valor que el actual
            $tipos .= "s";
        }
        if (!empty($password_encriptada)) {
            $sql .= ", pass = ?";
            $parametros[] = $password_encriptada;
            $tipos .= "s";
        }

        // Preparar la consulta
        $stmt = $conexion->prepare($sql);

        // Vincular los parámetros dinámicamente
        $stmt->bind_param($tipos, ...$parametros);

        if ($stmt->execute()) {
            // Redirigir al usuario después del registro exitoso
            header('Location: /Codigo/index.php');
            exit();
        } else {
            echo "<script>
                alert('Error al registrar al usuario. Por favor, inténtalo de nuevo.');
                window.location.href = '/Codigo/registro.php';
            </script>";
        }
    }
}
