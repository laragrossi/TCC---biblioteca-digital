<?php
session_start();
include "conexaoconsulta.php";

// Verifica se o aluno está logado
if (!isset($_SESSION['AlunoID'])) {
    header("Location: loginaluno.php");
    exit();
}

// Buscar dados do aluno logado
$aluno_id = $_SESSION['AlunoID'];
$sql = "SELECT * FROM aluno WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$result = $stmt->get_result();
$aluno = $result->fetch_assoc();

if (!$aluno) {
    die("Aluno não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados Cadastrados - Biblioteca Digital</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/dadosalunos.css">
</head>

<body>

<header>
    <h1>Dados cadastrados</h1>

    <div class="icons">

        <!-- Home -->
        <a href="homealuno.php" class="icon-link">
            <i class="bi bi-house-door-fill" title="Início"></i>
        </a>

        <!-- Usuário -->
        <i class="bi bi-person-fill" id="user-icon" title="Perfil"></i>

        <!-- Menu do Usuário -->
        <div class="notification-box" id="user-menu" style="width:220px;">
            <div class="notification-content">
                <hr>
                <a href="logoutaluno.php" class="btn-logout">Sair</a>
            </div>
        </div>

    </div>
</header>


<div class="info-card">
    <div class="icon-area">
        <i class="bi bi-person-circle"></i>
    </div>

    <div class="text-area">
        <h2 class="section-title">Dados do aluno</h2>
        <p><strong>Nome:</strong> <?= htmlspecialchars($aluno['nome']) ?></p>
        <p><strong>RA:</strong> <?= htmlspecialchars($aluno['ra_completo']) ?></p>

        <?php if (!empty($aluno['serie'])): ?>
            <p><strong>Série:</strong> <?= htmlspecialchars($aluno['serie']) ?></p>
        <?php endif; ?>

        <?php if (!empty($aluno['turma'])): ?>
            <p><strong>Turma:</strong> <?= htmlspecialchars($aluno['turma']) ?></p>
        <?php endif; ?>

        <h2 class="section-title mt-3">Dados da escola</h2>
        <p><strong>Escola:</strong> <?= htmlspecialchars($aluno['escola']) ?></p>
        <p class="ano-letivo"><strong>Ano letivo:</strong></p>
        <p>2025</p>
    </div>
</div>

<center>Última atualização: <?= date('d \d\e F \d\e Y', strtotime($aluno['created_at'])) ?></center>


<!-- JavaScript apenas para abrir/fechar o menu do usuário -->
<script>
    const userIcon = document.getElementById("user-icon");
    const userMenu = document.getElementById("user-menu");

    function closeAll() {
        userMenu.style.display = "none";
    }

    userIcon.addEventListener("click", () => {
        const isOpen = userMenu.style.display === "block";
        closeAll();
        userMenu.style.display = isOpen ? "none" : "block";
    });

    document.addEventListener("click", (e) => {
        if (!userIcon.contains(e.target) && !userMenu.contains(e.target)) {
            closeAll();
        }
    });
</script>

</body>
</html>
