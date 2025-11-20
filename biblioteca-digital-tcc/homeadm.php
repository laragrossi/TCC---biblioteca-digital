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
  
  <style>
    /* Estilos para o dropdown do perfil */
    .profile-container {
      position: relative;
      display: inline-block;
    }
    
    .profile-dropdown {
      display: none;
      position: absolute;
      right: 0;
      top: 100%;
      background-color: white;
      min-width: 180px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      border-radius: 8px;
      z-index: 1000;
      margin-top: 10px;
    }
    
    .profile-dropdown.show {
      display: block;
    }
    
    .profile-dropdown a {
      display: block;
      padding: 12px 16px;
      text-decoration: none;
      color: #333;
      border-bottom: 1px solid #f1f1f1;
      transition: background-color 0.3s;
    }
    
    .profile-dropdown a:hover {
      background-color: #f8f9fa;
    }
    
    .profile-dropdown a:last-child {
      border-bottom: none;
      color: #dc3545;
      font-weight: bold;
    }
    
    .profile-dropdown a:last-child:hover {
      background-color: #dc3545;
      color: white;
    }
    
    .profile-icon {
      cursor: pointer;
      padding: 8px;
      border-radius: 50%;
      transition: background-color 0.3s;
    }
    
    .profile-icon:hover {
      background-color: rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
  <!-- Cabeçalho -->
  <header>
      <h1>Biblioteca Digital</h1>
      <div class="icons">
          <i class="bi bi-house-door-fill" title="Início"></i>
          <i class="bi bi-bell-fill" id="notification-btn" title="Notificações"></i>
          
          <!-- Container do perfil com dropdown -->
          <div class="profile-container">
            <i class="bi bi-person-fill profile-icon" id="profile-btn" title="Perfil"></i>
            
            <!-- Dropdown do perfil -->
            <div class="profile-dropdown" id="profile-dropdown">
              <a href="dadosprof.php">
                <i class="bi bi-person"></i> Meu Perfil
              </a>
              <a href="configuracoes.php">
                <i class="bi bi-gear"></i> Configurações
              </a>
              <a href="logout_adm.php">
                <i class="bi bi-box-arrow-right"></i> Sair
              </a>
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
  </div>

  <div class="col-12 col-md-6">
    <div class="notifications">
      <h5>Livros emprestados</h5>
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
  
  <!-- Script de notificações e perfil -->
  <script>
    // Notificações
    const btn = document.getElementById('notification-btn');
    const box = document.getElementById('notification-box');

    btn.addEventListener('click', () => {
      box.style.display = box.style.display === 'block' ? 'none' : 'block';
      // Fecha o dropdown do perfil se estiver aberto
      profileDropdown.classList.remove('show');
    });

    // Perfil dropdown
    const profileBtn = document.getElementById('profile-btn');
    const profileDropdown = document.getElementById('profile-dropdown');

    profileBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      profileDropdown.classList.toggle('show');
      // Fecha as notificações se estiverem abertas
      box.style.display = 'none';
    });

    // Fecha dropdowns ao clicar fora
    document.addEventListener('click', (e) => {
      // Fecha notificações
      if (!btn.contains(e.target) && !box.contains(e.target)) {
        box.style.display = 'none';
      }
      
      // Fecha dropdown do perfil
      if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
        profileDropdown.classList.remove('show');
      }
    });

    // Previne que o dropdown feche ao clicar dentro dele
    profileDropdown.addEventListener('click', (e) => {
      e.stopPropagation();
    });
  </script>
</body>
</html>