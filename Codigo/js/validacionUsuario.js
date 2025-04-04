window.onload = iniciar;

function iniciar() {
    document.getElementById("validacionUsuario").addEventListener("submit", validacionUsuario, false);
}

function validacionUsuario(event) {
    event.preventDefault();
    if (validarUsuario() && validarContrasena()) {
        alert("Formulario enviado correctamente");
        window.location.href = "/Codigo/citas.php";
        return true;
    } else {
        alert("Error en el formulario, por favor corrige los campos marcados.");
        return false;
    }
}

function validarUsuario() {
    let usuario = document.getElementById("c1");
    const regexUsuario = /^[a-zA-Z0-9]+$/; // Solo permite letras y números

    if (!usuario.checkValidity() || !regexUsuario.test(usuario.value)) {
        error(usuario, "El usuario solo puede contener letras y números.");
        return false;
    } else {
        usuario.style.border = "2px solid green";
    }
    return true;
}

function validarContrasena() {
    let contrasena = document.getElementById("c2");
    const regexContrasena = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    // Al menos 8 caracteres, una letra mayúscula, un número y un carácter especial

    if (!contrasena.checkValidity() || !regexContrasena.test(contrasena.value)) {
        error(contrasena, "La contraseña debe tener al menos 8 caracteres, una letra mayúscula, un número y un carácter especial.");
        return false;
    } else {
        contrasena.style.border = "2px solid green";
    }
    return true;
}

// Modificar la función de error para aceptar mensajes personalizados
function error(message) {
    const errorElement = document.getElementById('error-message');
    if (errorElement) {
        errorElement.innerHTML = message; // Solo intenta modificar si el elemento existe
    } else {
        console.error('El elemento con id "error-message" no existe.');
    }
}
//validar borrar error
function borrarError() {
    let formulario = document.forms[0];
    for (let i = 0; i < formulario.elements.length; i++) {
        formulario.elements[i].style.border = "";
    }
    document.getElementById("error").innerHTML = "";
}