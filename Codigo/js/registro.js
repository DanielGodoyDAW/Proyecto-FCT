window.onload = iniciar;

function iniciar() {
    document.getElementById("validacionRegistro").addEventListener("submit", validarRegistro, false);
}

//funcion validar registro
function validarRegistro(event) {
    if (validarNombre() && validarApellido1() && validarApellido2() && validarDNI() && validarEmail() && validarTlf() && validarExtension() && validarFecha() && validarSexo() && validarPass() && validarConfirmarPass()) {
        alert("Formulario a la espera de verificación");
        return true;
    } else {
        alert("Error en el formulario, por favor corrige los campos marcados.");
        return false;
    }
}

//validar nombre
function validarNombre() {
    let nombre = document.getElementById("c1");
    if (!nombre.checkValidity()) {
        error(nombre);
        return false;
    } else {
        nombre.classList.remove("error");
        nombre.classList.add("success");
    }
    return true;
}

//validar apellido 1
function validarApellido1() {
    let apellido1 = document.getElementById("c2");
    if (!apellido1.checkValidity()) {
        error(apellido1);
        return false;
    } else {
        apellido1.style.border = "2px solid green";
    }
    return true;
}

//validar apellido 2
function validarApellido2() {
    let apellido2 = document.getElementById("c3");
    if (!apellido2.checkValidity()) {
        error(apellido2);
        return false;
    } else {
        apellido2.style.border = "2px solid green";
    }
    return true;
}

//validar dni
function validarDNI() {
    let dni = document.getElementById("c4");
    if (!dni.checkValidity()) {
        error(dni);
        return false;
    } else {
        dni.style.border = "2px solid green";
    }
    return true;
}

//validar email
function validarEmail() {
    let email = document.getElementById("c5");
    if (!email.checkValidity()) {
        error(email);
        return false;
    } else {
        email.style.border = "2px solid green";
    }
    return true;
}

//validar tlf
function validarTlf() {
    let tlf = document.getElementById("c6");
    if (!tlf.checkValidity()) {
        error(tlf);
        return false;
    } else {
        tlf.style.border = "2px solid green";
    }
    return true;
}

//validar extension
function validarExtension() {
    let extension = document.getElementById("extension");
    if (!extension.checkValidity()) {
        error(extension);
        return false;
    } else {
        extension.style.border = "2px solid green";
    }
    return true;
}

//validar fecha
function validarFecha() {
    let fecha = document.getElementById("c7");
    if (!fecha.checkValidity()) {
        error(fecha);
        return false;
    } else {
        fecha.style.border = "2px solid green";
    }
    return true;
}

//validar sexo
function validarSexo() {
    let sexo = document.getElementById("c8");
    if (!sexo.checkValidity()) {
        error(sexo);
        return false;
    } else {
        sexo.style.border = "2px solid green";
    }
    return true;
}

//validar contraseña
function validarPass() {
    let pass = document.getElementById("c9");
    const regexPass = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&+])[A-Za-z\d@$!%*?&+]{8,}$/;
    // Al menos 8 caracteres, una letra mayuscula, un numero y un caracter especial

    if (!pass.checkValidity() || !regexPass.test(pass.value)) {
        error(pass);
        return false;
    } else {
        pass.style.border = "2px solid green";
    }
    return true;
}

//validar confirmar contraseña
function validarConfirmarPass() {
    let pass = document.getElementById("c9");
    let confirmarPass = document.getElementById("c10");

    if (confirmarPass.value !== pass.value) {
        error(confirmarPass);
        document.getElementById("error").innerHTML = "Las contraseñas no coinciden.";
        return false;
    } else {
        confirmarPass.style.border = "2px solid green";
    }
    return true;
}

//validar error
function error(elemento) {
    const errorDiv = document.getElementById("error");
    if (!errorDiv) {
        console.error('El elemento con id "error" no existe en el DOM.');
        return;
    }

    if (elemento.validationMessage) {
        errorDiv.innerHTML = elemento.validationMessage;
    } else {
        errorDiv.innerHTML = "Error desconocido.";
    }

    elemento.classList.remove("success");
    elemento.classList.add("error");
    elemento.focus();
}

//validar borrar error
function borrarError() {
    let formulario = document.forms[0];
    for (let i = 0; i < formulario.elements.length; i++) {
        formulario.elements[i].classList.remove("error");
        formulario.elements[i].classList.remove("success");
    }
    document.getElementById("error").innerHTML = "";
}

//para ver la contraseña introducida

function alternarContrasena(campoId) {
    const campo = document.getElementById(campoId);
    const boton = document.querySelector(`#mostrar_${campoId}`);
    if (campo.type === "password") {
        campo.type = "text";
        boton.textContent = "Ocultar";
    } else {
        campo.type = "password";
        boton.textContent = "Mostrar";
    }
}