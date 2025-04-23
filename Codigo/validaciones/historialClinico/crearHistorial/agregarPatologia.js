document.addEventListener("DOMContentLoaded", function () {
    const agregarPatologiaBtn = document.getElementById("agregarPatologia");
    const tabla = document.getElementById("tabla_historial_clinico");

    agregarPatologiaBtn.addEventListener("click", function (e) {
        e.preventDefault(); // Evita que el botón recargue la página

        // Determina la posición donde insertar (después de las patologías existentes)
        const posicion = 8; // Índice de la fila donde se insertará la nueva fila (empieza en 0)

        // Crear una nueva fila
        const nuevaFila = tabla.insertRow(posicion);

        // // Crear una celda para el checkbox
        // const celdaCheckbox = nuevaFila.insertCell(0);
        // const nuevoCheckbox = document.createElement("input");
        // nuevoCheckbox.type = "checkbox";
        // nuevoCheckbox.name = "patologias[]";
        // nuevoCheckbox.value = ""; // El valor se puede ajustar dinámicamente
        // celdaCheckbox.appendChild(nuevoCheckbox);

        // Crear una celda para el texto
        const celdaTexto = nuevaFila.insertCell(0);
        const nuevoTexto = document.createElement("input");
        nuevoTexto.type = "text";
        nuevoTexto.placeholder = "Nueva patología";
        nuevoTexto.name = "patologias[]";
        nuevoTexto.style.width = "100%"; 
        celdaTexto.appendChild(nuevoTexto);
    });
});