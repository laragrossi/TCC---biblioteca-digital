<?php
session_start();
include "conexaoconsulta.php";

// Verificar se o professor está logado
if (!isset($_SESSION['ProfessorID'])) {
    header("Location: loginprof.php");
    exit();
}

// Buscar livros do banco de dados
$livros = [];
$sql = "SELECT id, titulo, autor, foto, quantidade_disponivel 
        FROM livros 
        ORDER BY titulo";
$result = $conexao->query($sql);
if ($result) {
    $livros = $result->fetch_all(MYSQLI_ASSOC);
}

// Pesquisa
$termo_pesquisa = "";
if (isset($_GET['pesquisa']) && !empty(trim($_GET['pesquisa']))) {
    $termo_pesquisa = trim($_GET['pesquisa']);
    $sql = "SELECT id, titulo, autor, foto, quantidade_disponivel 
            FROM livros 
            WHERE titulo LIKE ? OR autor LIKE ? 
            ORDER BY titulo";
    $stmt = $conexao->prepare($sql);
    $termo_like = "%" . $termo_pesquisa . "%";
    $stmt->bind_param("ss", $termo_like, $termo_like);
    $stmt->execute();
    $result = $stmt->get_result();
    $livros = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Digital</title>
    
    <!-- Ícones Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/statusdedisponibilidade.css">
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background-color: #fff1e7;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #d87b6d;
        position: relative;
    }

    header h1 {
        font-size: 24px;
        color: #3b1f1f;
    }

    .icons {
        display: flex;
        gap: 15px;
        position: relative;
    }

    .icons i {
        font-size: 24px;
        color: #3b1f1f;
        cursor: pointer;
    }

    /* MENU DO USUÁRIO */
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

    .btn-logout {
        display: block;
        text-align: center;
        padding: 6px;
        background: #db7c6f;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        margin-top: 5px;
    }

    .btn-logout:hover {
        background-color: #c56f63;
    }

    .search-container {
        display: flex;
        justify-content: center;
        margin: 15px;
    }

    .search-box {
        display: flex;
        align-items: center;
        background: white;
        border-radius: 25px;
        padding: 8px 23px;
        width: 90%;
        max-width: 500px;
    }

    .search-box i {
        color: gray;
        font-size: 18px;
        margin-right: 10px;
    }

    .search-box input {
        border: none;
        outline: none;
        flex: 1;
        font-size: 16px;
        background: none;
    }

    h2 {
        margin-left: 20px;
        color: #3b1f1f;
    }

    .book-list {
        display: flex;
        justify-content: center;
        gap: 50px;
        padding: 0 20px 20px;
        flex-wrap: wrap;
    }

    .book {
        background-color: white;
        border-radius: 10px;
        padding: 10px;
        flex: 1 1 160px;
        max-width: 180px;
        text-align: center;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .book:hover {
        transform: translateY(-5px);
    }

    .book img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 5px;
    }

    .author {
        font-size: 12px;
        color: gray;
    }

    .status {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: bold;
        margin-top: 5px;
    }

    .disponivel {
        background: #d4edda;
        color: #155724;
    }

    .indisponivel {
        background: #f8d7da;
        color: #721c24;
    }
</style>

<body>
    <header>
        <h1>Biblioteca Digital</h1>
        <div class="icons">
            <!-- Voltar para a home do professor -->
            <a href="homeprof.php" title="Início">
                <i class="bi bi-house-door-fill"></i>
            </a>

            <!-- Perfil / Usuário -->
            <i class="bi bi-person-fill" id="user-icon" title="Perfil"></i>

            <!-- Menu do usuário -->
            <div id="user-menu">
                <hr>
                <a href="dadosprof.php" class="btn-logout">Perfil</a>
                <a href="logout.php" class="btn-logout">Sair</a>
            </div>
        </div>
    </header>

    <!-- Barra de pesquisa -->
    <div class="search-container">
        <div class="search-box">
            <form method="GET" action="statusdedisponibilidade.php" style="width: 100%; display: flex; align-items: center;">
                <i class="bi bi-search"></i>
                <input type="text" name="pesquisa" placeholder="Pesquisar livros, autores..." 
                       value="<?= htmlspecialchars($termo_pesquisa) ?>">
                <button type="submit" style="background: none; border: none; color: #666; cursor: pointer;">
                    <i class="bi bi-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>

    <h2>
        <?php if (!empty($termo_pesquisa)): ?>
            Resultados para: "<?= htmlspecialchars($termo_pesquisa) ?>"
        <?php else: ?>
            Livros disponíveis
        <?php endif; ?>
    </h2>

    <div class="book-list">
        <?php if (empty($livros)): ?>
            <div style="text-align: center; color: #666; font-size: 18px; margin-top: 50px; width: 100%;">
                <i class="bi bi-book" style="font-size: 48px; margin-bottom: 15px;"></i>
                <p><?php echo empty($termo_pesquisa) ? 'Nenhum livro cadastrado no sistema.' : 'Nenhum livro encontrado.' ?></p>
            </div>
        <?php else: ?>
            <?php foreach ($livros as $livro): ?>
                <div class="book" onclick="verDetalhes(<?= $livro['id'] ?>)">
                    <?php if (!empty($livro['foto'])): ?>
                        <img src="<?= $livro['foto'] ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>"
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTIwIiBoZWlnaHQ9IjE2MCIgdmlld0JveD0iMCAwIDEyMCAxNjAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMjAiIGhlaWdodD0iMTYwIiByeD0iOCIgZmlsbD0iI2Y4ZjlmYSIvPgo8cGF0aCBkPSJNNzUgNjBINDUgTTYwIDQ1Vjc1IiBzdHJva2U9IiM2Yzc1N2QiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+CjxwYXRoIGQ9Ik00NSA1MEg1NVY2MEg0NVoiIGZpbGw9IiM2Yzc1N2QiLz4KPC9zdmc+'">
                    <?php else: ?>
                        <div style="width: 100%; height: 200px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 5px; color: #6c757d;">
                            <i class="bi bi-book" style="font-size: 48px;"></i>
                        </div>
                    <?php endif; ?>

                    <p><strong><?= htmlspecialchars($livro['titulo']) ?></strong></p>
                    <p class="author"><?= htmlspecialchars($livro['autor']) ?></p>

                    <div class="status <?= $livro['quantidade_disponivel'] > 0 ? 'disponivel' : 'indisponivel' ?>">
                        <?= $livro['quantidade_disponivel'] > 0 ? 'Disponível' : 'Indisponível' ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script>
        const userIcon = document.getElementById('user-icon');
        const userMenu = document.getElementById('user-menu');

        userIcon.addEventListener('click', () => {
            userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', (e) => {
            if (!userMenu.contains(e.target) && e.target !== userIcon) {
                userMenu.style.display = 'none';
            }
        });

        function verDetalhes(id) {
            window.location.href = "detalhes_livros_prof.php?id=" + id;
        }
    </script>

</body>
</html>