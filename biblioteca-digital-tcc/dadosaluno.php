<?php
session_start(); // Inicia a sessão para acessar variáveis de login
include "conexaoconsulta.php"; // Conexão com o banco de dados

// Verifica se o aluno está logado
if (!isset($_SESSION['AlunoID'])) {
    header("Location: loginaluno.php"); // Se não tiver sessão, volta para login
    exit();
}

// Buscar dados do aluno logado
$aluno_id = $_SESSION['AlunoID'];
$sql = "SELECT * FROM aluno WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $aluno_id); // "i" significa inteiro
$stmt->execute();
$result = $stmt->get_result();
$aluno = $result->fetch_assoc(); // Armazena os dados do aluno

// Caso o ID não exista no banco
if (!$aluno) {
    die("Aluno não encontrado.");
}

// Buscar notificação: empréstimos atrasados
$sql_notificacoes = "SELECT l.titulo, e.DataDevolucaoPrevista 
                     FROM emprestimo e 
                     INNER JOIN livros l ON e.IDLivro = l.id 
                     WHERE e.RA_Aluno = ? 
                     AND e.DataDevolucaoPrevista < CURDATE()  -- Se está atrasado
                     AND e.Status = 'Ativo' 
                     LIMIT 1"; // Traz apenas 1 notificação

$stmt_notificacoes = $conexao->prepare($sql_notificacoes);
$stmt_notificacoes->bind_param("s", $_SESSION['RA']); // RA do aluno
$stmt_notificacoes->execute();
$result_notificacoes = $stmt_notificacoes->get_result();
$notificacao = $result_notificacoes->fetch_assoc(); // Notificação (se existir)
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

        <!-- Notificações -->
        <i class="bi bi-bell-fill" id="notification-btn" title="Notificações"></i>

        <!-- Caixa de Notificações -->
        <div class="notification-box" id="notification-box">
            <div class="notification-title">Notificações</div>
            <div class="notification-content">
                <?php if ($notificacao): ?>
                    ⚠️ Empréstimo em atraso<br>
                    Livro: <?= htmlspecialchars($notificacao['titulo']) ?><br>
                    Data: <?= date('d/m/Y', strtotime($notificacao['DataDevolucaoPrevista'])) ?>
                <?php else: ?>
                    Nenhuma notificação<br>
                    Todos os empréstimos em dia!
                <?php endif; ?>
            </div>
        </div>

        <!-- Usuário -->
        <i class="bi bi-person-fill" id="user-icon" title="Perfil"></i>

        <!-- Menu do Usuário -->
        <div class="notification-box" id="user-menu" style="width:220px;">
            <div class="notification-content">
                <hr>
                <a href="dadosalunos.php" class="btn-logout">Perfil</a>
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


<!-- JavaScript para abrir/fechar menus -->
<script>
    const notificationBtn = document.getElementById("notification-btn");
    const notificationBox = document.getElementById("notification-box");
    const userIcon = document.getElementById("user-icon");
    const userMenu = document.getElementById("user-menu");

    function closeAll() {
        notificationBox.style.display = "none";
        userMenu.style.display = "none";
    }

    notificationBtn.addEventListener("click", () => {
        const isOpen = notificationBox.style.display === "block";
        closeAll();
        notificationBox.style.display = isOpen ? "none" : "block";
    });

    userIcon.addEventListener("click", () => {
        const isOpen = userMenu.style.display === "block";
        closeAll();
        userMenu.style.display = isOpen ? "none" : "block";
    });

    document.addEventListener("click", (e) => {
        if (
            !notificationBtn.contains(e.target) &&
            !notificationBox.contains(e.target) &&
            !userIcon.contains(e.target) &&
            !userMenu.contains(e.target)
        ) {
            closeAll();
        }
    });
</script>

</body>
</html>
