<?php
session_start();
require_once __DIR__ . '/../../conexion/conexion.php';
require_once __DIR__ . '/../../utilidades.php';

$esAdmin = false;
$idAdmin = $_SESSION['idAdmin'] ?? null;
$idPacienteSesion = $_SESSION['idPacientes'] ?? null;

if ($idAdmin) {
    $esAdmin = true;
}

$idPacienteEditado = null;

// Caso 1: admin editando perfil de paciente desde admin
if ($esAdmin && isset($_POST['desde_admin']) && isset($_POST['idPaciente'])) {
    $idPacienteEditado = (int) $_POST['idPaciente'];
    $_SESSION['idPaciente'] = $idPacienteEditado;
}
// Caso 2: paciente editando su propio perfil
elseif (!$esAdmin && $idPacienteSesion) {
    $idPacienteEditado = $idPacienteSesion;
}

// Si aún no tenemos paciente válido
if (!$idPacienteEditado) {
    echo '<script>alert("No se ha identificado el paciente."); window.location.href = "../../editar_perfil.php";</script>';
    exit;
}

// Obtener datos del paciente a modificar
$stmt = $conexion->prepare("SELECT es_temporal, dni_original, pass, dni FROM Pacientes WHERE idPacientes = ?");
$stmt->bind_param("i", $idPacienteEditado);
$stmt->execute();
$paciente = $stmt->get_result()->fetch_assoc();

$esTemporal = $paciente['es_temporal'] ?? 0;
$dniOriginalBD = $paciente['dni_original'] ?? null;

// Recoger datos del formulario
$email = $_POST['email'] ?? null;
$telefono = $_POST['telefono'] ?? '';
$extension = $_POST['extension'] ?? '';
$telefonoCompleto = trim($extension . ' ' . $telefono);
$sexo = $_POST['sexo'] ?? null;
$fechaNacim = $_POST['fechaNacim'] ?? null;
$dni = strtoupper(trim($_POST['dni'] ?? ''));
$nuevoDNI = strtoupper(trim($_POST['nuevoDNI'] ?? ''));
$fromPopup = isset($_POST['fromPopup']);
$passwordActual = $_POST['passwordActual'] ?? null;
$nuevaContrasena = $_POST['nuevaContrasena'] ?? null;
$confirmarContrasena = $_POST['confirmarContrasena'] ?? null;

// Cambiar contraseña
if ($fromPopup) {
    if ($passwordActual && $nuevaContrasena && $confirmarContrasena) {
        if ($nuevaContrasena !== $confirmarContrasena) {
            echo '<script>alert("Las contraseñas no coinciden."); window.location.href = "../../editar_perfil.php";</script>';
            exit;
        }

        if (!password_verify($passwordActual, $paciente['pass'])) {
            echo '<script>alert("La contraseña actual es incorrecta."); window.location.href = "../../editar_perfil.php";</script>';
            exit;
        }

        $nuevaHash = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
        $stmt = $conexion->prepare("UPDATE Pacientes SET pass = ? WHERE idPacientes = ?");
        $stmt->bind_param("si", $nuevaHash, $idPacienteEditado);
        $stmt->execute();

        echo '<script>alert("Contraseña actualizada correctamente."); window.location.href = "../../editar_perfil.php";</script>';
        exit;
    }
}

// Establecer el DNI editable
if ($esAdmin && isset($_POST['desde_admin'])) {
    $dniEditable = $dni;
} elseif ($esTemporal && $nuevoDNI) {
    $dniEditable = $nuevoDNI;
} else {
    $dniEditable = $paciente['dni'];
}

// Validación de DNI
if (!$dniEditable || !preg_match('/^[0-9]{8}[A-Z]$/', $dniEditable)) {
    echo '<script>alert("DNI no válido. Debe tener 8 números y 1 letra mayúscula."); window.location.href = "../../editar_perfil.php";</script>';
    exit;
}

// Comprobar duplicado en otro paciente
$stmt = $conexion->prepare("SELECT idPacientes FROM Pacientes WHERE dni = ? AND idPacientes != ?");
$stmt->bind_param("si", $dniEditable, $idPacienteEditado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('Ese DNI ya está registrado por otro paciente.'); window.location.href = '" . ruta_relativa('admin.php?seccion=historial&sub=editar') . "';</script>";
    exit;
}

// Si paciente temporal y no rellenó el nuevo DNI
if ($esTemporal && empty($nuevoDNI)) {
    echo '<script>alert("Debes introducir tu DNI para completar tu perfil."); window.location.href = "../../editar_perfil.php";</script>';
    exit;
}

// Construir actualización dinámica
$campos = [];
$tipos = '';
$valores = [];

if ($email) {
    $campos[] = 'email = ?';
    $tipos .= 's';
    $valores[] = $email;
}
if ($telefonoCompleto && trim($telefonoCompleto) !== '+') {
    $campos[] = 'telefono = ?';
    $tipos .= 's';
    $valores[] = $telefonoCompleto;
}
if (in_array($sexo, ['H', 'M', 'O'])) {
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
$valores[] = $idPacienteEditado;

$sql = "UPDATE Pacientes SET " . implode(', ', $campos) . " WHERE idPacientes = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param($tipos, ...$valores);

if ($stmt->execute()) {
    $_SESSION['sexo'] = $sexo ?? $_SESSION['sexo'];

    if ($stmt->affected_rows === 0) {
        echo "<script>alert('No se modificó nada porque los datos eran idénticos.'); window.location.href = '" . ruta_relativa('admin.php?seccion=historial&sub=editar') . "';</script>";
        exit;
    }

    echo "<script>alert('Perfil actualizado correctamente.'); window.location.href = '" . ruta_relativa('admin.php?seccion=historial&sub=editar') . "';</script>";
    exit;
} else {
    echo '<script>alert("Error al actualizar el perfil."); window.location.href = "../../editar_perfil.php";</script>';
    exit;
}
