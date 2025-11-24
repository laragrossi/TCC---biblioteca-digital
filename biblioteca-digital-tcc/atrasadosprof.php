<?php
session_start();
include "conexaoconsulta.php";

// Verifica login
if (!isset($_SESSION['ProfID'])) {
    header("Location: loginprof.php");
    exit();
}

// Dados do professor
$professor_id = $_SESSION['ProfID'];
$sql_prof = "SELECT nome, email FROM professor WHERE id = ?";
$stmt = $conexao->prepare($sql_prof);
$stmt->bind_param("i", $professor_id);
$stmt->execute();
$professor = $stmt->get_result()->fetch_assoc();

// Buscar SOMENTE empréstimos atrasados
$sql = "SELECT 
            e.RA_Aluno, e.IDLivro, e.DataEmprestimo, e.DataDevolucaoPrevista, 
            a.nome AS nome_aluno, a.serie, a.turma,
            l.titulo AS titulo_livro
        FROM emprestimo e
        INNER JOIN aluno a ON e.RA_Aluno = a.ra_completo
        INNER JOIN livros l ON e.IDLivro = l.id
        WHERE e.Status = 'Ativo'
          AND e.DataDevolucaoPrevista < CURDATE()
        ORDER BY e.DataDevolucaoPrevista ASC";

$result = $conexao->query($sql);
$emprestimos = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Empréstimos Atrasados</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/atrasadosprof.css">
</head>

<body>

<!-- CABEÇALHO -->
<header>
    <h1>Empréstimos ativos</h1>

    <div class="icons" style="position: relative; display:flex; gap:15px; align-items:center;">

        <!-- HOME -->
        <a href="homeprof.php">
            <i class="bi bi-house-door-fill" title="Início"></i>
        </a>

        <!-- PERFIL -->
        <i class="bi bi-person-fill" id="user-icon" style="cursor:pointer;" title="Usuário"></i>

        <!-- MENU DO USUÁRIO -->
        <div id="user-menu" style="
            display:none;
            position:absolute; top:40px; right:0;
            width:220px; background:#f8c7b1; padding:10px;
            border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.2);">
            
            <div style="font-weight:bold; margin-bottom:5px; border-bottom:1px solid #0003;">
                Usuário
            </div>

            <div style="background:#ffe4d6; padding:8px; border-radius:5px;">
                <p><strong>Nome: </strong><?= $professor['nome'] ?></p>
                <p><strong>Email: </strong><?= $professor['email'] ?></p>
                <hr>
                <a href="dadosprof.php">Perfil</a><br><br>
                <a href="logout.php">Sair</a>
            </div>
        </div>

    </div>
</header>

<!-- BARRA DE PESQUISA -->
<div class="search-container">
    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" id="searchInput" placeholder="Procurar alunos">
    </div>
</div>

<!-- BOTÕES DE FILTRO -->
<div class="filter-buttons">
    <a href="emprestimoprof.php" class="filter-btn">Todos</a>
    <button class="filter-btn active">Atrasados</button>
</div>

<!-- CARDS -->
<div class="cards" id="cardsContainer">

<?php if (empty($emprestimos)): ?>
    <div style="text-align:center; padding:40px; color:#666;">
        <i class="bi bi-inbox" style="font-size:48px;"></i>
        <p>Nenhum empréstimo atrasado</p>
    </div>

<?php else: ?>
    <?php foreach ($emprestimos as $emp): ?>
        <div class="card" data-aluno="<?= strtolower($emp['nome_aluno']) ?>">

            <h3><?= htmlspecialchars($emp['nome_aluno']) ?></h3>
            <p>RA: <?= $emp['RA_Aluno'] ?></p>
            <p>Turma: <?= $emp['serie'] ?> <?= $emp['turma'] ?></p>
            <p>Livro: <?= $emp['titulo_livro'] ?></p>

            <span class="status em-atraso">Em atraso</span>

            <p>Empréstimo: <?= date("d/m/Y", strtotime($emp['DataEmprestimo'])) ?></p>
            <p>Devolução: <?= date("d/m/Y", strtotime($emp['DataDevolucaoPrevista'])) ?></p>

            <div style="color:#dc3545; font-weight:bold; margin-top:8px;">
                ⚠️ Atraso: 
                <?= floor((time() - strtotime($emp['DataDevolucaoPrevista'])) / 86400) ?> dias
            </div>

        </div>
    <?php endforeach; ?>
<?php endif; ?>

</div>

<script>
// Menu usuário
const userIcon = document.getElementById("user-icon");
const userMenu = document.getElementById("user-menu");

userIcon.onclick = () => {
    userMenu.style.display = userMenu.style.display === "block" ? "none" : "block";
};

// Fechar ao clicar fora
document.addEventListener("click", (e) => {
    if (!userMenu.contains(e.target) && e.target !== userIcon) {
        userMenu.style.display = "none";
    }
});

// Busca
document.getElementById("searchInput").addEventListener("input", function() {
    const termo = this.value.toLowerCase();
    const cards = document.querySelectorAll(".card");

    cards.forEach(card => {
        const aluno = card.dataset.aluno;
        card.style.display = aluno.includes(termo) ? "block" : "none";
    });
});
</script>

</body>
</html>
