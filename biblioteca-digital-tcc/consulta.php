<?php
include "db.php"; // inclui o arquivo de conexão com o banco de dados

// Consulta SQL para buscar todos os empréstimos cadastrados
$sql = "SELECT nome, ra, turma, livro, status, data_emprestimo, data_devolucao FROM emprestimos";

// Executa a consulta no banco
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8"> <!-- Suporte a acentos -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsividade -->
<title>Consulta de Alunos</title>

<!-- Ícones do Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<!-- Estilo externo -->
<link rel="stylesheet" href="css/consulta.css">

</head>
<body>

<header>
    <h1>Empréstimos ativos</h1>

    <!-- Área de ícones no cabeçalho -->
    <div class="icons">
        <a href="homealuno.php"><i class="bi bi-house-door"></i></a> <!-- Home -->
        <i class="bi bi-bell"></i> <!-- Notificações (sem função) -->
        <a href="dadosaluno.php"><i class="bi bi-person"></i></a> <!-- Perfil -->
    </div>
</header>

<!-- Barra de pesquisa (apenas visual, sem funcionalidade no PHP) -->
<div class="search-container">
    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Procurar alunos">
    </div>
</div>

<!-- Botões de filtro -->
<div class="filter-buttons">
    <button class="filter-btn active">Todos</button> <!-- Mostra todos os empréstimos -->
    <a href="atrasadosaluno.php" class="filter-btn disabled">Atrasados</a> <!-- Página de atrasados -->
</div>

<!-- Tabela que mostra os empréstimos -->
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>RA</th>
                <th>Turma</th>
                <th>Livro</th>
                <th>Status</th>
                <th>Empréstimo</th>
                <th>Devolução</th>
            </tr>
        </thead>

        <tbody>

        <!-- Loop para exibir cada registro encontrado no banco -->
        <?php while($row = $result->fetch_assoc()): ?>

            <tr>
                <td><?= $row['nome'] ?></td> <!-- Nome do aluno -->
                <td><?= $row['ra'] ?></td> <!-- RA -->
                <td><?= $row['turma'] ?></td> <!-- Turma -->
                <td><?= $row['livro'] ?></td> <!-- Nome do livro -->

                <td>
                    <!-- Define visualmente o status do empréstimo -->
                    <?php if($row['status'] == "andamento"): ?>
                        <span class="status em-andamento">Em andamento</span>

                    <?php elseif($row['status'] == "atraso"): ?>
                        <span class="status em-atraso">Em atraso</span>

                    <?php else: ?>
                        <span class="status">-</span> <!-- Quando não tem status -->
                    <?php endif; ?>
                </td>

                <!-- Formata as datas de AAAA-MM-DD para DD/MM/AAAA -->
                <td><?= date("d/m/Y", strtotime($row['data_emprestimo'])) ?></td>
                <td><?= date("d/m/Y", strtotime($row['data_devolucao'])) ?></td>
            </tr>

        <?php endwhile; ?>

        </tbody>
    </table>
</div>

</body>
</html>
