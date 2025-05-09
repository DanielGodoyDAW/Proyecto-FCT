<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';

if (isset($_SESSION['idPacientes'])) {
    $idUsuario = $_SESSION['idPacientes'];
} elseif (isset($_SESSION['idAdmin'])) {
    $idUsuario = $_SESSION['idAdmin'];
}

// Comprobar si el paciente es temporal y recuperar dni_original
$queryUser = "SELECT es_temporal, dni_original, pass, dni FROM Pacientes WHERE idPacientes = ?";
$stmtUser = $conexion->prepare($queryUser);
$stmtUser->bind_param('i', $idUsuario);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$paciente = $resultUser->fetch_assoc();

$esTemporal = isset($paciente['es_temporal']) && $paciente['es_temporal'] == 1;
$dniOriginalBD = $paciente['dni_original'] ?? null;

// Recoger datos
$email = $_POST['email'] ?? null;
$telefono = $_POST['telefono'] ?? null;
$extension = $_POST['extension'] ?? null;
$sexo = $_POST['sexo'] ?? 'O';
$fechaNacim = $_POST['fechaNacim'] ?? null;
$nuevoDNI = strtoupper(trim($_POST['nuevoDNI'] ?? ''));
$fromPopup = isset($_POST['fromPopup']);
$passwordActual = $_POST['passwordActual'] ?? null;
$nuevaContrasena = $_POST['nuevaContrasena'] ?? null;
$confirmarContrasena = $_POST['confirmarContrasena'] ?? null;
$telefonoCompleto = $extension . ' ' . $telefono;

// Determinar DNI editable
if (isset($_SESSION['idAdmin'])) {
    $dniEditable = strtoupper(trim($_POST['dni'] ?? ''));
} elseif ($esTemporal && !empty($nuevoDNI)) {
    $dniEditable = $nuevoDNI;
} else {
    $dniEditable = $paciente['dni']; // Mantener el original
}

// Cambio de contraseña desde popup
if ($fromPopup) {
    if (!empty($passwordActual) && !empty($nuevaContrasena) && !empty($confirmarContrasena)) {
        if ($nuevaContrasena !== $confirmarContrasena) {
            echo '<script>alert("Error: Las contraseñas no coinciden."); window.close();</script>';
            exit;
        }
        if (!password_verify($passwordActual, $paciente['pass'])) {
            echo '<script>alert("Error: La contraseña actual es incorrecta."); window.close();</script>';
            exit;
        }

        $hashedPassword = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
        $stmt = $conexion->prepare("UPDATE Pacientes SET pass = ? WHERE idPacientes = ?");
        $stmt->bind_param('si', $hashedPassword, $idUsuario);
        $stmt->execute();

        echo '<script>alert("Contraseña actualizada correctamente."); window.location.href = "/Codigo/editar_perfil.php";</script>';
        exit;
    }
    exit;
}

// Validar DNI
if (!$dniEditable || !preg_match('/^[0-9]{8}[A-Z]$/', $dniEditable)) {
    echo '<script>alert("DNI no válido. Debe tener 8 números y 1 letra mayúscula."); window.location.href = "/Codigo/editar_perfil.php";</script>';
    exit;
}

// Comprobar si el DNI ya existe en otro usuario
$stmt = $conexion->prepare("SELECT idPacientes FROM Pacientes WHERE dni = ? AND idPacientes != ?");
$stmt->bind_param("si", $dniEditable, $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo '<script>alert("El DNI ya está registrado por otro paciente."); window.location.href = "/Codigo/editar_perfil.php";</script>';
    exit;
}

// Si el paciente es temporal, debe rellenar nuevo DNI
if ($esTemporal && empty($nuevoDNI)) {
    echo '<script>alert("Debes introducir tu DNI para completar tu perfil."); window.location.href = "/Codigo/editar_perfil.php";</script>';
    exit;
}

// --- Actualización ---
if ($esTemporal && !empty($nuevoDNI)) {
    if (!$dniOriginalBD) {
        $query = "UPDATE Pacientes SET email = ?, telefono = ?, sexo = ?, fechaNacim = ?, dni = ?, dni_original = ?, es_temporal = 0 WHERE idPacientes = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ssssssi', $email, $telefonoCompleto, $sexo, $fechaNacim, $dniEditable, $dniEditable, $idUsuario);
    } else {
        $query = "UPDATE Pacientes SET email = ?, telefono = ?, sexo = ?, fechaNacim = ?, dni = ?, es_temporal = 0 WHERE idPacientes = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('sssssi', $email, $telefonoCompleto, $sexo, $fechaNacim, $dniEditable, $idUsuario);
    }
} else {
    $query = "UPDATE Pacientes SET email = ?, telefono = ?, sexo = ?, fechaNacim = ?, dni = ? WHERE idPacientes = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('sssssi', $email, $telefonoCompleto, $sexo, $fechaNacim, $dniEditable, $idUsuario);
}

// Ejecutar
if ($stmt->execute()) {
    $_SESSION['sexo'] = $sexo;
    $mensaje = $esTemporal ? "¡Perfil actualizado correctamente! Ahora formas parte de la clínica como paciente registrado." : "Perfil actualizado correctamente.";
    echo "<script>alert('$mensaje'); window.location.href = '/Codigo/editar_perfil.php';</script>";
    exit;
} else {
    echo '<script>alert("Error: No se pudo actualizar el perfil."); window.location.href = "/Codigo/editar_perfil.php";</script>';
    exit;
}
?>
