<?php
session_start();
include "conexaoconsulta.php"; 

// Verifica se o aluno está logado
if (!isset($_SESSION['AlunoID'])) {
    header("Location: loginaluno.php");
    exit();
}

$ra = $_SESSION['RA'];

// Busca os livros devolvidos do aluno no banco de dados
$sql = "SELECT e.DataEmprestimo, e.DataDevolucaoReal, l.titulo, l.autor, l.foto 
        FROM emprestimo e
        INNER JOIN livros l ON e.IDLivro = l.id
        WHERE e.RA_Aluno = ? AND e.Status = 'Devolvido'
        ORDER BY e.DataDevolucaoReal DESC";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $ra);
$stmt->execute();
$result = $stmt->get_result();
$livros_devolvidos = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Livros Devolvidos</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/meusemprestimos.css">
</head>

<body>

<!-- NAVBAR  -->
<header>
    <h1>Biblioteca</h1>

    <div class="icons">

        <!-- Home -->
        <a href="homealuno.php" class="icon-link">
            <i class="bi bi-house-door-fill" title="Início"></i>
        </a>

        <!-- Usuário -->
        <a href="dadosaluno.php" class="icon-link">
            <i class="bi bi-person-fill" title="Perfil"></i>
        </a>

    </div>
</header>

<!-- FILTROS -->
<div class="filter-container">
    <a href="meusemprestimos.php" class="btn">Todos</a>
    <a href="devolvidos.php" class="btn active">Devolvidos</a>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<main>

    <!-- CARD TOTAL -->
    <div class="total-card">
        <div>
            <h2>Livros devolvidos</h2>
            <p class="number"><?= count($livros_devolvidos) ?></p>
            <p class="label">Devolvidos ao todo</p>
        </div>
        <i class="bi bi-check2-square icon-big"></i>
    </div>

    <!-- LISTA DE LIVROS DEVOLVIDOS -->
    <?php if (empty($livros_devolvidos)): ?>
        <div style="text-align:center; margin-top:40px; font-size:18px; color:#555;">
            Nenhum livro devolvido ainda.
        </div>
    <?php else: ?>
        <?php foreach ($livros_devolvidos as $livro): ?>
        <div class="loan-card">
            <img src="<?= !empty($livro['foto']) ? htmlspecialchars($livro['foto']) : 'https://via.placeholder.com/120x170?text=Sem+Capa' ?>" alt="Capa do livro">

            <div class="info">
                <h3><?= htmlspecialchars($livro['titulo']) ?></h3>
                <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
                <p><strong>Data do empréstimo:</strong> <?= date('d/m/Y', strtotime($livro['DataEmprestimo'])) ?></p>
                <p><strong>Data da devolução:</strong> <?= date('d/m/Y', strtotime($livro['DataDevolucaoReal'])) ?></p>
                <p style="color:green; font-weight:bold; margin-top:5px;">
                    ✔ Livro devolvido
                </p>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- CARD INFORMAÇÕES -->
    <div class="info-card">
        <h3><i class="bi bi-info-circle"></i> Informações da Biblioteca</h3>
        <p>🕒 Segunda a sexta, horário dos intervalos</p>
        <p>📚 Prazo de empréstimo: 1 mês</p>
    </div>

</main>

</body>
</html>
