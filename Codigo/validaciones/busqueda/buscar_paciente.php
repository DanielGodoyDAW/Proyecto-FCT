<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if (isset($_POST['consulta'])) {
    // Limpia el input: elimina espacios y pasa a minúsculas para facilitar búsqueda
    $input = strtolower(trim($_POST['consulta']));
    // Prepara el patrón de búsqueda con comodines para usar en LIKE
    $busqueda = '%' . $input . '%';

    // Normaliza teléfono quitando espacios
    //Busca en los campos 'nombre' y 'apellido1' sin distinguir mayúsculas/minúsculas
    //También busca en el campo 'telefono', quitando espacios para evitar fallos por formato
    $stmt = $conexion->prepare("
        SELECT idPacientes, nombre, apellido1, telefono 
        FROM Pacientes 
        WHERE 
            LOWER(nombre) LIKE ? 
            OR LOWER(apellido1) LIKE ? 
            OR REPLACE(telefono, ' ', '') LIKE REPLACE(?, ' ', '')
        LIMIT 10
    ");
    $stmt->bind_param("sss", $busqueda, $busqueda, $busqueda);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="sugerencia-item" data-id="' . $row['idPacientes'] . '">'
                . htmlspecialchars($row['nombre']) . ' '
                . htmlspecialchars($row['apellido1']) . ' '
                . htmlspecialchars($row['telefono']) .
                '</div>';
        }
    } else {
        echo '<div class="sugerencia-item">No encontrado</div>';
    }
}
?>
