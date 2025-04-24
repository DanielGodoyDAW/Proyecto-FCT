function mostrarRecuperar() {
    const login = document.getElementById("login");
    const recuperar = document.getElementById("recuperar");
    login.style.display = "none";
    recuperar.style.display = "block";
}

function mostrarInicio() {
    const login = document.getElementById("login");
    const recuperar = document.getElementById("recuperar");

    login.style.display = "block";
    recuperar.style.display = "none";
}