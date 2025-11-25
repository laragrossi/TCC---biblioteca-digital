<?php
session_start();
include "conexaoconsulta.php";

// Autorizar login
if (!isset($_SESSION['ProfID'])) {
    header("Location: loginprof.php");
    exit();
}

// Buscar dados do professor
$professor_id = $_SESSION['ProfID'];
$sql = "SELECT nome, email FROM professor WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $professor_id);
$stmt->execute();
$result = $stmt->get_result();
$professor = $result->fetch_assoc();

// Buscar estatísticas
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
      </div>
  </header>

  <!-- Conteúdo -->
  <div class="container mt-4">
    <div class="row g-3">

      <div class="col-12 col-md-4">
        <a href="consulta_alunos.php" style="text-decoration: none; color: inherit; display: block;">
          <div class="card-custom" style="cursor: pointer;">
            <p>Consulta de alunos</p>
          </div>
        </a>
      </div>

      <div class="col-12 col-md-4">
        <a href="emprestimoprof.php" style="text-decoration: none; color: inherit; display: block;">
          <div class="card-custom" style="cursor: pointer;">
            <p>Empréstimos Ativos</p>
          </div>
        </a>
      </div>

      <div class="col-12 col-md-4">
        <a href="satusdedisponibilidade.php" style="text-decoration: none; color: inherit; display: block;">
          <div class="card-custom" style="cursor: pointer;">
            <p>Acervo de livros</p>
          </div>
        </a>
      </div>

    </div>

    <!-- Caixa STATUS CENTRALIZADA -->
    <div class="container d-flex justify-content-center mt-4">
        <div class="row g-3 w-100" style="max-width: 500px;">
            <div class="col-12">
                <div class="status-box text-center">
                    <h5>Status atual</h5>
                    <p>Empréstimos ativos</p>
                    <h4 class="fw-bold text-danger"><?= $emprestimos_ativos ?></h4>
                </div>
            </div>
        </div>
    </div>

  </div>

  <!-- Script do menu do usuário -->
  <script>
    const userIcon = document.getElementById("user-icon");
    const userMenu = document.getElementById("user-menu");

    userIcon.addEventListener("click", () => {
      userMenu.style.display = userMenu.style.display === "none" ? "block" : "none";
    });

    // Fechar ao clicar fora
    document.addEventListener("click", (e) => {
      if (!userMenu.contains(e.target) && e.target !== userIcon) {
        userMenu.style.display = "none";
      }
    });
  </script>

</body>
</html>
