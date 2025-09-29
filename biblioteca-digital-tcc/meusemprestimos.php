<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Empréstimos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="meusemprestimos.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-navbar px-3">
        <a class="navbar-brand fw-bold" href="#">Meus Empréstimos</a>
        <div class="ms-auto d-flex align-items-center position-relative">
            <i class="bi bi-search nav-icon" aria-label="Pesquisar"></i>
            <i class="bi bi-house nav-icon" aria-label="Página inicial"></i>
            <i class="bi bi-bell nav-icon" aria-label="Notificações"></i>
            
            <!-- Ícone da pessoa -->
            <i class="bi bi-person nav-icon" aria-label="Perfil" id="user-icon"></i>
            
            <!-- Menu do usuário -->
            <div id="user-menu" class="card custom-card position-absolute end-0 mt-3" style="width: 220px; display: none; z-index: 10;">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">Dados Cadastrais</h6>
                    <p class="mb-1"><strong>Nome:</strong> Giovana Rosa Greco</p>
                    <p class="mb-1"><strong>Email:</strong> giovana@example.com</p>
                    <hr>
                    <button class="btn btn-danger w-100" id="logout-btn">Sair da conta</button>
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
                            <h2 id="total-emprestimos">1</h2>
                            <p class="text-muted">Livro emprestado</p>
                        </div>
                        <i class="bi bi-book icon-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Livro emprestado -->
            <div class="col-12">
                <div class="card custom-card card-livro w-50" data-status="emprestado">
                    <div class="card-body d-flex align-items-center">
                        <img src="imagens/livros/o_cortiço_2.jpg" 
                             class="img-livro me-3" 
                             alt="Capa do livro O Cortiço">
                        <div>
                            <h6 class="mb-0">O Cortiço</h6>
                            <small class="text-muted">Aluísio de Azevedo</small>
                            <p class="mb-0">Data do empréstimo: <span>01/08/2025</span></p>
                            <p class="mb-0">Data de devolução: <span>01/09/2025</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Livro devolvido 1: O Pequeno Príncipe -->
            <div class="col-12">
                <div class="card custom-card card-livro w-50" data-status="devolvido" style="display: none;">
                    <div class="card-body d-flex align-items-center">
                        <img src="imagens/livros/o-pequeno-príncipe.jpg" 
                             class="img-livro me-3" 
                             alt="Capa do livro O Pequeno Príncipe">
                        <div>
                            <h6 class="mb-0">O Pequeno Príncipe</h6>
                            <small class="text-muted">Antoine de Saint-Exupéry</small>
                            <p class="mb-0">Data do empréstimo: <span>05/07/2025</span></p>
                            <p class="mb-0">Data de devolução: <span>05/08/2025</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Livro devolvido 2: O Alienista -->
            <div class="col-12">
                <div class="card custom-card card-livro w-50" data-status="devolvido" style="display: none;">
                    <div class="card-body d-flex align-items-center">
                        <img src="imagens/livros/o_alienista.jpg" 
                             class="img-livro me-3" 
                             alt="Capa do livro O Alienista">
                        <div>
                            <h6 class="mb-0">O Alienista</h6>
                            <small class="text-muted">Machado de Assis</small>
                            <p class="mb-0">Data do empréstimo: <span>10/06/2025</span></p>
                            <p class="mb-0">Data de devolução: <span>10/07/2025</span></p>
                        </div>
                    </div>
                </div>
            </div>

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

    <script src="meusemprestimos.js"></script>
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
