<?php
include "db.php"; // conexão com o banco

// Buscar todos os empréstimos
$sql = "SELECT nome, ra, turma, livro, status, data_emprestimo, data_devolucao FROM emprestimos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Consulta de Alunos</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/consulta.css">

</head>
<body>

<header>
    <h1>Empréstimos ativos</h1>
    <div class="icons">
        <a href="homealuno.php"><i class="bi bi-house-door"></i></a>
        <i class="bi bi-bell"></i>
        <a href="dadosaluno.php"><i class="bi bi-person"></i></a>
    </div>
</header>

<div class="search-container">
    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Procurar alunos">
    </div>
</div>

<div class="filter-buttons">
    <button class="filter-btn active">Todos</button>
    <a href="atrasadosaluno.php" class="filter-btn disabled">Atrasados</a>
</div>

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

        <?php while($row = $result->fetch_assoc()): ?>

            <tr>
                <td><?= $row['nome'] ?></td>
                <td><?= $row['ra'] ?></td>
                <td><?= $row['turma'] ?></td>
                <td><?= $row['livro'] ?></td>

                <td>
                    <?php if($row['status'] == "andamento"): ?>
                        <span class="status em-andamento">Em andamento</span>
                    <?php elseif($row['status'] == "atraso"): ?>
                        <span class="status em-atraso">Em atraso</span>
                    <?php else: ?>
                        <span class="status">-</span>
                    <?php endif; ?>
                </td>

                <td><?= date("d/m/Y", strtotime($row['data_emprestimo'])) ?></td>
                <td><?= date("d/m/Y", strtotime($row['data_devolucao'])) ?></td>
            </tr>

        <?php endwhile; ?>

        </tbody>
    </table>
</div>

</body>
</html>
