<?php
session_start();
include "conexaoconsulta.php";

// Verifica se o professor está logado
if (!isset($_SESSION['ProfID'])) {
    header("Location: loginprof.php");
    exit();
}

// Buscar dados do professor
$prof_id = $_SESSION['ProfID'];
$sql = "SELECT * FROM professor WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $prof_id);
$stmt->execute();
$result = $stmt->get_result();
$professor = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Digital</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/dadosprof.css">
</head>

<body>

<header>
    <h1>Dados cadastrados</h1>
    <div class="icons">

    <!-- Home -->
    <a href="homeprof.php" class="icon-link">
        <i class="bi bi-house-door-fill" title="Início"></i>
</a>

    <!-- Usuário -->
    <i class="bi bi-person-fill" id="user-icon" title="Perfil"></i>

    <!-- Menu do Usuário -->
    <div class="notification-box" id="user-menu" style="width:220px;">
        <div class="notification-content">
            <hr>
            <a href="logoutprof.php" class="btn-logout">Sair</a>
        </div>
    </div>

</div>

</header>

<div class="info-card">

    <div class="icon-area">
        <i class="bi bi-person-circle"></i>
    </div>

    <div class="text-area">
        <h2 class="section-title">Dados do professor</h2>

        <p><strong>Nome:</strong> <?= htmlspecialchars($professor['nome']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($professor['email']) ?></p>

        <h2 class="section-title mt-3">Dados da escola</h2>
        <p><?= htmlspecialchars($professor['escola']) ?></p>

        <p class="ano-letivo"><strong>Ano letivo:</strong></p>
        <p>2025</p>
    </div>

</div>

<center>Última atualização: <?= date("d/m/Y") ?></center>


<!-- JAVASCRIPT -->
<script>
    const userIcon = document.getElementById("user-icon");
    const userMenu = document.getElementById("user-menu");
    const notificationBtn = document.getElementById("notification-btn");
    const notificationBox = document.getElementById("notification-box");

    function closeAll() {
        userMenu.style.display = "none";
        if (notificationBox) notificationBox.style.display = "none";
    }

    userIcon.addEventListener("click", () => {
        const isOpen = userMenu.style.display === "block";
        closeAll();
        userMenu.style.display = isOpen ? "none" : "block";
    });

    document.addEventListener("click", (e) => {
        if (!userIcon.contains(e.target) && !userMenu.contains(e.target)) {
            userMenu.style.display = "none";
        }
    });
</script>
</body>
</html>
