function filtrar(tipo) {
    const cards = document.querySelectorAll(".card-livro");
    let totalVisiveis = 0;

    cards.forEach(card => {
        const status = card.getAttribute("data-status");

        if (tipo === "todos") {
            if (status === "emprestado") {
                card.style.display = "block";  // mostra apenas emprestados
                totalVisiveis++;
            } else {
                card.style.display = "none";   // esconde os devolvidos
            }
        } else if (tipo === "devolvidos") {
            if (status === "devolvido") {
                card.style.display = "block";  // mostra apenas devolvidos
                totalVisiveis++;
            } else {
                card.style.display = "none";   // esconde os emprestados
            }
        }
    });

    document.getElementById("total-emprestimos").textContent = totalVisiveis;
}
