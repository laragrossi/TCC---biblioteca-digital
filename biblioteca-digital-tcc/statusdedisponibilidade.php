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
    }

    .book img {
        width: 100%;
        border-radius: 5px;
    }

    .author {
        font-size: 12px;
        color: gray;
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
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Pesquisar livros, autores...">
        </div>
    </div>

    <h2>Livros disponíveis</h2>
    <div class="book-list">
        <div class="book">
            <img src="imagens/livros/dom_casmurro.webp" alt="Dom Casmurro">
            <p>Dom Casmurro</p>
            <p class="author">Machado de Assis</p>
        </div>
        <div class="book">
            <img src="imagens/livros/o_cortiço_2.jpg" alt="O Cortiço">
            <p>O Cortiço</p>
            <p class="author">Aluísio Azevedo</p>
        </div>
        <div class="book">
            <img src="imagens/livros/O-pequeno-príncipe.jpg" alt="O Pequeno Príncipe">
            <p>O Pequeno Príncipe</p>
            <p class="author">Antoine de Saint-Exupéry</p>
        </div>
        <div class="book">
            <img src="imagens/livros/o_alienista.jpg" alt="O Alienista">
            <p>O Alienista</p>
            <p class="author">Machado de Assis</p>
        </div>
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
    </script>

</body>
</html>
