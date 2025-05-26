<?php
require_once __DIR__ . '/../../conexion/conexion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['paciente'])) {
    $idPaciente = intval($_POST['paciente']);
    $_SESSION['idPaciente'] = $idPaciente;
    //de la tabla apcientes cogemos cada dato y los mostramos como->
    $stmt = $conexion->prepare("SELECT idPacientes AS 'ID', 
                                        nombre AS 'Nombre', 
                                        apellido1 AS 'Primer apellido',
                                        apellido2 AS 'Segundo apellido',
                                        email AS 'Email',
                                        telefono AS 'Teléfono',
                                        fechaNacim AS 'Fecha de nacimiento',
                                        sexo AS 'Sexo',
                                        dni AS 'DNI',
                                        dni_original AS 'DNI original'
                                        FROM Pacientes
                                        WHERE idPacientes = ?");
    $stmt->bind_param("i", $idPaciente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo "<h3>Ficha del Paciente</h3><ul>";
        foreach ($row as $campo => $valor) {

            if(empty($valor)){ //si el valor es vacio no lo mostramos
                continue;
            }
            //para formatear el campo de fecha a español
            if ($campo === 'Fecha de nacimiento' && !empty($valor)) {
                $formatter = new \IntlDateFormatter(
                    'es_ES',
                    \IntlDateFormatter::LONG,
                    \IntlDateFormatter::NONE,
                    'Europe/Madrid',
                    \IntlDateFormatter::GREGORIAN,
                    "d 'de' MMMM 'de' yyyy"
                );
                $fecha = new DateTime($valor);
                $valor = $formatter->format($fecha);
            }
            if($campo === 'ID'){
                $_SESSION['idPaciente'] = $valor;
            }
            echo "<li><strong>" . htmlspecialchars($campo) . ":</strong> " . htmlspecialchars($valor) . "</li>";
        }
        echo "</ul>";
        echo '<div class="acciones-historial">';
        echo '<button class="btnH" onclick="mostrarHistorial(\'editar\')">✏️ Editar Historial e Informe</button>';
        echo '<button class="btnH" onclick="mostrarHistorial(\'ver\')">👁 Ver Historial e Informe</button>';
        echo '</div>';
    } else {
        echo "<p>No se encontró el paciente.</p>";
    }
}
?>
