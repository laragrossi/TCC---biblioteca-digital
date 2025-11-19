<?php
session_start();
include "conexaoconsulta.php";  // ✅ CONEXÃO ADICIONADA

// Verificar se o professor está logado
if (!isset($_SESSION['ProfessorID'])) {
    header("Location: loginprof.php");
    exit();
}

// Buscar dados do professor para exibir no menu
$professor_id = $_SESSION['ProfessorID'];
$sql = "SELECT nome, email FROM professor WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $professor_id);
$stmt->execute();
$result = $stmt->get_result();
$professor = $result->fetch_assoc();

// Buscar estatísticas (opcional)
$sql_emprestimos = "SELECT COUNT(*) as total FROM emprestimo WHERE Status = 'Ativo'";
$result_emprestimos = $conexao->query($sql_emprestimos);
$emprestimos_ativos = $result_emprestimos->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Biblioteca Digital - Professor</title>
  
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Ícones Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  
  <!-- CSS externo -->
  <link rel="stylesheet" href="css/homeprof.css">
</head>
<body>
  <!-- Cabeçalho -->
  <header>
      <h1>Biblioteca Digital</h1>
      <div class="icons">
          <i class="bi bi-house-door-fill" title="Início"></i>
          <i class="bi bi-bell-fill" id="notification-btn" title="Notificações"></i>

          <!-- ÍCONE DO USUÁRIO -->
          <i class="bi bi-person-fill" id="user-icon" title="Perfil"></i>

          <!-- MENU DO USUÁRIO (PERFIL + LOGOUT) -->
          <div class="notification-box" id="user-menu" style="width:220px; display:none;">
              <div class="notification-title">Usuário</div>
              <div class="notification-content">
                  <p><strong>Nome:</strong> <?= htmlspecialchars($professor['nome']) ?></p>
                  <p><strong>Email:</strong> <?= htmlspecialchars($professor['email']) ?></p>
                  <hr>
                  <a href="dadosprof.php" class="btn-logout">Perfil</a><br><br>
                  <a href="logout.php" class="btn-logout">Sair</a>
              </div>
          </div>

          <!-- Caixa de notificações -->
          <div class="notification-box" id="notification-box">
              <div class="notification-title">Notificações</div>
              <div class="notification-content">
                  Novo empréstimo solicitado<br>
                  Aluno: João Silva<br>
                  Livro: Dom Casmurro
              </div>
          </div>
      </div>
  </header>

  <!-- Conteúdo principal -->
  <div class="container mt-4">
    <div class="row g-3">
      
      <div class="col-12 col-md-4">
        <a href="consulta.php" style="text-decoration: none; color: inherit; display: block;">
          <div class="card-custom" style="cursor: pointer;">
            <i class="bi bi-people"></i>
            <p>Consulta de alunos</p>
          </div>
        </a>
      </div>

      <div class="col-12 col-md-4">
        <a href="emprestimoprof.php" style="text-decoration: none; color: inherit; display: block;">
          <div class="card-custom" style="cursor: pointer;">
            <i class="bi bi-book"></i>
            <p>Empréstimos Ativos</p>
          </div>
        </a>
      </div>

      <div class="col-12 col-md-4">
        <a href="statusdedisponibilidade.php" style="text-decoration: none; color: inherit; display: block;">
          <div class="card-custom" style="cursor: pointer;">
            <i class="bi bi-library"></i>
            <p>Acervo de livros</p>
          </div>
        </a>
      </div>
    </div>

    <div class="row mt-4 g-3">
      <div class="col-12 col-md-6">
        <div class="status-box">
          <h5>Status atual</h5>
          <p>Empréstimos ativos</p>
          <h4 class="fw-bold text-danger"><?= $emprestimos_ativos ?></h4>  <!-- ✅ DADOS REAIS -->
        </div>
      </div>

      <div class="col-12 col-md-6">
        <div class="notifications">
          <h5>Notificações recentes</h5>

          <p><strong>Novo empréstimo solicitado</strong><br>
            Nome do aluno - nome do livro <br>
            <small>Há 5 minutos</small>
          </p>

          <p><strong>Devolução atrasada</strong><br>
            Nome do aluno - nome do livro <br>
            <small>Há 2 horas</small>
          </p>

          <p><strong>Reserva confirmada</strong><br>
            Nome do aluno - nome do livro <br>
            <small>Há 4 horas</small>
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    // NOTIFICAÇÕES
    const btn = document.getElementById('notification-btn');
    const box = document.getElementById('notification-box');

    btn.addEventListener('click', () => {
      box.style.display = box.style.display === 'block' ? 'none' : 'block';
      userMenu.style.display = "none";
    });

    // MENU DO USUÁRIO
    const userIcon = document.getElementById("user-icon");
    const userMenu = document.getElementById("user-menu");

    userIcon.addEventListener("click", () => {
      userMenu.style.display = userMenu.style.display === "none" ? "block" : "none";
      box.style.display = "none";
    });

    // FECHAR AO CLICAR FORA
    document.addEventListener("click", (e) => {
      if (!userMenu.contains(e.target) && e.target !== userIcon &&
          !box.contains(e.target) && e.target !== btn) {
        userMenu.style.display = "none";
        box.style.display = "none";
      }
    });
  </script>
</body>
</html>