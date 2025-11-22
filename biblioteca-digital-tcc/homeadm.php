<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Biblioteca Digital</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Ícones -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- CSS da página -->
  <link rel="stylesheet" href="css/homeprof.css">

  <style>
    /*NOTIFICAÇÕES */
    .notification-box {
      display: none;
      position: absolute;
      right: 0;
      top: 60px;
      width: 250px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
      padding: 10px;
      z-index: 1000;
    }

    .notification-title {
      font-weight: bold;
      padding-bottom: 5px;
      border-bottom: 1px solid #ccc;
      margin-bottom: 8px;
    }

    /*  ÍCONE DO USUÁRIO + MENU */
    #user-icon {
      cursor: pointer;
      margin-left: 10px;
      font-size: 1.5rem;
    }

    .user-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 60px;
      width: 200px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
      z-index: 1100;
      padding: 0px;
    }

    .user-menu a {
      display: block;
      padding: 12px;
      text-decoration: none;
      color: #333;
      border-bottom: 1px solid #eee;
      transition: 0.3s;
    }

    .user-menu a:hover {
      background: #f8f9fa;
    }

    .user-menu .logout {
      color: #dc3545;
      font-weight: bold;
    }

    .user-menu .logout:hover {
      background: #dc3545;
      color: white;
    }
    /* Ícone do usuário */
#user-icon {
    font-size: 24px;
    color: #3b1f1f;
    cursor: pointer;
}

/* Menu suspenso do usuário */
#user-menu {
    display: none;
    position: absolute;
    top: 40px;
    right: 0;
    background-color: #f8c7b1;
    border-radius: 10px;
    padding: 10px;
    width: 220px;
    box-shadow: 0px 4px 8px rgba(0,0,0,0.2);
    z-index: 10;
}

/* Seta */
#user-menu::before {
    content: "";
    position: absolute;
    top: -10px;
    right: 15px;
    border-width: 10px;
    border-style: solid;
    border-color: transparent transparent #f8c7b1 transparent;
}

/* Links do menu */
.menu-link {
    display: block;
    padding: 8px;
    background-color: #ffe4d6;
    border-radius: 6px;
    text-align: center;
    text-decoration: none;
    color: #3b1f1f;
    margin-bottom: 8px;
    font-size: 14px;
}

.menu-link:hover {
    background-color: #f1d4c4;
}

/* Botão de logout */
.logout {
    background-color: #db7c6f;
    color: white !important;
}

.logout:hover {
    background-color: #c56f63 !important;
}
/* Ajuste para alinhar os ícones*/
.icons {
    display: flex;
    align-items: center;
    gap: 15px;
    position: relative;
}

/* Força os ícones a ficarem alinhados na mesma linha */
.icons i {
    font-size: 24px;
    color: #3b1f1f;
    cursor: pointer;
    display: flex;
    align-items: center;
}

  </style>
</head>

<body>
<!-- Cabeçalho -->
<header>
    <h1>Biblioteca Digital</h1>

    <div class="icons">

        <!-- Início -->
        <i class="bi bi-house-door-fill" title="Início"></i>

        <!-- Notificações -->
        <i class="bi bi-bell-fill" id="notification-btn" title="Notificações"></i>

        <!-- Caixa de notificações -->
        <div class="notification-box" id="notification-box">
            <div class="notification-title">Notificações</div>
            <div class="notification-content">
                Nenhuma notificação no momento.
            </div>
        </div>

        <!-- Ícone do usuário -->
        <i class="bi bi-person-fill" id="user-icon" title="Perfil"></i>

        <!-- Menu do usuário -->
        <div class="notification-box" id="user-menu" style="width:220px;">
          <div class="notification-content">
                <a href="logout.php" class="menu-link logout">Sair</a>
            </div>
        </div>

    </div>
</header>



<div class="container mt-4">
  <div class="row g-3">

    <div class="col-12 col-md-4">
      <a href="cadastroprof.php" class="text-decoration-none">
          <div class="card-custom">
              <i class="bi bi-people"></i>
              <p>Cadastro de Professores</p>
          </div>
      </a>
    </div>

    <div class="col-12 col-md-4">
      <a href="cadastroaluno.php" class="text-decoration-none">
        <div class="card-custom">
           <i class="bi bi-people"></i>
          <p>Cadastro de Alunos</p>
        </div>
      </a>
    </div>

    <div class="col-12 col-md-4">
      <a href="cadastrolivros.php" class="text-decoration-none">
        <div class="card-custom">
          <i class="bi bi-book"></i>
          <p>Cadastro de Livros</p>
        </div>
      </a>
    </div>

  </div>
</div>

<!-- LIVROS EMPRESTADOS -->
<div class="col-12 col-md-6">
    <div class="notifications">
        <h5>Livros emprestados</h5>
        <p><strong>O Cortiço</strong><br> Nome do aluno - Série</p>
        <p><strong>O Pequeno Príncipe</strong><br> Nome do aluno - Série</p>
        <p><strong>O Alienista</strong><br> Nome do aluno - Série</p>
    </div>
</div>


<!-- JS -->
<script>
// Notificações
const btn = document.getElementById('notification-btn');
const box = document.getElementById('notification-box');

btn.addEventListener('click', (e) => {
  e.stopPropagation();
  const open = box.style.display === "block";
  closeAll();
  box.style.display = open ? "none" : "block";
});

// Perfil / Logout
const userIcon = document.getElementById("user-icon");
const userMenu = document.getElementById("user-menu");

userIcon.addEventListener("click", (e) => {
  e.stopPropagation();
  const open = userMenu.style.display === "block";
  closeAll();
  userMenu.style.display = open ? "none" : "block";
});

// Fecha tudo ao clicar fora
document.addEventListener("click", () => {
    closeAll();
});

function closeAll() {
    box.style.display = "none";
    userMenu.style.display = "none";
}
</script>


</body>
</html>
