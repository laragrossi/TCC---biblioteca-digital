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
$sql_aluno = "SELECT nome FROM aluno WHERE id = ?";
$stmt_aluno = $conexao->prepare($sql_aluno);
$stmt_aluno->bind_param("i", $aluno_id);
$stmt_aluno->execute();
$result_aluno = $stmt_aluno->get_result();
$aluno = $result_aluno->fetch_assoc();

// Buscar livros em destaque
$sql_livros_destaque = "SELECT id, titulo, autor, foto FROM livros WHERE disponivel = true ORDER BY created_at DESC LIMIT 4";
$result_livros = $conexao->query($sql_livros_destaque);
$livros_destaque = $result_livros->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Digital - Aluno</title>
    
    <!-- Ícones Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/homealuno.css">
</head>
<body>

<header>
    <h1>Biblioteca Digital</h1>

    <div class="icons">

        <!-- Home -->
        <a href="homealuno.php" class="icon-link">
            <i class="bi bi-house-door-fill" title="Início"></i>
        </a>

        <!-- Ícone do usuário -->
        <i class="bi bi-person-fill" id="user-icon" title="Perfil"></i>

        <!-- Menu do usuário -->
        <div class="notification-box" id="user-menu" style="width:220px;">
            <div class="notification-content">
                <hr>
                <a href="dadosaluno.php" class="btn-logout">Perfil</a>
                <a href="logout.php" class="btn-logout">Sair</a>
            </div>
        </div>

    </div>
</header>

<!-- Barra de pesquisa -->
<div class="search-container">
    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Pesquisar livros, autores..." onclick="window.location.href='pesquisar_livros.php'">
    </div>
</div>

<!-- Botões principais -->
<div class="main-buttons">
    <a href="meusemprestimos.php" class="btn"><i class="bi bi-book-half"></i><br>Meus empréstimos</a>
    <a href="dadosaluno.php" class="btn"><i class="bi bi-person-vcard-fill"></i><br>Dados Cadastrais</a>
    <a href="pesquisar_livros.php" class="btn"><i class="bi bi-search"></i><br>Pesquisar Livros</a>
</div>

<!-- Livros em destaque -->
<h2>Livros em Destaque</h2>
<div class="book-list">
<?php if (empty($livros_destaque)): ?>
    <div style="text-align: center; color: #666; grid-column: 1 / -1;">
        <i class="bi bi-book" style="font-size: 48px; margin-bottom: 15px;"></i>
        <p>Nenhum livro disponível no momento</p>
    </div>
<?php else: ?>
    <?php foreach ($livros_destaque as $livro): ?>
        <div class="book" onclick="window.location.href='detalhes_livros.php?id=<?= $livro['id'] ?>'">
            <?php if (!empty($livro['foto'])): ?>
                <img src="<?= $livro['foto'] ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>">
            <?php else: ?>
                <div style="width: 120px; height: 160px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                    <i class="bi bi-book" style="font-size: 24px; color: #6c757d;"></i>
                </div>
            <?php endif; ?>
            <p><?= htmlspecialchars($livro['titulo']) ?></p>
            <p class="author"><?= htmlspecialchars($livro['autor']) ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>

<script>
    const userIcon = document.getElementById("user-icon");
    const userMenu = document.getElementById("user-menu");

    // Alternar menu do usuário
    userIcon.addEventListener("click", (e) => {
        e.stopPropagation();
        const isOpen = userMenu.style.display === "block";
        userMenu.style.display = isOpen ? "none" : "block";
    });

    // Fechar ao clicar fora
    document.addEventListener("click", () => {
        userMenu.style.display = "none";
    });

    // Impede fechamento ao clicar dentro
    userMenu.addEventListener("click", (e) => e.stopPropagation());
</script>

</body>
</html>
