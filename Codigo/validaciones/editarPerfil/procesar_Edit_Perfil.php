<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';

$idUsuario = null;
$esAdmin = false;

if (isset($_SESSION['idPacientes'])) {
    $idUsuario = $_SESSION['idPacientes'];
} elseif (isset($_SESSION['idAdmin']) && isset($_POST['desde_admin']) && isset($_POST['idPaciente'])) {
    $idUsuario = $_POST['idPaciente'];
    $esAdmin = true;
}

if (!$idUsuario) {
    echo '<script>alert("No se ha identificado el usuario."); window.location.href = "./index.php";</script>';
    exit;
}

// Obtener datos del paciente
$stmt = $conexion->prepare("SELECT es_temporal, dni_original, pass, dni FROM Pacientes WHERE idPacientes = ?");
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$paciente = $stmt->get_result()->fetch_assoc();

$esTemporal = isset($paciente['es_temporal']) && $paciente['es_temporal'] == 1;
$dniOriginalBD = $paciente['dni_original'] ?? null;

// Datos recibidos
$email = $_POST['email'] ?? null;
$telefono = $_POST['telefono'] ?? '';
$extension = $_POST['extension'] ?? '';
$telefonoCompleto = trim($extension . ' ' . $telefono);
$sexo = null;
$fechaNacim = $_POST['fechaNacim'] ?? null;
$fromPopup = isset($_POST['fromPopup']);
$passwordActual = $_POST['passwordActual'] ?? null;
$nuevaContrasena = $_POST['nuevaContrasena'] ?? null;
$confirmarContrasena = $_POST['confirmarContrasena'] ?? null;
$dni = strtoupper(trim($_POST['dni'] ?? ''));
$nuevoDNI = strtoupper(trim($_POST['nuevoDNI'] ?? ''));

if (!empty($_POST['sexo']) && in_array($_POST['sexo'], ['H', 'M', 'O'])) {
    $sexo = $_POST['sexo'];
}

// Contraseña desde div oculto
if ($fromPopup) {
    if (!empty($passwordActual) && !empty($nuevaContrasena) && !empty($confirmarContrasena)) {
        if ($nuevaContrasena !== $confirmarContrasena) {
            echo '<script>alert("Las contraseñas no coinciden."); window.close();</script>';
            exit;
        }

        if (!password_verify($passwordActual, $paciente['pass'])) {
            echo '<script>alert("La contraseña actual es incorrecta."); window.close();</script>';
            exit;
        }

        $nuevaHash = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
        $stmt = $conexion->prepare("UPDATE Pacientes SET pass = ? WHERE idPacientes = ?");
        $stmt->bind_param("si", $nuevaHash, $idUsuario);
        $stmt->execute();

        echo '<script>alert("Contraseña actualizada correctamente."); window.location.href = "./editar_perfil.php";</script>';
        exit;
    }
    exit;
}

// Determinar cuál DNI vamos a aplicar
if ($esAdmin) {
    $dniEditable = $dni;
} elseif ($esTemporal && !empty($nuevoDNI)) {
    $dniEditable = $nuevoDNI;
} else {
    $dniEditable = $paciente['dni'];
}

// Validar DNI
if (!$dniEditable || !preg_match('/^[0-9]{8}[A-Z]$/', $dniEditable)) {
    echo '<script>alert("DNI no válido. Debe tener 8 números y 1 letra mayúscula."); window.location.href = "./editar_perfil.php";</script>';
    exit;
}

// Comprobar si el DNI ya existe en otro usuario
$stmt = $conexion->prepare("SELECT idPacientes FROM Pacientes WHERE dni = ? AND idPacientes != ?");
$stmt->bind_param("si", $dniEditable, $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo '<script>alert("El DNI ya está registrado por otro paciente."); window.location.href = "./editar_perfil.php";</script>';
    exit;
}

// Si es temporal y no rellenó el nuevo DNI
if ($esTemporal && empty($nuevoDNI)) {
    echo '<script>alert("Debes introducir tu DNI para completar tu perfil."); window.location.href = "./editar_perfil.php";</script>';
    exit;
}

// Construir UPDATE dinámico
$campos = [];
$tipos = '';
$valores = [];

if ($email) {
    $campos[] = 'email = ?';
    $tipos .= 's';
    $valores[] = $email;
}
if (!empty($telefonoCompleto) && trim($telefonoCompleto) !== '+') {
    $campos[] = 'telefono = ?';
    $tipos .= 's';
    $valores[] = $telefonoCompleto;
}
if (!is_null($sexo)) {
    $campos[] = 'sexo = ?';
    $tipos .= 's';
    $valores[] = $sexo;
}
if ($fechaNacim) {
    $campos[] = 'fechaNacim = ?';
    $tipos .= 's';
    $valores[] = $fechaNacim;
}
$campos[] = 'dni = ?';
$tipos .= 's';
$valores[] = $dniEditable;

if ($esTemporal) {
    $campos[] = 'es_temporal = 0';
    if (!$dniOriginalBD) {
        $campos[] = 'dni_original = ?';
        $tipos .= 's';
        $valores[] = $dniEditable;
    }
}

$tipos .= 'i';
$valores[] = $idUsuario;

$sql = "UPDATE Pacientes SET " . implode(', ', $campos) . " WHERE idPacientes = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param($tipos, ...$valores);

// Ejecutar
if ($stmt->execute()) {
    $_SESSION['sexo'] = $sexo;
    $redirect = $esAdmin ? './admin.php?seccion=historial&sub=editar' : './editar_perfil.php';
    echo "<script>alert('Perfil actualizado correctamente.'); window.location.href = '$redirect';</script>";
    exit;
} else {
    echo '<script>alert("Error: No se pudo actualizar el perfil."); window.location.href = "./editar_perfil.php";</script>';
    exit;
}
?>
