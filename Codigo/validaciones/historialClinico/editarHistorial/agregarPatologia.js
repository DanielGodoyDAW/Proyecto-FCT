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

        const nuevoInput = document.createElement("input");
        nuevoInput.type = "text";
        nuevoInput.name = "patologias[]";
        nuevoInput.placeholder = "Escriba nueva patología";
        nuevoInput.style.width = "50%";

        celdaInput.appendChild(nuevoInput);
        nuevaFila.appendChild(celdaInput);

        // Buscar última fila que contenga checkbox de patologías
        const filas = tabla.querySelectorAll("tr");
        let ultimaFilaPatologias = null;

        filas.forEach((fila) => {
            if (fila.innerHTML.includes('name="patologias[]"')) {
                ultimaFilaPatologias = fila;
            }
        });

        if (ultimaFilaPatologias) {
            // Insertar después de la última fila con checkbox
            if (ultimaFilaPatologias.nextSibling) {
                ultimaFilaPatologias.parentNode.insertBefore(nuevaFila, ultimaFilaPatologias.nextSibling);
            } else {
                ultimaFilaPatologias.parentNode.appendChild(nuevaFila);
            }
        } else {
            tabla.appendChild(nuevaFila);
        }
    });
});

//funcion para eliminar la patologia
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("eliminar-patologia")) {
        e.preventDefault();

        const container = e.target.closest("tr");
        if (container) {
            container.remove();
        }
    }
});

