<?php

require_once __DIR__ . '/../../../conexion/conexion.php';

//para agregar el historial clinico de los pacientes
?>

<form action="/Codigo/validaciones/historialClinico/crearHistorial/validar_historial_clinico.php" method="post" enctype="multipart/form-data">
    <table id="datos_personales">
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
    </table>
    <table id="tabla_historial_clinico">
        <tr>
            <td><label for="motivo">Motivo de la consulta:</label></td>
            <td><textarea name="motivo" id="motivo" required></textarea></td>
        </tr>
        <tr>
            <td><label for="antec_podologicos">Antec. podológicos:</label></td>
            <td><textarea name="antec_podologicos" id="antec_podologicos"></textarea></td>
        </tr>
        <tr>
            <td><label for="antec_quirurgicos">Antec. quirúrgicos:</label></td>
            <td><textarea name="antec_quirurgicos" id="antec_quirurgicos"></textarea></td>
        </tr>
        <tr>
            <td><label for="patologias">Patologías:</label></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="checkbox" name="patologias[]" value="Diabetes">Diabetes</td>
            <td><input type="checkbox" name="patologias[]" value="Colesterol">Colesterol</td>
            <td><input type="checkbox" name="patologias[]" value="HTA">HTA</td>
        </tr>
        <tr>
            <td></td>
            <td><input type="checkbox" name="patologias[]" value="Alt. Coagulacion">Alt. Coagulación</td>
            <td><input type="checkbox" name="patologias[]" value="Artrosis">Artrosis</td>
            <td><input type="checkbox" name="patologias[]" value="Embarazo/Lactancia">Embarazo/Lactancia</td>
        </tr>
        <tr>
            <td>Agregar patologia</td>
            <td><button id="agregarPatologia">Añadir</button></td>
        </tr>
        <tr>
            <td><label for="antecedentes">Antec. familiares:</label></td>
            <td><input type="text" name="antecedentes" id="antecedentes"></td>
        </tr>
        <tr>
            <td><label for="alergias">Alergias:</label></td>
            <td><input type="text" name="alergias" id="alergias"></td>
        </tr>
        <tr>
            <td><label for="farmacologia">Farmacologia:</label></td>
            <td><input type="text" name="farmacologia" id="farmacologia"></td>
        </tr>
        <tr>
            <td><label for="desarrolloPSi">Desarrollo psicomotriz:</label></td>
            <td><input type="text" name="desarrolloPSi" id="desarrolloPSi"></td>
        </tr>
        <tr>
            <td><label for="observaciones">observaciones:</label></td>
            <td><textarea name="observaciones" id="observaciones"></textarea></td>
        </tr>
    </table>
    <table id="inspeccion">
        <tr>
            <td><label for="archivo">Adjuntar Archivo:</label></td>
            <td><input type="file" name="archivo" id="archivo"></td>
        </tr>
        <tr>
            <td>visualizacion imagen</td>
            <?php
            //tratado de la imagen
            ?>
        </tr>
        <tr>
            <td></td>
            <td><input type="checkbox" name="onicopatias" value="onicopatias">Onicopatías</td>
        </tr>
        <tr>
            <td></td>
            <td><input type="checkbox" name="queratopatias" value="queratopatias">Queratopatias</td>
        </tr>
        <tr>
            <td></td>
            <td><input type="checkbox" name="dermatopatias" value="dermatopatias">Dermatopatias</td>
        </tr>
        <tr>
            <td></td>
            <td><input type="checkbox" name="prominenciasOseas" value="prominenciasOseas">Prominencias Oseas</td>
        </tr>
        <tr>
            <td></td>
            <td><input type="checkbox" name="altDigitales" value="altDigitales">Alt Digitales</td>
        </tr>
        <tr>
            <td><label for="dx">Descripcion:</label></td>
            <td><textarea name="dx" id="dx"></textarea></td>
        </tr>
    </table>
    <table id="tratamiento">
        <tr>
            <td><label for="tratamiento">Tratamiento:</label></td>
            <td><textarea name="tratamiento" id="tratamiento"></textarea></td>
        </tr>
        <tr>
            <td><label for="receta">Receta:(Posologia/Duracion tto)</label></td>
            <td><textarea name="receta" id="receta"></textarea></td>
        </tr>
    </table>
    <table id="seguimiento">
        <tr>
            <td><label for="fecha">Fecha:</label></td>
            <td><input type="date" name="fecha" id="fecha"></td>
        </tr>
        <tr>
            <td><label for="seguimiento">Seguimiento:</label></td>
            <td><textarea name="seguimiento" id="seguimiento"></textarea></td>
        </tr>
    </table>
    <button type="submit" name="">Crear</button>
</form>
<script src="/Codigo/validaciones/historialClinico/agregarPatologia.js"></script>