<?php
session_start();
include "conexaoconsulta.php";

// Verificar se o aluno está logado
if (!isset($_SESSION['AlunoID'])) {
    header("Location: loginaluno.php");
    exit();
}

// Buscar dados do aluno
$aluno_id = $_SESSION['AlunoID'];
$ra_aluno = $_SESSION['RA'];

// Buscar empréstimos do aluno
$sql_emprestimos = "SELECT e.*, l.titulo, l.autor, l.foto, l.editora 
                   FROM emprestimo e 
                   INNER JOIN livros l ON e.IDLivro = l.id 
                   WHERE e.RA_Aluno = ? 
                   ORDER BY e.DataEmprestimo DESC";
$stmt_emprestimos = $conexao->prepare($sql_emprestimos);
$stmt_emprestimos->bind_param("s", $ra_aluno);
$stmt_emprestimos->execute();
$result_emprestimos = $stmt_emprestimos->get_result();
$emprestimos = $result_emprestimos->fetch_all(MYSQLI_ASSOC);

// Contar totais
$total_emprestimos = count($emprestimos);
$emprestimos_ativos = 0;
$emprestimos_devolvidos = 0;

foreach ($emprestimos as $emp) {
    if ($emp['Status'] == 'Ativo') {
        $emprestimos_ativos++;
    } else {
        $emprestimos_devolvidos++;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Empréstimos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/meusemprestimos.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-navbar px-3">
        <a class="navbar-brand fw-bold" href="#">Meus Empréstimos</a>
        <div class="ms-auto d-flex align-items-center position-relative">
            <i class="bi bi-house nav-icon" aria-label="Página inicial"></i>
            <i class="bi bi-bell nav-icon" aria-label="Notificações"></i>
            
            <!-- Ícone da pessoa -->
            <i class="bi bi-person nav-icon" aria-label="Perfil" id="user-icon"></i>
            
            <!-- Menu do usuário -->
            <div id="user-menu" class="card custom-card position-absolute end-0 mt-0" style="width: 220px; display: none; z-index: 10;">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">Dados Cadastrais</h6>
                    <p class="mb-1"><strong>Nome:</strong> Giovana Rosa Greco</p>
                    <p class="mb-1"><strong>Email:</strong> giovana@example.com</p>
                    <hr>
                    <div class="d-flex gap-2">
                        <a href="dadosaluno.php" class="btn btn-dark">Perfil</a>
                        <a href="index.php" class="btn btn-dark">Sair</a>
                    </div>

                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row mb-3">
            <!-- Botões de filtro -->
            <div class="col text-end ">
                <button class="btn btn-todos" onclick="filtrar('todos')">Todos</button>
                <button class="btn btn-devolvidos" onclick="filtrar('devolvidos')">Devolvidos</button>
            </div>
        </div>
        <div class="row g-3">
            <!-- Card total de empréstimos -->
            <div class="col-12">
                <div class="card custom-card w-50">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold">Total de empréstimos</h5>
                            <h2 id="total-emprestimos"><?= $total_emprestimos ?></h2>
                            <p class="text-muted">Livro emprestado</p>
                        </div>
                        <i class="bi bi-book icon-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Lista de livros EMPRESTADOS (dinâmico) -->
            <?php if (empty($emprestimos)): ?>
                <div class="col-12">
                    <div class="card custom-card w-50">
                        <div class="card-body text-center">
                            <i class="bi bi-book" style="font-size: 48px; color: #6c757d;"></i>
                            <h5 class="mt-3">Nenhum empréstimo encontrado</h5>
                            <p class="text-muted">Você ainda não fez nenhum empréstimo</p>
                            <a href="pesquisar_livros.php" class="btn btn-primary">Buscar Livros</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($emprestimos as $emprestimo): ?>
                    <?php
                    $status = ($emprestimo['Status'] == 'Ativo') ? 'emprestado' : 'devolvido';
                    $data_emprestimo = date('d/m/Y', strtotime($emprestimo['DataEmprestimo']));
                    $data_devolucao = date('d/m/Y', strtotime($emprestimo['DataDevolucaoPrevista']));
                    ?>
                    <div class="col-12">
                        <div class="card custom-card card-livro w-50" data-status="<?= $status ?>">
                            <div class="card-body d-flex align-items-center">
                                <!-- Foto do livro - ✅ CORREÇÃO FEITA AQUI -->
                                <?php if (!empty($emprestimo['foto'])): ?>
                                    <img src="fotos_livros/<?= $emprestimo['foto'] ?>" 
                                         class="img-livro me-3" 
                                         alt="Capa do livro <?= htmlspecialchars($emprestimo['titulo']) ?>"
                                         style="width: 60px; height: 80px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="img-livro me-3 d-flex align-items-center justify-content-center bg-light" 
                                         style="width: 60px; height: 80px;">
                                        <i class="bi bi-book" style="font-size: 24px; color: #6c757d;"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><?= htmlspecialchars($emprestimo['titulo']) ?></h6>
                                    <small class="text-muted"><?= htmlspecialchars($emprestimo['autor']) ?></small>
                                    <p class="mb-0 mt-1"><small>Data do empréstimo: <span><?= $data_emprestimo ?></span></small></p>
                                    <p class="mb-0"><small>Data de devolução: <span><?= $data_devolucao ?></span></small></p>
                                    
                                    <!-- Status -->
                                    <?php if ($emprestimo['Status'] == 'Ativo'): ?>
                                        <span class="badge bg-success mt-1">Em Andamento</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary mt-1">Devolvido</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Informações da biblioteca -->
            <div class="col-md-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <h6 class="fw-bold">
                            <i class="bi bi-exclamation-circle me-2"></i>Informações da Biblioteca
                        </h6>
                        <p class="mb-1">Horário: Segunda a sexta, horário dos intervalos</p>
                        <p class="mb-1">Prazo de empréstimo: 1 mês</p>
                        <p class="mb-0">Renovações: 2x</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Função de filtro de livros
        function filtrar(tipo) {
            const cards = document.querySelectorAll(".card-livro");
            let totalVisiveis = 0;

            cards.forEach(card => {
                const status = card.getAttribute("data-status");

                if (tipo === "todos") {
                    if (status === "emprestado") {
                        card.style.display = "block";  // mostra apenas emprestados
                        totalVisiveis++;
                    } else {
                        card.style.display = "none";   // esconde os devolvidos
                    }
                } else if (tipo === "devolvidos") {
                    if (status === "devolvido") {
                        card.style.display = "block";  // mostra apenas devolvidos
                        totalVisiveis++;
                    } else {
                        card.style.display = "none";   // esconde os emprestados
                    }
                }
            });

            document.getElementById("total-emprestimos").textContent = totalVisiveis;
        }

        // Menu do usuário
        const userIcon = document.getElementById("user-icon");
        const userMenu = document.getElementById("user-menu");

        userIcon.addEventListener("click", () => {
            if (userMenu.style.display === "none") {
                userMenu.style.display = "block";
            } else {
                userMenu.style.display = "none";
            }
        });

        // Fechar menu ao clicar fora
        document.addEventListener("click", (e) => {
            if (!userMenu.contains(e.target) && e.target !== userIcon) {
                userMenu.style.display = "none";
            }
        });

        // Botão de logout
        document.getElementById("logout-btn").addEventListener("click", () => {
            alert("Você saiu da conta!");
            userMenu.style.display = "none";
        });
    </script>
</body>
</html>