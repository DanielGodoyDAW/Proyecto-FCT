document.addEventListener("DOMContentLoaded", function () {
    const agregarPatologiaBtn = document.getElementById("agregarPatologia");
    const tabla = document.getElementById("tabla_historial_clinico");

    if (!agregarPatologiaBtn || !tabla) {
        console.warn("No se encontró el botón o la tabla");
        return;
    }

    agregarPatologiaBtn.addEventListener("click", function (e) {
        e.preventDefault();

        const nuevaFila = document.createElement("tr");

        const celdaVacia = document.createElement("td");
        nuevaFila.appendChild(celdaVacia);

        const celdaInput = document.createElement("td");
        celdaInput.colSpan = 3;

        const contenedor = document.createElement("div");
        contenedor.classList.add("patologia-input");

        const nuevoInput = document.createElement("input");
        nuevoInput.type = "text";
        nuevoInput.name = "patologias[]";
        nuevoInput.placeholder = "Escriba nueva patología";
        nuevoInput.style.width = "50%";

        const botonEliminar = document.createElement("button");
        botonEliminar.type = "button";
        botonEliminar.classList.add("eliminar-patologia");
        botonEliminar.textContent = "❌";
        botonEliminar.title = "Eliminar";

        contenedor.appendChild(nuevoInput);
        contenedor.appendChild(botonEliminar);
        celdaInput.appendChild(contenedor);
        nuevaFila.appendChild(celdaInput);

        const filaAgregar = document.getElementById("fila-agregar-patologia");
        if (filaAgregar) {
            filaAgregar.parentNode.insertBefore(nuevaFila, filaAgregar);
        } else {
            tabla.appendChild(nuevaFila);
        }
    });
});

document.addEventListener("click", function (e) {
    if (e.target.classList.contains("eliminar-patologia")) {
        e.preventDefault();
        const fila = e.target.closest("tr");
        if (fila) fila.remove();
    }
});
