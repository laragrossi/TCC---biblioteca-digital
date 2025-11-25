<?php
session_start();
include "conexaoconsulta.php";

// Verifica login do professor
if (!isset($_SESSION['ProfID'])) {
    header("Location: loginprof.php");
    exit();
}

// Dados do professor para menu
$professor_id = $_SESSION['ProfID'];
$sql_professor = "SELECT nome, email FROM professor WHERE id = ?";
$stmt_professor = $conexao->prepare($sql_professor);
$stmt_professor->bind_param("i", $professor_id);
$stmt_professor->execute();
$result_professor = $stmt_professor->get_result();
$professor = $result_professor->fetch_assoc();

// Busca alunos cadastrados
$sql_alunos = "SELECT ra_completo, nome, serie, turma FROM aluno ORDER BY nome ASC";
$result_alunos = $conexao->query($sql_alunos);
$alunos = $result_alunos->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Consulta de Alunos Cadastrados</title>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

<!-- CSS externo -->
<link rel="stylesheet" href="css/consulta_alunos.css">

</head>
<body>

<header>
    <h1>Alunos Cadastrados</h1>

    <div class="icons">
        <a href="homeprof.php" class="icon-link" title="Início"><i class="bi bi-house-door-fill"></i></a>
        <i class="bi bi-person-fill" id="user-icon" title="Usuário"></i>

        <div id="user-menu">
            <div><strong>Usuário</strong></div>
            <div><strong>Nome:</strong> <?= htmlspecialchars($professor['nome']) ?></div>
            <div><strong>Email:</strong> <?= htmlspecialchars($professor['email']) ?></div>
            <hr>
            <a href="dadosprof.php">Perfil</a><br>
            <a href="logout.php">Sair</a>
        </div>
    </div>
</header>

<div class="search-container">
    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Procurar alunos pelo nome" id="searchInput" />
    </div>
</div>

<div class="cards" id="alunosContainer">
    <?php if (empty($alunos)): ?>
        <p style="color:#666; font-style: italic;">Nenhum aluno cadastrado.</p>
    <?php else: ?>
        <?php foreach ($alunos as $aluno): ?>
            <div class="card" data-nome="<?= strtolower($aluno['nome']) ?>">
                <h3><?= htmlspecialchars($aluno['nome']) ?></h3>
                <p><strong>RA:</strong> <?= htmlspecialchars($aluno['ra_completo']) ?></p>
                <p><strong>Série:</strong> <?= htmlspecialchars($aluno['serie']) ?></p>
                <p><strong>Turma:</strong> <?= htmlspecialchars($aluno['turma']) ?></p>
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

// Fechar menu ao clicar fora
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
        const nome = card.dataset.nome;
        card.style.display = nome.includes(term) ? 'block' : 'none';
    });
});
</script>

</body>
</html>
