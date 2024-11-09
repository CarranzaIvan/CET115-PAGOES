// Arreglo para almacenar los productos del carrito
let carrito = [];

// Función para verificar si el producto está en el carrito
function estaEnCarrito(idServicio) {
    return carrito.some((producto) => producto.id === idServicio);
}

// Función para agregar o quitar un producto del carrito
function toggleCarrito(idServicio, titulo, descripcion, boton) {
    if (estaEnCarrito(idServicio)) {
        // Si ya está en el carrito, quitarlo
        carrito = carrito.filter((producto) => producto.id !== idServicio);
        boton.textContent = "Agregar al carrito";
        boton.classList.remove("btn-danger");
        boton.classList.add("btn-agregar");
        mostrarToast(
            "Producto quitado",
            `${titulo} ha sido quitado del carrito.`,
            "error"
        );
    } else {
        // Si no está en el carrito, agregarlo
        const producto = {
            id: idServicio,
            nombre: titulo,
            descripcion: descripcion,
        };
        carrito.push(producto);
        boton.textContent = "Quitar del carrito";
        boton.classList.remove("btn-agregar");
        boton.classList.add("btn-danger");
        mostrarToast(
            "Producto agregado",
            `${titulo} ha sido agregado al carrito.`,
            "success"
        );
    }

    // Actualizar el contador de productos en el carrito
    actualizarContadorCarrito();

    // Mostrar el carrito en la consola (opcional)
    console.log(carrito);
}

function actualizarContadorCarrito() {
    const contadorCarrito = document.getElementById('contadorCarrito');
    contadorCarrito.textContent = carrito.length; // Actualiza el texto con la cantidad de productos
}

function mostrarToast(titulo, mensaje, tipo) {
    const toastHTML = `
        <div class="toast ${tipo === "success" ? "bg-success text-white" : "bg-danger text-white"}" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header ${tipo === "success" ? "bg-success text-white" : "bg-danger text-white"}">
                <strong class="me-auto">${titulo}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body bg-light">  <!-- Fondo blanco usando bg-light -->
                <p class="text-dark">
                    ${mensaje}
                </p>   
            </div>
        </div>
    `;

    // Agregar el toast al contenedor
    const toastContainer = document.querySelector(".toast-container");
    toastContainer.innerHTML += toastHTML;

    // Inicializar el toast y mostrarlo
    const toast = new bootstrap.Toast(toastContainer.lastElementChild);
    toast.show();

    // Eliminar el toast después de un tiempo
    setTimeout(() => {
        toastContainer.removeChild(toastContainer.lastElementChild);
    }, 3000); // Duración en milisegundos
}
