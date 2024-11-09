document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btnEditarServicio").forEach((button) => {
        button.addEventListener("click", function () {
            const idServicio = this.getAttribute("data-id");

            // Obtener los datos del servicio desde los elementos de la tarjeta
            const servicio = {
                titulo: document.querySelector(`#titulo-${idServicio}`)
                    .innerText,
                precio: document
                    .querySelector(`#precio-${idServicio}`)
                    .innerText.replace("$", "")
                    .trim(),
                descripcion: document.querySelector(
                    `#descripcion-${idServicio}`
                ).innerText,
            };

            // Llenar los campos del formulario de edición con los datos del servicio
            document.getElementById("editarTitulo").value = servicio.titulo;
            document.getElementById("editarPrecio").value = servicio.precio;
            document.getElementById("editarDescripcion").value =
                servicio.descripcion;

            // Cambiar la acción del formulario para enviar la actualización del servicio
            document.getElementById(
                "editarServicioForm"
            ).action = `/servicios/gestion/${idServicio}/actualizar`;

            // Mostrar el modal de edición
            const editarModal = new bootstrap.Modal(
                document.getElementById("editarServicioModal")
            );
            editarModal.show();
        });
    });

    // Seleccionamos todos los formularios de eliminar
    const deleteForms = document.querySelectorAll('form[action*="/eliminar"]');

    deleteForms.forEach((form) => {
        form.addEventListener("submit", function (event) {
            event.preventDefault(); // Evitamos que el formulario se envíe automáticamente

            // Mostramos el modal de confirmación
            const confirmModal = new bootstrap.Modal(
                document.getElementById("confirmDeleteModal")
            );
            confirmModal.show();

            // Obtenemos el botón de confirmación en el modal
            const confirmButton = document.getElementById(
                "confirmDeleteButton"
            );

            // Limpiamos cualquier listener previo para evitar múltiples confirmaciones
            confirmButton.replaceWith(confirmButton.cloneNode(true)); // Reemplazamos el botón para eliminar los listeners previos
            const newConfirmButton = document.getElementById(
                "confirmDeleteButton"
            );

            // Cuando el usuario confirma, se envía el formulario
            newConfirmButton.addEventListener("click", function () {
                form.submit(); // Enviamos el formulario de eliminación después de confirmar
            });
        });
    });

    // Validación del formulario de "Crear Nuevo Servicio"
    const nuevoServicioForm = document.getElementById("nuevoServicioForm");
    nuevoServicioForm.addEventListener("submit", function (event) {
        if (!nuevoServicioForm.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        nuevoServicioForm.classList.add("was-validated");
    });

    // Validación del formulario de "Editar Servicio"
    const editarServicioForm = document.getElementById("editarServicioForm");
    editarServicioForm.addEventListener("submit", function (event) {
        if (!editarServicioForm.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        editarServicioForm.classList.add("was-validated");
    });
});
