document.addEventListener("DOMContentLoaded", () => {
    const currentPath = window.location.pathname; // Obtiene la ruta actual
    const navLinks = document.querySelectorAll(".navegacion"); // Selecciona todos los enlaces del menú

    navLinks.forEach(link => {
        if (link.getAttribute("href") === currentPath) {
            link.classList.add("active");
        }
    });
});