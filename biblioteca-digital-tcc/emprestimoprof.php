<?php
session_start();
include "conexaoconsulta.php";  // CONEXÃO ADICIONADA

// Verificar se o professor está logado
if (!isset($_SESSION['ProfessorID'])) {
    header("Location: loginprof.php");
    exit();
}

// Buscar dados do professor para exibir no menu
$professor_id = $_SESSION['ProfessorID'];
$sql_professor = "SELECT nome, email FROM professor WHERE id = ?";
$stmt_professor = $conexao->prepare($sql_professor);
$stmt_professor->bind_param("i", $professor_id);
$stmt_professor->execute();
$result_professor = $stmt_professor->get_result();
$professor = $result_professor->fetch_assoc();

// Buscar empréstimos ativos do banco
$sql_emprestimos = "SELECT e.RA_Aluno, e.IDLivro, e.DataEmprestimo, e.DataDevolucaoPrevista, 
                           a.nome as nome_aluno, a.serie, a.turma,
                           l.titulo as titulo_livro,
                           CASE 
                               WHEN e.DataDevolucaoPrevista < CURDATE() THEN 'em-atraso'
                               ELSE 'em-andamento'
                           END as status
                    FROM emprestimo e
                    INNER JOIN aluno a ON e.RA_Aluno = a.ra_completo
                    INNER JOIN livros l ON e.IDLivro = l.id
                    WHERE e.Status = 'Ativo'
                    ORDER BY e.DataDevolucaoPrevista ASC";
$result_emprestimos = $conexao->query($sql_emprestimos);
$emprestimos = $result_emprestimos->fetch_all(MYSQLI_ASSOC);
?>
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

<header>
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
                <p><strong>Nome:</strong> <?= htmlspecialchars($professor['nome']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($professor['email']) ?></p>
                <hr>
                <a href="dadosprof.php">Perfil</a><br><br>
                <a href="logout.php">Sair</a>  <!--LOGOUT CORRETO -->
            </div>
        </div>

    </div>
</header>

<div class="search-container">
    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Procurar alunos" id="searchInput">
    </div>
</div>

<!-- BOTÕES DE FILTRO -->
<div class="filter-buttons">
    <button class="filter-btn active" onclick="filterEmprestimos('todos')">Todos</button>
    <button class="custom-btn" onclick="window.location.href='atrasadosprof.php'">Atrasados</button>
</div>

<div class="cards" id="emprestimosContainer">
    <?php if (empty($emprestimos)): ?>
        <div style="text-align: center; padding: 40px; color: #666;">
            <i class="bi bi-inbox" style="font-size: 48px; margin-bottom: 15px;"></i>
            <p>Nenhum empréstimo ativo no momento</p>
        </div>
    <?php else: ?>
        <?php foreach ($emprestimos as $emp): ?>
            <div class="card" data-aluno="<?= strtolower($emp['nome_aluno']) ?>" data-status="<?= $emp['status'] ?>">
                <h3><?= htmlspecialchars($emp['nome_aluno']) ?></h3>
                <p>RA: <?= htmlspecialchars($emp['RA_Aluno']) ?></p>
                <p>Turma: <?= htmlspecialchars($emp['serie']) ?> <?= htmlspecialchars($emp['turma']) ?></p>
                <p>Livro: <?= htmlspecialchars($emp['titulo_livro']) ?></p>
                <span class="status <?= $emp['status'] ?>">
                    <?= $emp['status'] == 'em-atraso' ? 'Em atraso' : 'Em andamento' ?>
                </span>
                <p>Empréstimo: <?= date('d/m/Y', strtotime($emp['DataEmprestimo'])) ?></p>
                <p>Devolução: <?= date('d/m/Y', strtotime($emp['DataDevolucaoPrevista'])) ?></p>
                
                <?php if ($emp['status'] == 'em-atraso'): ?>
                    <div style="color: #dc3545; font-weight: bold; margin-top: 8px;">
                         Atraso: <?= floor((time() - strtotime($emp['DataDevolucaoPrevista'])) / (60 * 60 * 24)) ?> dias
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
const notificationBtn = document.getElementById('notification-btn');
const notificationBox = document.getElementById('notification-box');
const userIcon = document.getElementById('user-icon');
const userMenu = document.getElementById('user-menu');
const searchInput = document.getElementById('searchInput');
const emprestimosContainer = document.getElementById('emprestimosContainer');

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

// Busca em tempo real
searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const cards = emprestimosContainer.getElementsByClassName('card');
    
    Array.from(cards).forEach(card => {
        const alunoName = card.getAttribute('data-aluno');
        if (alunoName.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Filtro de empréstimos
function filterEmprestimos(status) {
    const cards = emprestimosContainer.getElementsByClassName('card');
    
    Array.from(cards).forEach(card => {
        if (status === 'todos' || card.getAttribute('data-status') === status) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
</body>
</html>