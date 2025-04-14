<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Genera un token unico
}

if (isset($_SESSION['idPacientes'])) {
    $idPaciente = $_SESSION['idPacientes'];
} else if (isset($_SESSION['idAdmin'])) {
    $idPaciente = $_SESSION['idAdmin'];
}

// Consulta para obtener los datos del usuario
$query = "SELECT email, telefono, sexo FROM Pacientes WHERE idPacientes = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $idPaciente);
$stmt->execute();
$result = $stmt->get_result();

// Verifica si se encontraron datos
if ($result->num_rows === 0) {
    die('Error: No se encontraron datos del usuario.');
}

// Almacenamos los datos del usuario en un array
$pacientes = $result->fetch_assoc();
?>

<link rel="stylesheet" href="/Codigo/estilos/styleEditPerfil.css">
<script src="/Codigo/validaciones/editarPerfil/popupContraseña.js"></script>
<form action="/Codigo/validaciones/editarPerfil/procesar_Edit_Perfil.php" method="POST">

    <!-- Token CSRF para seguridad -->
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

    <table>
        <tr>
            <td><label for="c1">Email:</label></td>
            <td><input type="email" id="c1" name="email" value="<?php echo htmlspecialchars($pacientes['email']); ?>" required></td>
        </tr>
        <tr>
            <td><label for="c2">Teléfono:</label></td>
            <td><input type="tel" id="c2" name="telefono" value="<?php echo htmlspecialchars($pacientes['telefono']); ?>" required></td>
        </tr>
        <tr>
            <td><label for="c3">Sexo:</label></td>
            <td>
                <select id="c3" name="sexo" required>
                    <option value="H" <?php echo $pacientes['sexo'] === 'H' ? 'selected' : ''; ?>>Hombre</option>
                    <option value="M" <?php echo $pacientes['sexo'] === 'M' ? 'selected' : ''; ?>>Mujer</option>
                    <option value="O" <?php echo $pacientes['sexo'] === 'O' ? 'selected' : ''; ?>>Otro</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="button" id="btnCambiarContrasena" onclick="newWindow()">Cambiar Contraseña</button>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit">Guardar Cambios</button>
            </td>
        </tr>
    </table>
</form>