document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".submenu-link");
    const sections = document.querySelectorAll(".seccion");

    links.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            // Quitar la clase activa de todos los enlaces
            links.forEach(l => l.classList.remove("active"));

            // Ocultar todas las secciones
            sections.forEach(section => section.style.display = "none");

            // Mostrar la sección correspondiente
            const target = document.querySelector(this.getAttribute("href"));
            target.style.display = "block";

            // Añadir la clase activa al enlace actual
            this.classList.add("active");
        });
    });
});