// Filtro en tiempo real para el campo de búsqueda
document.getElementById("searchInput").addEventListener("keyup", function () {
    let query = this.value.toLowerCase();
    let words = query.split(" "); // Divide la consulta en palabras
    let items = document.querySelectorAll(".question-item");

    items.forEach((item) => {
        // Verifica si alguna de las palabras está en la pregunta o la respuesta
        let questionText = item.querySelector("h4").textContent.toLowerCase();
        let answerText = item.querySelector("h5").textContent.toLowerCase();

        // Cambiado de every a some
        let matchFound = words.some((word) => {
            return questionText.includes(word) || answerText.includes(word);
        });

        if (matchFound) {
            item.style.display = "block";
        } else {
            item.style.display = "none";
        }
    });
});
