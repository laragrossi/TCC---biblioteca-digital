<?php
session_start();
include "conexaoconsulta.php";

// Verificar login
if (!isset($_SESSION['ProfID'])) {
    header("Location: loginprof.php");
    exit();
}

// Buscar dados do professor
$professor_id = $_SESSION['ProfID'];
$sql_professor = "SELECT nome, email FROM professor WHERE id = ?";
$stmt_professor = $conexao->prepare($sql_professor);
$stmt_professor->bind_param("i", $professor_id);
$stmt_professor->execute();
$result_professor = $stmt_professor->get_result();
$professor = $result_professor->fetch_assoc();

// Buscar empréstimos ativos
$sql_emprestimos = "SELECT e.RA_Aluno, e.IDLivro, e.DataEmprestimo, e.DataDevolucaoPrevista, 
                           a.nome as nome_aluno, a.serie, a.turma,
                           l.titulo as titulo_livro,
                           CASE 
                               WHEN e.DataDevolucaoPrevista < CURDATE() THEN 'em-atraso'
                               ELSE 'em-andamento'
                           END as status
                    FROM emprestimo e
                    INNER JOIN aluno a ON e.RA_Aluno = a.ra_completo
                    INNER JOIN livros l ON e.IDLivro = l.id
                    WHERE e.Status = 'Ativo'
                    ORDER BY e.DataDevolucaoPrevista ASC";
$result_emprestimos = $conexao->query($sql_emprestimos);
$emprestimos = $result_emprestimos->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Empréstimos Ativos</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/emprestimoprof.css">

</head>
<body>

<header>
    <h1>Empréstimos ativos</h1>

    <div class="icons" style="position: relative; display:flex; gap:15px; align-items:center;">

        <!-- HOME -->
        <a href="homeprof.php" class="icon-link">
            <i class="bi bi-house-door-fill" title="Início"></i>
        </a>

        <!-- PERFIL -->
        <i class="bi bi-person-fill" id="user-icon" title="Usuário" style="cursor:pointer;"></i>

        <!-- MENU DO USUÁRIO -->
        <div id="user-menu"
             style="
                display:none;
                position:absolute;
                top:40px;
                right:0;
                width:220px;
                background:#f8c7b1;
                padding:10px;
                border-radius:10px;
                box-shadow:0 4px 8px rgba(0,0,0,0.2);">

            <div style="font-weight:bold; margin-bottom:5px; border-bottom:1px solid #0003; padding-bottom:5px;">
                Usuário
            </div>

            <div style="background:#ffe4d6; padding:8px; border-radius:5px; font-size:14px;">
                <p><strong>Nome:</strong> <?= htmlspecialchars($professor['nome']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($professor['email']) ?></p>
                <hr>
                <a href="dadosprof.php">Perfil</a><br><br>
                <a href="logout.php">Sair</a>
            </div>
        </div>

    </div>
</header>

<div class="search-container">
    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Procurar alunos" id="searchInput">
    </div>
</div>

<!-- BOTÕES DE FILTRO -->
<div class="filter-buttons">
    <button class="filter-btn active" onclick="filterEmprestimos('todos')">Todos</button>
    <button class="custom-btn" onclick="window.location.href='atrasadosprof.php'">Atrasados</button>
</div>

<div class="cards" id="emprestimosContainer">
    <?php if (empty($emprestimos)): ?>
        <div style="text-align: center; padding: 40px; color: #666;">
            <i class="bi bi-inbox" style="font-size: 48px; margin-bottom: 15px;"></i>
            <p>Nenhum empréstimo ativo no momento</p>
        </div>
    <?php else: ?>
        <?php foreach ($emprestimos as $emp): ?>
            <div class="card" data-aluno="<?= strtolower($emp['nome_aluno']) ?>" data-status="<?= $emp['status'] ?>">
                <h3><?= htmlspecialchars($emp['nome_aluno']) ?></h3>
                <p>RA: <?= htmlspecialchars($emp['RA_Aluno']) ?></p>
                <p>Turma: <?= htmlspecialchars($emp['serie']) ?> <?= htmlspecialchars($emp['turma']) ?></p>
                <p>Livro: <?= htmlspecialchars($emp['titulo_livro']) ?></p>
                <span class="status <?= $emp['status'] ?>">
                    <?= $emp['status'] == 'em-atraso' ? 'Em atraso' : 'Em andamento' ?>
                </span>
                <p>Empréstimo: <?= date('d/m/Y', strtotime($emp['DataEmprestimo'])) ?></p>
                <p>Devolução: <?= date('d/m/Y', strtotime($emp['DataDevolucaoPrevista'])) ?></p>
                
                <?php if ($emp['status'] == 'em-atraso'): ?>
                    <div style="color: #dc3545; font-weight: bold; margin-top: 8px;">
                         Atraso: <?= floor((time() - strtotime($emp['DataDevolucaoPrevista'])) / (60 * 60 * 24)) ?> dias
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
// MENU DO USUÁRIO
const userIcon = document.getElementById('user-icon');
const userMenu = document.getElementById('user-menu');

userIcon.addEventListener('click', () => {
    userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
});

// Fechar ao clicar fora
document.addEventListener('click', (e) => {
    if (!userMenu.contains(e.target) && e.target !== userIcon) {
        userMenu.style.display = 'none';
    }
});

// Busca em tempo real
document.getElementById('searchInput').addEventListener('input', function() {
    const term = this.value.toLowerCase();
    const cards = document.querySelectorAll('.card');

    cards.forEach(card => {
        const aluno = card.dataset.aluno;
        card.style.display = aluno.includes(term) ? 'block' : 'none';
    });
});

// Filtro
function filterEmprestimos(status) {
    const cards = document.querySelectorAll('.card');

    cards.forEach(card => {
        card.style.display =
            status === 'todos' || card.dataset.status === status
            ? 'block'
            : 'none';
    });
}
</script>

</body>
</html>
