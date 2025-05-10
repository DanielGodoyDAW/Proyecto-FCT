document.addEventListener("DOMContentLoaded", function () {
    const agregarPatologiaBtn = document.getElementById("agregarPatologia"); // Botón para agregar patología
    const tabla = document.getElementById("tabla_historial_clinico"); // Tabla donde se agregarán las patologías

    if (!agregarPatologiaBtn || !tabla) { // Verifica si el botón y la tabla existen
        console.warn("No se encontró el botón o la tabla");
        return;
    }

    agregarPatologiaBtn.addEventListener("click", function (e) {
        e.preventDefault();

        const nuevaFila = document.createElement("tr"); // Crea una nueva fila para la tabla

        const celdaVacia = document.createElement("td"); // Crea una celda vacía
        nuevaFila.appendChild(celdaVacia);

        const celdaInput = document.createElement("td"); // Crea una celda para el input
        celdaInput.colSpan = 3; // Colspan para que ocupe varias columnas

        const nuevoInput = document.createElement("input"); // Crea un nuevo input
        nuevoInput.type = "text"; // Tipo de input
        nuevoInput.name = "patologias[]"; // Nombre del input
        nuevoInput.placeholder = "Escriba nueva patología"; // Placeholder para el input
        nuevoInput.style.width = "50%"; // Ancho del input

        celdaInput.appendChild(nuevoInput); // Agrega el input a la celda
        nuevaFila.appendChild(celdaInput); // Agrega la celda con el input a la fila
        // Buscar última fila que contenga checkbox de patologías
        const filas = tabla.querySelectorAll("tr");
        let ultimaFilaPatologias = null;

        filas.forEach((fila) => {
            if (fila.innerHTML.includes('name="patologias[]"')) { // Verifica si la fila contiene un checkbox de patologías
                ultimaFilaPatologias = fila; // Actualiza la última fila encontrada
            }
        });

        if (ultimaFilaPatologias) {  // Si se encontró una fila con checkbox
            // Insertar después de la última fila con checkbox
            if (ultimaFilaPatologias.nextSibling) { // Si hay una fila siguiente
                ultimaFilaPatologias.parentNode.insertBefore(nuevaFila, ultimaFilaPatologias.nextSibling); // Inserta la nueva fila antes de la siguiente
            } else { // Si no hay fila siguiente
                ultimaFilaPatologias.parentNode.appendChild(nuevaFila); // Agrega la nueva fila al final
            }
        } else { // Si no se encontró ninguna fila con checkbox
            tabla.appendChild(nuevaFila); // Agrega la nueva fila al final de la tabla
        }
    });
});

//funcion para eliminar la patologia
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("eliminar-patologia")) { // Verifica si el clic fue en un botón de eliminar patología
        e.preventDefault();

        const container = e.target.closest("tr"); // Busca el contenedor más cercano (la fila de la tabla)
        if (container) { // Si se encontró el contenedor
            container.remove(); // Elimina la fila de la tabla
        }
    }
});

