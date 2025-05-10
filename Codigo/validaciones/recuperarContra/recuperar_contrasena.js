//funcion para mostrar el formulario de recuperar contraseña
function mostrarRecuperar() {
    const login = document.getElementById("login"); // Formulario de inicio de sesión
    const recuperar = document.getElementById("recuperar"); // Formulario de recuperación de contraseña
    login.style.display = "none"; // Oculta el formulario de inicio de sesión
    recuperar.style.display = "block"; // Muestra el formulario de recuperación de contraseña
}

//funcion para mostrar el formulario de inicio de sesion
function mostrarInicio() {
    const login = document.getElementById("login"); // Formulario de inicio de sesión
    const recuperar = document.getElementById("recuperar"); // Formulario de recuperación de contraseña

    login.style.display = "block"; // Muestra el formulario de inicio de sesión
    recuperar.style.display = "none"; // Oculta el formulario de recuperación de contraseña
}