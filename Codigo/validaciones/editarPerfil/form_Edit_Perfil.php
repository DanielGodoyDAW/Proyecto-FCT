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

//para separar el telefono y la extension
$telefonoCompleto = $pacientes['telefono'] ?? '';
preg_match('/^(\+\d+)\s*(.*)$/', $telefonoCompleto, $matches);

$extension = $matches[1] ?? '+34'; // Valor predeterminado si no hay extension
$telefono = $matches[2] ?? ''; 

$extensiones = [
    "+34" => "España",
    "+1" => "EE.UU.",
    "+44" => "Reino Unido",
    "+66" => "Tailandia",
    "+52" => "México",
    "+57" => "Colombia",
    "+54" => "Argentina",
    "+33" => "Francia",
    "+49" => "Alemania",
    "+39" => "Italia",
    "+81" => "Japón",
    "+82" => "Corea del Sur",
    "+86" => "China",
    "+91" => "India",
    "+7" => "Rusia",
    "+61" => "Australia",
    "+55" => "Brasil",
    "+27" => "Sudáfrica",
    "+47" => "Noruega",
    "+46" => "Suecia",
    "+48" => "Polonia",
    "+90" => "Turquía",
    "+63" => "Filipinas",
    "+64" => "Nueva Zelanda",
    "+20" => "Egipto",
    "+234" => "Nigeria",
    "+62" => "Indonesia",
    "+94" => "Sri Lanka",
    "+98" => "Irán",
    "+31" => "Países Bajos",
    "+41" => "Suiza",
    "+32" => "Bélgica",
    "+351" => "Portugal",
    "+45" => "Dinamarca",
    "+420" => "República Checa",
    "+421" => "Eslovaquia",
    "+36" => "Hungría",
    "+40" => "Rumanía",
    "+56" => "Chile",
    "+58" => "Venezuela",
    "+593" => "Ecuador",
    "+598" => "Uruguay",
    "+505" => "Nicaragua",
    "+506" => "Costa Rica",
    "+507" => "Panamá"
];

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
            <td><label for="extension">Extensión:</label></td>
            <td>
                <select id="extension" name="extension" required>
                    <?php foreach ($extensiones as $codigo => $pais){ ?>
                        <option value="<?php echo $codigo; ?>" <?php echo $extension === $codigo ? 'selected' : ''; ?>>
                            <?php echo $codigo . " (" . $pais . ")"; ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
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