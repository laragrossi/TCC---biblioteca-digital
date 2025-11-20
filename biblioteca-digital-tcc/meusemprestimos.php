<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Meus Empréstimos</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/meusemprestimos.css">
</head>

<body>

<!-- NAVBAR  -->
<header>
    <h1>Biblioteca</h1>

    <div class="icons">

        <!-- Home -->
        <a href="home.php" class="icon-link">
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
            <div class="notification-title">Usuário</div>
            <div class="notification-content">
                <p><strong>Nome:</strong> Professor</p>
                <p><strong>Email:</strong> professor@example.com</p>
                <hr>
                <a href="dadosprof.php" class="btn-logout">Perfil</a>
                <a href="logout.php" class="btn-logout">Sair</a>
            </div>
        </div>

    </div>
</header>



<!-- FILTROS -->
<div class="filter-container">
    <a href="meusemprestimos.php" class="btn active">Todos</a>
    <a href="devolvidos.php" class="btn">Devolvidos</a>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<main>

    <!-- CARD TOTAL -->
    <div class="total-card">
        <div>
            <h2>Total de empréstimos</h2>
            <p class="number">1</p>
            <p class="label">Livro emprestado</p>
        </div>
        <i class="bi bi-book icon-big"></i>
    </div>

    <!-- CARD DO LIVRO -->
    <div class="loan-card">
        <img src="https://m.media-amazon.com/images/I/81lRWMvYpKL._AC_UF1000,1000_QL80_.jpg" alt="Capa do livro">

        <div class="info">
            <h3>O Cortiço</h3>
            <p><strong>Autor:</strong> Aluísio de Azevedo</p>
            <p><strong>Data do empréstimo:</strong> 01/08/2025</p>
            <p><strong>Data de devolução:</strong> 01/09/2025</p>
        </div>
    </div>

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
