<?php

require_once __DIR__ . '/../../conexion/conexion.php';

//para agregar el historial clinico de los pacientes
?>

<form action="/Codigo/validaciones/historialClinico/validar_historial_clinico.php" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td><label for="paciente">Paciente:</label></td>
            <td>
                <select name="paciente" id="paciente">
                    <option value="">Seleccione un paciente</option>
                    <?php
                    // Consulta para obtener los pacientes
                    $query = "SELECT idPacientes, nombre, apellido1, apellido2 
                  FROM Pacientes 
                  WHERE idPacientes != ?";
                    $stmt = $conexion->prepare($query);
                    $stmt->bind_param("i", $idAdmin);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['idPacientes'] . '">' . $row['nombre'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2'] . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><label for="descripcon">Descripcion:</label></td>
            <td><textarea name="descripcion" id="descripcion" required></textarea></td>
        </tr>
        <tr>
            <td><label for="archivo">Adjuntar Archivo:</label></td>
            <td><input type="file" name="archivo" id="archivo"></td>
        </tr>
    </table>
    <button type="submit" name="">Crear</button>
</form>