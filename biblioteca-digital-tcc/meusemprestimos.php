<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Meus Empréstimos</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/meusemprestimos.css">
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar">
    <h1>Meus Empréstimos</h1>

    <div class="icons">
        <i class="bi bi-house"></i>
        <i class="bi bi-bell"></i>
        <i class="bi bi-person"></i>
    </div>
</nav>

<!-- FILTROS -->
<div class="filter-container">
    <button class="btn active">Todos</button>
    <button class="btn">Devolvidos</button>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<main>

    <!-- CARD TOTAL -->
    <div class="total-card">
        <div>
            <h2>Total de empréstimos</h2>
            <p class="number">1</p>
            <p class="label">Livro emprestado</p>
        </div>
        <i class="bi bi-book icon-big"></i>
    </div>

    <!-- CARD DO LIVRO -->
    <div class="loan-card">
        <img src="https://m.media-amazon.com/images/I/81lRWMvYpKL._AC_UF1000,1000_QL80_.jpg" alt="Capa do livro">

        <div class="info">
            <h3>O Cortiço</h3>
            <p><strong>Autor:</strong> Aluísio de Azevedo</p>
            <p><strong>Data do empréstimo:</strong> 01/08/2025</p>
            <p><strong>Data de devolução:</strong> 01/09/2025</p>
        </div>
    </div>

    <!-- CARD INFORMAÇÕES -->
    <div class="info-card">
        <h3><i class="bi bi-info-circle"></i> Informações da Biblioteca</h3>
        <p>🕒 Segunda a sexta, horário dos intervalos</p>
        <p>📚 Prazo de empréstimo: 1 mês</p>
    </div>

</main>

</body>
</html>
