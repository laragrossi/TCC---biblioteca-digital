<?php
session_start();
include "conexaoconsulta.php";  // ✅ CONEXÃO ADICIONADA

// Verificar se o aluno está logado
if (!isset($_SESSION['AlunoID'])) {
    header("Location: loginaluno.php");
    exit();
}

// Buscar dados do aluno para personalizar a página
$aluno_id = $_SESSION['AlunoID'];
$sql_aluno = "SELECT nome FROM aluno WHERE id = ?";
$stmt_aluno = $conexao->prepare($sql_aluno);
$stmt_aluno->bind_param("i", $aluno_id);
$stmt_aluno->execute();
$result_aluno = $stmt_aluno->get_result();
$aluno = $result_aluno->fetch_assoc();

// Buscar livros em destaque (últimos 4 livros cadastrados)
$sql_livros_destaque = "SELECT id, titulo, autor, foto FROM livros WHERE disponivel = true ORDER BY created_at DESC LIMIT 4";
$result_livros = $conexao->query($sql_livros_destaque);
$livros_destaque = $result_livros->fetch_all(MYSQLI_ASSOC);

// Buscar notificações do aluno (empréstimos em atraso)
$sql_notificacoes = "SELECT l.titulo, e.DataDevolucaoPrevista 
                     FROM emprestimo e 
                     INNER JOIN livros l ON e.IDLivro = l.id 
                     WHERE e.RA_Aluno = ? AND e.DataDevolucaoPrevista < CURDATE() AND e.Status = 'Ativo' 
                     LIMIT 1";
$stmt_notificacoes = $conexao->prepare($sql_notificacoes);
$stmt_notificacoes->bind_param("s", $_SESSION['RA']);
$stmt_notificacoes->execute();
$result_notificacoes = $stmt_notificacoes->get_result();
$notificacao = $result_notificacoes->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Digital - Aluno</title>
    
    <!-- Link para o pacote de ícones Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/homealuno.css">

</head>
<body>
    <!-- Cabeçalho com título e ícones -->
    <header>
        <h1>Biblioteca Digital</h1>
        <div class="icons">
            <i class="bi bi-house-door-fill" title="Início"></i>
            <i class="bi bi-bell-fill" id="notification-btn" title="Notificações"></i>
            <a href="dadosaluno.php"><i class="bi bi-person-fill" title="Perfil"></i></a>

            <!-- Caixa de Notificações -->
            <div class="notification-box" id="notification-box">
                <div class="notification-title">Notificações</div>
                <div class="notification-content">
                    <?php if ($notificacao): ?>
                        ⚠️ Empréstimo em atraso<br>
                        Livro: <?= htmlspecialchars($notificacao['titulo']) ?><br>
                        Data: <?= date('d/m/Y', strtotime($notificacao['DataDevolucaoPrevista'])) ?>
                    <?php else: ?>
                        ✅ Nenhuma notificação<br>
                        Todos os empréstimos em dia!
                    <?php endif; ?>
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

    <!-- Lista de livros em destaque -->
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
        // Barra de pesquisa clicável
        document.querySelector('.search-box').addEventListener('click', function() {
            window.location.href = 'pesquisar_livros.php';
        });

        // Notificações
        const notificationBtn = document.getElementById('notification-btn');
        const notificationBox = document.getElementById('notification-box');

        notificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationBox.style.display = notificationBox.style.display === 'block' ? 'none' : 'block';
        });

        // Fechar notificações ao clicar fora
        document.addEventListener('click', function() {
            notificationBox.style.display = 'none';
        });

        // Evitar que clique na notificação feche
        notificationBox.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    </script>
</body>
</html>