//funcion para mostrar el formulario de recuperar contraseña
function mostrarRecuperar() {
    const login = document.getElementById("login");
    const recuperar = document.getElementById("recuperar");
    login.style.display = "none";
    recuperar.style.display = "block";
}

//funcion para mostrar el formulario de inicio de sesion
function mostrarInicio() {
    const login = document.getElementById("login");
    const recuperar = document.getElementById("recuperar");

    login.style.display = "block";
    recuperar.style.display = "none";
}