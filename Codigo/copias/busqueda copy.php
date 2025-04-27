<?php


//consulta a la bd para buscar un paciente por idPaciente (desplegable con los nombres), por fecha (una fecha estimada de inicio y fin)
//el tratamiento

require_once __DIR__ . '/../../conexion/conexion.php';


//consulta con seleccion de paciente por idPaciente, nombre, apellido1 y apellido2 en formulario de busqueda
//por numero de telefono
//por primer apellido o por nombre

?>
<form action="/Codigo/validaciones/busqueda/procesar_busqueda.php" method="post">
    <table>
        <tr>
            <td><label for="nombre">Nombre:</label></td>
            <td>
                <select name="nombre" id="nombre">
                    <option value="">Seleccione un nombre</option>
                    <?php
                    // Consulta para obtener todos los nombres de los pacientes
                    $query = "SELECT DISTINCT nombre FROM Pacientes WHERE idPacientes != ?";
                    $stmt = $conexion->prepare($query);
                    $stmt->bind_param("i", $idAdmin);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['nombre'] . '">' . $row['nombre'] . '</option>';
                    }
                    ?>
                </select>
            </td>
            <td><label for="paciente">Busqueda Rápida:</label></td>
            <td>
                <select name="paciente" id="paciente">
                    <option value="">Seleccione un paciente</option>
                    <?php
                    // Consulta para obtener los pacientes, excluyendo al usuario logueado
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
            <td><label for="apellido1">Primer Apellido:</label></td>
            <td><input type="text" name="apellido1" id="apellido1"></td>
        </tr>
        <tr>

        </tr>
        <tr>
            <td><label for="telefono">Telefono:</label></td>
            <td><input type="text" name="telefono" id="telefono"></td>
        </tr>
    </table>
    <button type="submit">Enviar</button>
</form>