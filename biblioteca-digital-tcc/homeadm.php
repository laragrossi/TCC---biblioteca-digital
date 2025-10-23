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
        <a href="cadastroprof.php" class="text-decoration-none">
            <div class="card-custom">
                <i class="bi bi-people"></i>
                <p>Cadastro de professores</p>
            </div>
        </a>
        
      </div>

      <a href="cadastroaluno.php" class="col-12 col-md-4 text-decoration-none">
        <div class="card-custom">
           <i class="bi bi-people"></i>
          <p>Cadastro de Alunos</p>
        </div>
      </a>

      <a href="cadastrolivros.php" class="col-12 col-md-4 text-decoration-none">
        <div class="card-custom">
          <i class="bi bi-book"></i>
          <p>Cadastro de Livros</p>
        </div>
      </a>

        </div>
      </a>
    </div>

  </div>
  <div class="col-12 col-md-6">
        <div class="notifications">
          <h5>Notificações recentes</h5>
          <p><strong>O Cortiço</strong><br>
            Nome do aluno - Série <br>
          </p>
          <p><strong>O pequeno prícipe</strong><br>
            Nome do aluno - Série <br>
          </p>
          <p><strong>O Alienista</strong><br>
            Nome do aluno - Série <br>
          </p>
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
