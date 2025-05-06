<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';

if (isset($_SESSION['idPacientes'])) {
    $idUsuario = $_SESSION['idPacientes'];
} elseif (isset($_SESSION['idAdmin'])) {
    $idUsuario = $_SESSION['idAdmin'];
}

// Recoger todos los datos del formulario
$email = $_POST['email'] ?? null;
$telefono = $_POST['telefono'] ?? null;
$extension = $_POST['extension'] ?? null;
$sexo = $_POST['sexo'] ?? null;
$fechaNacim = $_POST['fechaNacim'] ?? null;
$passwordActual = $_POST['passwordActual'] ?? null;
$nuevaContrasena = $_POST['nuevaContrasena'] ?? null;
$confirmarContrasena = $_POST['confirmarContrasena'] ?? null;
$nuevoDNI = $_POST['nuevoDNI'] ?? null;

// Unificamos el teléfono con la extensión
$telefonoCompleto = $extension . ' ' . $telefono;

$fromPopup = isset($_POST['fromPopup']) ? true : false;

// Si viene del popup de cambiar contraseña 
if ($fromPopup) {
    if (!empty($passwordActual) || !empty($nuevaContrasena) || !empty($confirmarContrasena)) { // Si hay datos de contraseña
        if ($nuevaContrasena !== $confirmarContrasena) { // Si las contraseñas no coinciden
            echo '<script>
                alert("Error: Las contraseñas no coinciden.");
                window.close();
            </script>';
            exit;
        }

        // consulta para ver la contraseña actual
        $query = "SELECT pass FROM Pacientes WHERE idPacientes = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('i', $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();

        // si el resultado de la consulta es 0, no existe el usuario
        if ($result->num_rows === 0) {
            echo '<script>
                alert("Error: Usuario no encontrado.");
                window.close();
            </script>';
            exit;
        }

        $usuario = $result->fetch_assoc();
        if (!password_verify($passwordActual, $usuario['pass'])) { // Si la contraseña actual no coincide
            echo '<script>
                alert("Error: La contraseña actual es incorrecta.");
                window.close();
            </script>';
            exit;
        }

        // Si la contraseña actual es correcta, actualizamos la nueva contraseña
        $hashedPassword = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
        // Actualizamos la contraseña en la base de datos
        $query = "UPDATE Pacientes SET pass = ? WHERE idPacientes = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('si', $hashedPassword, $idUsuario);

        if (!$stmt->execute()) {
            echo '<script>
                alert("Error: No se pudo actualizar la contraseña.");
                window.location.href = "/Codigo/editar_perfil.php";
            </script>';
            exit;
        }

        echo '<script>
            alert("Contraseña actualizada correctamente.");
            window.location.href = "/Codigo/editar_perfil.php";
        </script>';
        exit;
    }
    // Si no hay datos de contraseña, no hacemos nada
    exit;
}

// Solo si NO viene del popup: Actualizar perfil completo

// Primero verificamos si el paciente es temporal
$queryTemporal = "SELECT es_temporal FROM Pacientes WHERE idPacientes = ?";
$stmtTemporal = $conexion->prepare($queryTemporal);
$stmtTemporal->bind_param('i', $idUsuario);
$stmtTemporal->execute();
$resultTemporal = $stmtTemporal->get_result();
$usuarioTemporal = $resultTemporal->fetch_assoc();
$esTemporal = isset($usuarioTemporal['es_temporal']) && $usuarioTemporal['es_temporal'] == 1;

if ($esTemporal && empty($nuevoDNI)) { // Si es temporal y no ha puesto DNI
    echo '<script>
        alert("Debes introducir tu DNI para completar tu perfil.");
        window.location.href = "/Codigo/editar_perfil.php";
    </script>';
    exit;
}

// Ahora actualizamos dependiendo si es temporal y ha puesto datos nuevos
if ($esTemporal && !empty($nuevoDNI)) {
    // Actualizar también Email, DNI y cambiar es_temporal a 0 (ya es paciente normal)
    $query = "UPDATE Pacientes SET email = ?, telefono = ?, sexo = ?, fechaNacim = ?, dni = ?, es_temporal = 0 WHERE idPacientes = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('sssssi', $email, $telefonoCompleto, $sexo, $fechaNacim, $nuevoDNI, $idUsuario);
} else {
    // Caso normal: actualizar email, teléfono, sexo y fecha de nacimiento
    $query = "UPDATE Pacientes SET email = ?, telefono = ?, sexo = ?, fechaNacim = ? WHERE idPacientes = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('ssssi', $email, $telefonoCompleto, $sexo, $fechaNacim, $idUsuario);
}

// Ejecutamos actualización
if ($stmt->execute()) {
    $_SESSION['sexo'] = $sexo;

    echo '<script>
        alert("Perfil actualizado correctamente. ¡Ya formas parte de la clínica como paciente registrado!");
        window.location.href = "/Codigo/editar_perfil.php";
    </script>';
    exit;
} else {
    echo '<script>
        alert("Error: No se pudo actualizar el perfil.");
        window.location.href = "/Codigo/editar_perfil.php";
    </script>';
    exit;
}
?>
