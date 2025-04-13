function newWindow() {
    let width = 800; // Ancho de la ventana
    let height = 600; // Alto de la ventana
    let left = (window.screen.width / 2) - (width / 2); // Centrar horizontalmente
    let top = (window.screen.height / 2) - (height / 2); // Centrar verticalmente

    let ventana = window.open(
        "", // Deja vacío para generar el contenido dinámicamente
        "popup",
        `width=${width},height=${height},left=${left},top=${top},scrollbars=yes,resizable=yes,toolbar=no,location=no,status=no,menubar=no`
    );

    ventana.document.write(`
        <html>
            <head>
            <link rel="stylesheet" href="/Codigo/estilos/styleEditPerfil.css">
                <title>Cambiar Contraseña</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        text-align: center;
                        padding: 20px;
                    }
                    input {
                        margin: 10px 0;
                        padding: 10px;
                        width: 80%;
                    }
                    button {
                        padding: 10px 20px;
                        margin: 10px;
                    }
                    table {
                        margin: 0 auto;
                        border-collapse: collapse;
                    }
                </style>
            </head>
            <body>
                <h1>Cambiar Contraseña</h1>
                <form action="/Codigo/validaciones/editarPerfil/procesar_Edit_Perfil.php" method="POST">
                    <table>
                        <tr>
                            <td><label for="passwordActual">Contraseña Actual:</label></td>
                            <td><input type="password" id="passwordActual" name="passwordActual" required></td>
                        </tr>
                        <tr>
                            <td><label for="nuevaContrasena">Nueva Contraseña:</label></td>
                            <td><input type="password" id="nuevaContrasena" name="nuevaContrasena" required></td>
                        </tr>
                        <tr>
                            <td><label for="confirmarContrasena">Confirmar Nueva Contraseña:</label></td>
                            <td><input type="password" id="confirmarContrasena" name="confirmarContrasena" required></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <button type="submit" class="popUpGuardar">Guardar</button>
                                <button type="button" class="popUpCerrar" onclick="window.close()">Cerrar</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </body>
        </html>
    `);

    ventana.document.close();
}

function cerrarPopup() {
    const popup = window.open("", "popup");
    if (popup) {
        popup.close();
    }
}