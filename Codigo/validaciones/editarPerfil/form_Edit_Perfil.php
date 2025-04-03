<!-- campos a editar del usuario -->
<form action="/Codigo/validaciones/editarPerfil/procesar_Edit_Perfil.php" method="POST">
    <table>
        <!-- Campo para el email -->
        <tr>
            <td><label for="c1">Email:</label></td>
            <td><input type="email" id="c1" name="email" value="<?php echo htmlspecialchars($paciente['email']); ?>" required></td>
        </tr>

        <!-- Campo para el teléfono -->
        <tr>
            <td><label for="c2">Teléfono:</label></td>
            <td><input type="tel" id="c2" name="telefono" value="<?php echo htmlspecialchars($paciente['telefono']); ?>" required></td>
        </tr>

        <!-- Campo para el sexo -->
        <tr>
            <td><label for="c3">Sexo:</label></td>
            <td>
                <select id="c3" name="sexo" required>
                    <option value="masculino" <?php echo $paciente['sexo'] === 'masculino' ? 'selected' : ''; ?>>Masculino</option>
                    <option value="femenino" <?php echo $paciente['sexo'] === 'femenino' ? 'selected' : ''; ?>>Femenino</option>
                    <option value="otro" <?php echo $paciente['sexo'] === 'otro' ? 'selected' : ''; ?>>Otro</option>
                </select>
            </td>
        </tr>

        <!-- Campo para la contraseña -->
        <tr>
            <td><label for="c4">Contraseña:</label></td>
            <td><input type="password" id="c4" name="password" placeholder="Nueva contraseña"></td>
        </tr>
    </table>

    <!-- Botón para enviar el formulario -->
    <button type="submit">Guardar Cambios</button>
</form>