<?php

require_once __DIR__ . '/../conexion/conexion.php';

//primero crear un formulario para crear el tratamiento y luego otro para buscarlo

//consulta en la bd para ver lso tratamientos disponibles y aplicados al paciente que coincida con la busqueda de busqueda.php
//deberia de ser un select que muestre el nombre del tratamiento, la fecha de inicio y la fecha de fin, el estado (si esta en curso o finalizado) y el id del tratamiento
//para poder modificarlo o eliminarlo
?>

<form action="insertar_tratamiento.php" method="post">
    <table>
        <tr>
            <td><label for="nombre">Nombre:</label></td>
            <td><input type="text" name="nombre" id="nombre"></td>
        </tr>
        <tr>
            <td><label for="descripcion">Descripcion:</label></td>
            <td><textarea name="descripcion" id="descripcion"></textarea></td>
        </tr>
        <tr>
            <td><label for="precio">Precio:</label></td>
            <td><input type="number" name="precio" id="precio"></td>
        </tr>
        <tr>
            <td><label for="fechaInicio"></label>Fecha Inicio:</td>
            <td><input type="date" name="fechaInicio" id="fechaInicio"></td>
        </tr>
        <tr>
            <td><label for="fechaFin"></label>Fecha Fin:</td>
            <td><input type="date" name="fechaFin" id="fechaFin"></td>
        </tr>
        <tr>
            <td><label for="estado">Estado:</label></td>
            <td>
                <select name="estado" id="estado">
                    <option value="pendiente">Pendiente</option>
                    <option value="confirmada">Confrimada</option>
                    <option value="finalizado">Finalizado</option>
                </select>
            </td>
        </tr>
    </table>
    <button type="submit" name="">Crear</button>
</form>