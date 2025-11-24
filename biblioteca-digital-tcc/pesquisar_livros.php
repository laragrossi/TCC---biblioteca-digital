<?php
session_start();
include "conexaoconsulta.php";

// Verificar se o aluno está logado
if (!isset($_SESSION['AlunoID'])) {
    header("Location: loginaluno.php");
    exit();
}

// Pesquisa
$termo_pesquisa = "";
$livros = [];

if (isset($_GET['pesquisa'])) {
    $termo_pesquisa = trim($_GET['pesquisa']);
    
    if (!empty($termo_pesquisa)) {
        $sql = "SELECT id, titulo, autor, foto, quantidade_disponivel 
                FROM livros 
                WHERE titulo LIKE ? OR autor LIKE ? 
                ORDER BY titulo";
        $stmt = $conexao->prepare($sql);
        $termo_like = "%" . $termo_pesquisa . "%";
        $stmt->bind_param("ss", $termo_like, $termo_like);
        $stmt->execute();
        $result = $stmt->get_result();
        $livros = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Livros</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
     <link rel="stylesheet" href="css/pesquisar_livros.css">
</head>

<body>
<!-- navbar -->
<header>
    <h1>Pesquisar Livros</h1>

    <div class="icons">

        <!-- Home -->
        <a href="homealuno.php" class="icon-link">
            <i class="bi bi-house-door-fill" title="Início"></i>
        </a>

        <!-- Usuário -->
        <i class="bi bi-person-fill" id="user-icon" title="Perfil"></i>

        <!-- Menu de Perfil + Logout (IGUAL AO OUTRO) -->
        <div class="notification-box" id="user-menu" style="width:220px;">
            <div class="notification-content">
                <hr>
                <a href="dadosaluno.php" class="btn-logout">Perfil</a>
                <a href="logout.php" class="btn-logout">Sair</a>
            </div>
        </div>

    </div>
</header>


<!-- ======================= Barra de Pesquisa ======================= -->
<div class="search-container">
    <div class="search-box">
        <form method="GET" action="pesquisar_livros.php" style="width: 100%; display: flex; align-items: center;">
            <i class="bi bi-search"></i>
            <input type="text" name="pesquisa" placeholder="Pesquisar livros, autores..." 
                   value="<?= htmlspecialchars($termo_pesquisa) ?>" 
                   style="flex: 1; border: none; outline: none; background: transparent;">
            <button type="submit" style="background: none; border: none; color: #666; cursor: pointer;">
                <i class="bi bi-arrow-right"></i>
            </button>
        </form>
    </div>
</div>


<!-- ======================= Resultados ======================= -->
<div style="padding: 20px;">
    <?php if (!empty($termo_pesquisa)): ?>
        <h2 style="margin-bottom: 20px;">Resultados para: "<?= htmlspecialchars($termo_pesquisa) ?>"</h2>
        
        <?php if (empty($livros)): ?>
            <div style="text-align: center; color: #666; font-size: 18px; margin-top: 50px;">
                <i class="bi bi-book" style="font-size: 48px; margin-bottom: 15px;"></i>
                <p>Nenhum livro encontrado.</p>
            </div>
        <?php else: ?>
            <div class="book-list">
                <?php foreach ($livros as $livro): ?>
                    <div class="book" onclick="verDetalhes(<?= $livro['id'] ?>)">
                        <?php if (!empty($livro['foto'])): ?>
                            <!-- CORREÇÃO APLICADA AQUI: removido "fotos_livros/" extra -->
                            <img src="<?= $livro['foto'] ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>" 
                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjE2MCIgdmlld0JveD0iMCAwIDEyMCAxNjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMjAiIGhlaWdodD0iMTYwIiByeD0iOCIgZmlsbD0iI2Y4ZjlmYSIvPgo8cGF0aCBkPSJNNzUgNjBINDUgTTYwIDQ1Vjc1IiBzdHJva2U9IiM2Yzc1N2QiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+CjxwYXRoIGQ9Ik00NSA1MEg1NVY2MEg0NVoiIGZpbGw9IiM2Yzc1N2QiLz4KPC9zdmc+'" 
                                 style="width: 120px; height: 160px; object-fit: cover; border-radius: 8px;">
                        <?php else: ?>
                            <div style="width: 120px; height: 160px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 8px; color: #6c757d;">
                                <i class="bi bi-book" style="font-size: 24px;"></i>
                            </div>
                        <?php endif; ?>

                        <p><?= htmlspecialchars($livro['titulo']) ?></p>
                        <p class="author"><?= htmlspecialchars($livro['autor']) ?></p>

                        <div style="padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold; margin-top: 5px; 
                            <?= $livro['quantidade_disponivel'] > 0 ? 'background: #d4edda; color: #155724;' : 'background: #f8d7da; color: #721c24;' ?>">
                            <?= $livro['quantidade_disponivel'] > 0 ? 'Disponível' : 'Indisponível' ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div style="text-align: center; color: #666; margin-top: 100px;">
            <i class="bi bi-search" style="font-size: 48px; margin-bottom: 20px;"></i>
            <p>Digite o nome do livro ou autor para pesquisar</p>
        </div>
    <?php endif; ?>
</div>


<!-- ======================= JS DO MENU  ======================= -->
<script>
const userIcon = document.getElementById("user-icon");
const userMenu = document.getElementById("user-menu");

document.addEventListener("click", function (e) {
    if (userIcon.contains(e.target)) {
        userMenu.style.display = userMenu.style.display === "block" ? "none" : "block";
    } else if (!userMenu.contains(e.target)) {
        userMenu.style.display = "none";
    }
});

function verDetalhes(id) {
    window.location.href = "detalhes_livros.php?id=" + id;
}
</script>

</body>
</html>