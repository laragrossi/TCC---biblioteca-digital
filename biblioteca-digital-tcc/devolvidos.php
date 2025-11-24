
<?php
session_start();
include "conexaoconsulta.php"; 

// Verifica se o aluno está logado
if (!isset($_SESSION['AlunoID'])) {
    header("Location: loginaluno.php");
    exit();
}

/* CONSULTA DOS DEVOLVIDOS */
$livros_devolvidos = [
    [
        "titulo" => "Dom Casmurro",
        "autor" => "Machado de Assis",
        "emprestimo" => "05/07/2025",
        "devolucao"  => "05/08/2025",
        "foto" => "https://m.media-amazon.com/images/I/71n5p+taH4L._AC_UF1000,1000_QL80_.jpg"
    ],
    [
        "titulo" => "Capitães da Areia",
        "autor" => "Jorge Amado",
        "emprestimo" => "10/06/2025",
        "devolucao"  => "10/07/2025",
        "foto" => "https://m.media-amazon.com/images/I/81QGj0VQGYL._AC_UF1000,1000_QL80_.jpg"
    ]
];

// PARA USAR O BANCO:
// $sql = "SELECT ... somente devolvidos";
// $result = $conexao->query($sql);
// $livros_devolvidos = $result->fetch_all(MYSQLI_ASSOC);
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

        <!-- Notificações -->
        <i class="bi bi-bell-fill" id="notification-btn" title="Notificações"></i>

        <!-- Caixa de Notificações -->
        <div class="notification-box" id="notification-box">
            <div class="notification-title">Notificações</div>
            <div class="notification-content">
                <p>Nenhuma notificação no momento.</p>
            </div>
        </div>

        <!-- Usuário -->
        <i class="bi bi-person-fill" id="user-icon" title="Perfil"></i>

        <!-- Menu do Usuário -->
        <div class="notification-box" id="user-menu" style="width:220px;">
            <div class="notification-content">
                <hr>
                <a href="dadosaluno.php" class="btn-logout">Perfil</a>
                <a href="logout.php" class="btn-logout">Sair</a>
            </div>
        </div>

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
            <img src="<?= $livro['foto'] ?>" alt="Capa do livro">

            <div class="info">
                <h3><?= $livro['titulo'] ?></h3>
                <p><strong>Autor:</strong> <?= $livro['autor'] ?></p>
                <p><strong>Data do empréstimo:</strong> <?= $livro['emprestimo'] ?></p>
                <p><strong>Data da devolução:</strong> <?= $livro['devolucao'] ?></p>
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
