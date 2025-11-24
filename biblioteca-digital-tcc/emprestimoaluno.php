<?php
session_start();
include "conexaoconsulta.php";

// Verificar se o aluno está logado
if (!isset($_SESSION['AlunoID'])) {
    header("Location: loginaluno.php");
    exit();
}

// Buscar dados do aluno
$aluno_id = $_SESSION['AlunoID'];
$ra_aluno = $_SESSION['RA'];

// Buscar empréstimos ativos do aluno
$sql_emprestimos = "SELECT e.IDEmprestimo, e.DataEmprestimo, e.DataDevolucaoPrevista, e.Status,
                           l.titulo, l.autor, l.foto, l.id as livro_id
                    FROM emprestimo e
                    INNER JOIN livros l ON e.IDLivro = l.id
                    WHERE e.RA_Aluno = ? 
                    ORDER BY e.DataEmprestimo DESC";
$stmt_emprestimos = $conexao->prepare($sql_emprestimos);
$stmt_emprestimos->bind_param("s", $ra_aluno);
$stmt_emprestimos->execute();
$result_emprestimos = $stmt_emprestimos->get_result();
$emprestimos = $result_emprestimos->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Meus Empréstimos</title>

<!-- Importando ícones do Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/emprestimoaluno.css">

</head>
<body>

<header>
    <h1>Meus Empréstimos</h1>
    <div class="icons">
        <a href="homealuno.php"><i class="bi bi-house-door" title="Início"></i></a>
        <a href="dadosaluno.php"><i class="bi bi-person" title="Perfil"></i></a>
    </div>
</header>

<div class="search-container">
    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Procurar meus livros" id="searchInput">
    </div>
</div>

<div class="filter-buttons">
    <button class="filter-btn active" onclick="filterEmprestimos('todos')">Todos</button>
    <button class="filter-btn" onclick="filterEmprestimos('Ativo')">Ativos</button>
    <button class="filter-btn" onclick="filterEmprestimos('Devolvido')">Concluídos</button>
</div>

<div class="cards" id="emprestimosContainer">
    <?php if (empty($emprestimos)): ?>
        <div style="text-align: center; padding: 40px; color: #666; grid-column: 1 / -1;">
            <i class="bi bi-inbox" style="font-size: 48px; margin-bottom: 15px;"></i>
            <p>Você não possui empréstimos no momento</p>
            <a href="pesquisar_livros.php" style="color: #007bff; text-decoration: none;">
                 Buscar livros para empréstimo
            </a>
        </div>
    <?php else: ?>
        <?php foreach ($emprestimos as $emp): ?>
            <div class="card" data-livro="<?= strtolower($emp['titulo']) ?>" data-status="<?= $emp['Status'] ?>">
                <!-- FOTO DO LIVRO -->
                <div style="text-align: center; margin-bottom: 15px;">
                    <?php if (!empty($emp['foto'])): ?>
                        <img src="<?= $emp['foto'] ?>" 
                             alt="<?= htmlspecialchars($emp['titulo']) ?>" 
                             style="width: 80px; height: 110px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                    <?php else: ?>
                        <div style="width: 80px; height: 110px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 8px; margin: 0 auto;">
                            <i class="bi bi-book" style="font-size: 24px; color: #6c757d;"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <h3><?= htmlspecialchars($emp['titulo']) ?></h3>
                <p><strong>Autor:</strong> <?= htmlspecialchars($emp['autor']) ?></p>
                
                <!-- STATUS DO EMPRÉSTIMO -->
                <?php if ($emp['Status'] == 'Ativo'): ?>
                    <span class="status em-andamento">Em andamento</span>
                    <p><strong>Empréstimo:</strong> <?= date('d/m/Y', strtotime($emp['DataEmprestimo'])) ?></p>
                    <p><strong>Devolução:</strong> <?= date('d/m/Y', strtotime($emp['DataDevolucaoPrevista'])) ?></p>
                    
                    <?php 
                    $dias_restantes = floor((strtotime($emp['DataDevolucaoPrevista']) - time()) / (60 * 60 * 24));
                    if ($dias_restantes < 0): ?>
                        <div style="color: #dc3545; font-weight: bold; margin-top: 8px;">
                            ⚠️ Atraso: <?= abs($dias_restantes) ?> dias
                        </div>
                    <?php elseif ($dias_restantes <= 3): ?>
                        <div style="color: #ffc107; font-weight: bold; margin-top: 8px;">
                            ⏳ Faltam <?= $dias_restantes ?> dias
                        </div>
                    <?php else: ?>
                        <div style="color: #28a745; font-weight: bold; margin-top: 8px;">
                            ✅ <?= $dias_restantes ?> dias restantes
                        </div>
                    <?php endif; ?>
                    
                <?php else: ?>
                    <span class="status concluido">Concluído</span>
                    <p><strong>Empréstimo:</strong> <?= date('d/m/Y', strtotime($emp['DataEmprestimo'])) ?></p>
                    <p><strong>Devolvido em:</strong> <?= date('d/m/Y', strtotime($emp['DataDevolucaoPrevista'])) ?></p>
                <?php endif; ?>
                
                <!-- BOTÃO PARA VER DETALHES DO LIVRO -->
                <a href="detalhes_livros.php?id=<?= $emp['livro_id'] ?>" 
                   style="display: inline-block; margin-top: 10px; color: #007bff; text-decoration: none;">
                    📖 Ver detalhes do livro
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
// Busca em tempo real
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const cards = document.getElementById('emprestimosContainer').getElementsByClassName('card');
    
    Array.from(cards).forEach(card => {
        const livroNome = card.getAttribute('data-livro');
        if (livroNome.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Filtro de empréstimos
function filterEmprestimos(status) {
    const cards = document.getElementById('emprestimosContainer').getElementsByClassName('card');
    const botoes = document.querySelectorAll('.filter-btn');
    
    // Atualiza botões ativos
    botoes.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Filtra os cards
    Array.from(cards).forEach(card => {
        if (status === 'todos' || card.getAttribute('data-status') === status) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
</body>
</html>