<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Empréstimos Ativos</title>

<!-- Importando ícones do Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/emprestimoaluno.css">

</head>
<body>

<header>
    <h1>Empréstimos ativos</h1>
    <div class="icons">
        <a href="homealuno.php"><i class="bi bi-house-door"></i></a>
        <i class="bi bi-bell"></i>
        <a href="dadosaluno.php"><i class="bi bi-person"></i></a>
    </div>
</header>

<div class="search-container">
    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Procurar alunos">
    </div>
</div>

<div class="filter-buttons">
    <button class="filter-btn active">Todos</button>
    <a href="atrasadosaluno.php" class="filter-btn disabled">Atrasados</a>
</div>

<div class="cards">
    <div class="card">
        <h3>Nome do aluno</h3>
        <p>RA: XXXXXXXXXX-X</p>
        <p>Turma: 3ºDS</p>
        <p>Livro: O Cortiço</p>
        <span class="status em-andamento">Concluído</span>
        <p>Devolução: xx/xx/xxxx</p>
    </div>

    <div class="card">
        <h3>Nome do aluno</h3>
        <p>RA: XXXXXXXXXX-X</p>
        <p>Turma: 3ºDS</p>
        <p>Livro: O Cortiço</p>
        <span class="status em-atraso">Em atraso</span>
        <p>Empréstimo: xx/xx/xxxx</p>
        <p>Devolução: xx/xx/xxxx</p>
    </div>

    <div class="card">
        <h3>Nome do aluno</h3>
        <p>RA: XXXXXXXXXX-X</p>
        <p>Turma: 3ºDS</p>
        <p>Livro: O Cortiço</p>
        <span class="status em-andamento">Concluído</span>
        <p>Devolução: xx/xx/xxxx</p>
    </div>

    <div class="card">
        <h3>Nome do aluno</h3>
        <p>RA: XXXXXXXXXX-X</p>
        <p>Turma: 3ºDS</p>
        <p>Livro: O Cortiço</p>
        <span class="status em-andamento">Concluído</span>
        <p>Devolução: xx/xx/xxxx</p>
    </div>
</div>

</body>
</html>