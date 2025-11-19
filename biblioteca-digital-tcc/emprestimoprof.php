<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Empréstimos Ativos</title>

<!-- Importando ícones do Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/emprestimoprof.css">

</head>
<body>

<<header>
    <h1>Empréstimos ativos</h1>

    <div class="icons" style="position: relative; display:flex; gap:15px; align-items:center;">

        <!-- HOME -->
        <a href="homeprof.php"><i class="bi bi-house-door-fill" title="Início"></i></a>

        <!-- NOTIFICAÇÕES -->
        <i class="bi bi-bell-fill" id="notification-btn" title="Notificações" style="cursor:pointer;"></i>

        <!-- PERFIL -->
        <i class="bi bi-person-fill" id="user-icon" title="Usuário" style="cursor:pointer;"></i>

        <!-- CAIXA DE NOTIFICAÇÕES -->
        <div id="notification-box" 
             style="
                display:none;
                position:absolute;
                top:40px;
                right:0;
                width:220px;
                background:#f8c7b1;
                padding:10px;
                border-radius:10px;
                box-shadow:0 4px 8px rgba(0,0,0,0.2);">
            
            <div style="font-weight:bold; margin-bottom:5px; border-bottom:1px solid #0003; padding-bottom:5px;">
                Notificações
            </div>

            <div style="background:#ffe4d6; padding:8px; border-radius:5px; font-size:14px;">
                Novo empréstimo solicitado <br>
                Aluno: João Silva <br>
                Livro: Dom Casmurro
            </div>
        </div>

        <!-- MENU DO USUÁRIO -->
        <div id="user-menu"
             style="
                display:none;
                position:absolute;
                top:40px;
                right:0;
                width:220px;
                background:#f8c7b1;
                padding:10px;
                border-radius:10px;
                box-shadow:0 4px 8px rgba(0,0,0,0.2);">

            <div style="font-weight:bold; margin-bottom:5px; border-bottom:1px solid #0003; padding-bottom:5px;">
                Usuário
            </div>

            <div style="background:#ffe4d6; padding:8px; border-radius:5px; font-size:14px;">
                <p><strong>Nome:</strong> Professor</p>
                <p><strong>Email:</strong> professor@example.com</p>
                <hr>
                <a href="dadosprof.php">Perfil</a><br><br>
                <a href="index.php">Sair</a>
            </div>
        </div>

    </div>
</header>




<div class="search-container">
    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Procurar alunos">
    </div>
</div>

<!-- BOTÕES DE FILTRO -->
<div class="filter-buttons">
    <button class="filter-btn active">Todos</button>
   <button class="custom-btn" onclick="window.location.href='atrasadosprof.php'">Atrasados
</button>

</div>

<div class="cards">
    <div class="card">
        <h3>Giovana Rosa</h3>
        <p>RA: XXXXXXXXXX-X</p>
        <p>Turma: 3ºDS</p>
        <p>Livro: O Cortiço</p>
        <span class="status em-andamento">Em andamento</span>
        <p>Devolução: xx/xx/xxxx</p>
    </div>

    <div class="card">
        <h3>Nome do aluno</h3>
        <p>RA: XXXXXXXXXX-X</p>
        <p>Turma: 3ºDS</p>
        <p>Livro: O Cortiço</p>
        <span class="status em-atraso">Em atraso</span>
        <p>Empréstimo: xx/xx/xxxx</p>
        <p>Devolução: xx/xx/xxxx</p>
    </div>

    <div class="card">
        <h3>Nome do aluno</h3>
        <p>RA: XXXXXXXXXX-X</p>
        <p>Turma: 3ºDS</p>
        <p>Livro: O Cortiço</p>
        <span class="status em-andamento">Em andamento</span>
        <p>Devolução: xx/xx/xxxx</p>
    </div>

    <div class="card">
        <h3>Nome do aluno</h3>
        <p>RA: XXXXXXXXXX-X</p>
        <p>Turma: 3ºDS</p>
        <p>Livro: O Cortiço</p>
        <span class="status em-andamento">Em andamento</span>
        <p>Devolução: xx/xx/xxxx</p>
    </div>
</div>

<<script>
const notificationBtn = document.getElementById('notification-btn');
const notificationBox = document.getElementById('notification-box');
const userIcon = document.getElementById('user-icon');
const userMenu = document.getElementById('user-menu');

// Abre/fecha notificações
notificationBtn.addEventListener('click', () => {
    notificationBox.style.display = notificationBox.style.display === 'block' ? 'none' : 'block';
    userMenu.style.display = 'none';
});

// Abre/fecha menu do usuário
userIcon.addEventListener('click', () => {
    userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
    notificationBox.style.display = 'none';
});

// Fecha tudo ao clicar fora
document.addEventListener('click', (e) => {
    if (!notificationBtn.contains(e.target) &&
        !notificationBox.contains(e.target) &&
        !userIcon.contains(e.target) &&
        !userMenu.contains(e.target)) {

        notificationBox.style.display = 'none';
        userMenu.style.display = 'none';
    }
});
</script>
</body>
</html>
