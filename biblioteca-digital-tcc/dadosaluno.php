<?php
session_start();
include "conexaoconsulta.php";  // ✅ CONEXÃO ADICIONADA

// Verificar se o aluno está logado
if (!isset($_SESSION['AlunoID'])) {
    header("Location: loginaluno.php");
    exit();
}

// Buscar dados COMPLETOS do aluno
$aluno_id = $_SESSION['AlunoID'];
$sql = "SELECT * FROM aluno WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $aluno_id);
$stmt->execute();
$result = $stmt->get_result();
$aluno = $result->fetch_assoc();

if (!$aluno) {
    die("Aluno não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados Cadastrados - Biblioteca Digital</title>
   
    <!-- Link para o pacote de ícones Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dadosalunos.css">
</head>
<body>
    <header>
        <h1>Dados cadastrados</h1>
        <div class="icons">
            <a href="homealuno.php"><i class="bi bi-house-door-fill" title="Início"></i></a>
            <i class="bi bi-bell-fill" id="notification-btn" title="Notificações"></i>
            <i class="bi bi-person-fill" title="Perfil"></i>
        </div>
    </header>
    
    <div class="info-card">
        <!-- Ícone do aluno -->
        <div class="icon-area">
            <i class="bi bi-person-circle"></i>
        </div>
        
        <!-- Texto dentro da caixa -->
        <div class="text-area">
            <h2 class="section-title">Dados do aluno</h2>
            <p><strong>Nome:</strong> <?= htmlspecialchars($aluno['nome']) ?></p>
            <p><strong>RA:</strong> <?= htmlspecialchars($aluno['ra_completo']) ?></p>
            
            <?php if (!empty($aluno['serie'])): ?>
                <p><strong>Série:</strong> <?= htmlspecialchars($aluno['serie']) ?></p>
            <?php endif; ?>
            
            <?php if (!empty($aluno['turma'])): ?>
                <p><strong>Turma:</strong> <?= htmlspecialchars($aluno['turma']) ?></p>
            <?php endif; ?>

            <h2 class="section-title mt-3">Dados da escola</h2>
            <p><strong>Escola:</strong> <?= htmlspecialchars($aluno['escola']) ?></p>
            <p class="ano-letivo"><strong>Ano letivo:</strong></p>
            <p>2025</p>
        </div>
    </div>
    
    <center>Última atualização: <?= date('d \d\e F \d\e Y', strtotime($aluno['created_at'])) ?></center>
</body>
</html>