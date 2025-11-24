<?php
session_start();
include "conexaoconsulta.php";

if (!isset($_SESSION['AlunoID'])) {
    header("Location: loginaluno.php");
    exit();
}

// Buscar empréstimos do aluno
$ra = $_SESSION['RA']; // seu identificador do aluno
$sql = "SELECT e.IDEmprestimo, e.RA_Aluno, e.IDLivro, e.DataEmprestimo, e.DataDevolucaoPrevista, e.DataDevolucaoReal, e.Status,
               l.titulo, l.autor, l.foto, l.id AS livro_id
        FROM emprestimo e
        INNER JOIN livros l ON e.IDLivro = l.id
        WHERE e.RA_Aluno = ?
        ORDER BY e.DataEmprestimo DESC";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $ra);
$stmt->execute();
$result = $stmt->get_result();
$emprestimos = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Meus Empréstimos</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="css/meusemprestimos.css">
</head>

<body>

<!-- NAVBAR  -->
<header>
    <h1>Biblioteca</h1>

    <div class="icons">
        <a href="homealuno.php" class="icon-link">
            <i class="bi bi-house-door-fill" title="Início"></i>
        </a>

        <a href="dadosaluno.php" class="icon-link">
            <i class="bi bi-person-fill" title="Perfil"></i>
        </a>
    </div>
</header>

<!-- FILTROS -->
<div class="filter-container">
    <a href="meusemprestimos.php" class="btn active">Todos</a>
    <a href="devolvidos.php" class="btn">Devolvidos</a>
</div>

<!-- CONTEÚDO PRINCIPAL -->
<main>

    <!-- CARD TOTAL -->
    <div class="total-card">
        <div>
            <h2>Total de empréstimos</h2>
            <p class="number"><?= count($emprestimos) ?></p>
            <p class="label">Livro(s) emprestado(s)</p>
        </div>
        <i class="bi bi-book icon-big"></i>
    </div>

    <?php if (empty($emprestimos)): ?>
        <div style="text-align: center; padding: 40px; color: #666;">
            <i class="bi bi-inbox" style="font-size: 48px; margin-bottom: 15px;"></i>
            <p>Você não possui empréstimos no momento</p>
            <a href="pesquisar_livros.php" style="color: #007bff; text-decoration: none;">
                Buscar livros para empréstimo
            </a>
        </div>
    <?php else: ?>
        <?php foreach ($emprestimos as $emprestimo): ?>
            <?php
                // Datas (verifica se existem antes de formatar)
                $dataEmp = !empty($emprestimo['DataEmprestimo']) ? date('d/m/Y', strtotime($emprestimo['DataEmprestimo'])) : null;
                $dataPrev = !empty($emprestimo['DataDevolucaoPrevista']) ? date('d/m/Y', strtotime($emprestimo['DataDevolucaoPrevista'])) : null;

                // Status legível
                $statusLabel = '';
                if (isset($emprestimo['Status'])) {
                    $s = strtolower($emprestimo['Status']);
                    if (in_array($s, ['ativo','emprestado','em-andamento'])) $statusLabel = 'Em andamento';
                    elseif (in_array($s, ['devolvido','concluido','concluído'])) $statusLabel = 'Concluído';
                    else $statusLabel = ucfirst($emprestimo['Status']);
                }
            ?>
            <div class="loan-card">
                <img src="<?= !empty($emprestimo['foto']) ? htmlspecialchars($emprestimo['foto']) : 'https://via.placeholder.com/120x170?text=Sem+Capa' ?>" alt="Capa do livro">

                <div class="info">
                    <h3><?= htmlspecialchars($emprestimo['titulo']) ?></h3>
                    <p><strong>Autor:</strong> <?= htmlspecialchars($emprestimo['autor']) ?></p>

                    <?php if ($dataEmp): ?>
                        <p><strong>Data do empréstimo:</strong> <?= $dataEmp ?></p>
                    <?php else: ?>
                        <p><strong>Data do empréstimo:</strong> —</p>
                    <?php endif; ?>

                    <?php if ($dataPrev): ?>
                        <p><strong>Data de devolução:</strong> <?= $dataPrev ?></p>
                    <?php else: ?>
                        <p><strong>Data de devolução:</strong> —</p>
                    <?php endif; ?>

                    <p><strong>Status:</strong> <?= htmlspecialchars($statusLabel) ?></p>

                    <?php if ($emprestimo['Status'] === 'Ativo'): ?>
                        <a href="devolver.php?id=<?= $emprestimo['IDEmprestimo'] ?>"
                           style="display:inline-block; margin-top:10px; padding:8px 14px;
                                  background:#c0392b; color:white; border-radius:6px;
                                  font-weight:bold; text-decoration:none;">
                            Devolver
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- CARD INFORMAÇÕES -->
    <div class="info-card">
        <h3><i class="bi bi-info-circle"></i> Informações da Biblioteca</h3>
        <p>🕒 Segunda a sexta, horário dos intervalos</p>
        <p>📚 Prazo de empréstimo: 15 dias</p>
    </div>

</main>

<script>
    // busca e filtro (mantive seu JS, caso já use)
    document.getElementById('searchInput')?.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const cards = document.getElementById('emprestimosContainer')?.getElementsByClassName('loan-card') || [];
        Array.from(cards).forEach(card => {
            const titulo = card.querySelector('.info h3')?.innerText.toLowerCase() || '';
            card.style.display = titulo.includes(searchTerm) ? 'flex' : 'none';
        });
    });

    function filterEmprestimos(status) {
        // implementar se precisar
    }
</script>
</body>
</html>
