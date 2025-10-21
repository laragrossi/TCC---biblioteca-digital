<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Biblioteca Digital</title>
  
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
          <a href="dadosprof.php"><i class="bi bi-person-fill" title="Perfil"></i></a>

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
        <div class="card-custom">
          <i class="bi bi-people"></i>
          <p>Consulta de alunos</p>
        </div>
      </div>

      <a href="emprestimoprof.php" class="col-12 col-md-4 text-decoration-none">
        <div class="card-custom">
          <i class="bi bi-book"></i>
          <p>Empréstimos ativos</p>
        </div>
      </a>

      <a href="cadastrolivros.php" class="col-12 col-md-4 text-decoration-none">
        <div class="card-custom">
          <i class="bi bi-book"></i>
          <p>Cadastro de Livros</p>
        </div>
      </a>

      <a href="statusdedisponibilidade.php" class="col-12 col-md-4 text-decoration-none">
        <div class="card-custom">
          <i class="bi bi-journal-bookmark"></i>
          <p>Status de Disponibilidade</p>
        </div>
      </a>
    </div>

    <div class="row mt-4 g-3">
      <div class="col-12 col-md-6">
        <div class="status-box">
          <h5>Status atual</h5>
          <p>Empréstimos ativos</p>
          <h4 class="fw-bold text-danger">22</h4>
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

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Script de notificações -->
  <script>
    const btn = document.getElementById('notification-btn');
    const box = document.getElementById('notification-box');

    btn.addEventListener('click', () => {
      box.style.display = box.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', (e) => {
      if (!btn.contains(e.target) && !box.contains(e.target)) {
        box.style.display = 'none';
      }
    });
  </script>
</body>
</html>
