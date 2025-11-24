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
$sql = "SELECT nome, email FROM professor WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $professor_id);
$stmt->execute();
$result = $stmt->get_result();
$professor = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Consultar Alunos</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Ícones Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- CSS externo -->
  <link rel="stylesheet" href="css/consulta.css">
  <link rel="stylesheet" href="css/homeprof.css">
</head>
<body>
    
<header>
    <h1>Biblioteca Digital</h1>

    <div class="icons">
        <a href="homeprof.php" style="text-decoration:none;">
            <i class="bi bi-house-door-fill" title="Início"></i>
        </a>

        <i class="bi bi-bell-fill" id="notification-btn" title="Notificações"></i>

        <!-- ÍCONE DO USUÁRIO -->
        <i class="bi bi-person-fill" id="user-icon" title="Perfil"></i>

        <!-- MENU DO USUÁRIO -->
        <div class="notification-box" id="user-menu" style="width:220px; display:none;">
            <div class="notification-title">Usuário</div>
            <div class="notification-content">
                <p><strong>Nome:</strong> <?= htmlspecialchars($professor['nome']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($professor['email']) ?></p>
                <hr>
                <a href="dadosprof.php" class="btn-logout">Perfil</a>
                <a href="logout.php" class="btn-logout">Sair</a>
            </div>
        </div>

        <!-- CAIXA DE NOTIFICAÇÕES -->
        <div class="notification-box" id="notification-box">
            <div class="notification-title">Notificações</div>
            <div class="notification-content">
                Sem novas notificações.
            </div>
        </div>
    </div>
</header>

<!-- SCRIPT DO HEADER -->
<script>
const btn = document.getElementById('notification-btn');
const box = document.getElementById('notification-box');
const userIcon = document.getElementById('user-icon');
const userMenu = document.getElementById('user-menu');

// Abre/fecha notificações
btn.addEventListener('click', () => {
    box.style.display = box.style.display === 'block' ? 'none' : 'block';
    userMenu.style.display = 'none';
});

// Abre/fecha menu usuário
userIcon.addEventListener('click', () => {
    userMenu.style.display = userMenu.style.display === 'none' ? 'block' : 'none';
    box.style.display = 'none';
});

// Fecha ao clicar fora
document.addEventListener('click', (e) => {
    if (!userMenu.contains(e.target) && e.target !== userIcon &&
        !box.contains(e.target) && e.target !== btn) {
        userMenu.style.display = 'none';
        box.style.display = 'none';
    }
});
</script>

</body>
</html>
