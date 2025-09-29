<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna o site responsivo -->
    <title>Biblioteca Digital</title>
    
    <!-- Link para o pacote de ícones Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <style>
        /* Estilo geral do corpo da página */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #fff1e7;
        }

        /* Cabeçalho principal */
        header {
            display: flex; /* Elementos lado a lado */
            justify-content: space-between; /* Espaço entre título e ícones */
            align-items: center; /* Centraliza verticalmente */
            padding: 10px 20px;
            background-color: #db8a80;
            position: relative;
        }

        /* Título do cabeçalho */
        header h1 {
            font-size: 24px;
            color: #3b1f1f;
        }

        /* Container dos ícones no cabeçalho */
        .icons {
            display: flex;
            gap: 15px; /* Espaçamento entre ícones */
            position: relative;
        }

        /* Estilo dos ícones */
        .icons i {
            font-size: 24px;
            color: #3b1f1f;
            cursor: pointer; /* Muda o cursor ao passar */
        }

        /* Caixa de notificações */
        .notification-box {
            display: none; /* Escondida por padrão */
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

        /* Setinha da caixa de notificações */
        .notification-box::before {
            content: "";
            position: absolute;
            top: -10px;
            right: 15px;
            border-width: 10px;
            border-style: solid;
            border-color: transparent transparent #f8c7b1 transparent;
        }

        /* Título da caixa de notificações */
        .notification-title {
            font-weight: bold;
            margin-bottom: 5px;
            border-bottom: 1px solid rgba(0,0,0,0.2);
            padding-bottom: 5px;
        }

        /* Conteúdo das notificações */
        .notification-content {
            background-color: #ffe4d6;
            border-radius: 5px;
            padding: 5px;
            font-size: 14px;
        }

        /* Container da barra de pesquisa */
        .search-container {
            display: flex;
            justify-content: center;
            margin: 15px;
        }

        /* Estilo da barra de pesquisa */
        .search-box {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 25px;
            padding: 8px 23px;
            width: 90%;
            max-width: 500px;
        }

        /* Ícone de lupa dentro da pesquisa */
        .search-box i {
            color: gray;
            font-size: 18px;
            margin-right: 10px;
        }

        /* Campo de entrada de texto da pesquisa */
        .search-box input {
            border: none;
            outline: none;
            flex: 1;
            font-size: 16px;
            background: none;
        }

        /* Botões principais */
        .main-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Estilo dos botões */
        .btn {
            background-color: #d36b5e;
            color: white;
            padding: 25px 40px;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            width: 180px;
        }

        /* Subtítulos da página */
        h2 {
            margin-left: 20px;
            color: #3b1f1f;
        }

        /* Lista de livros */
        .book-list {
            display: flex;
            justify-content: center;
            gap: 50px;
            padding: 0 20px 20px;
            flex-wrap: wrap; /* Permite quebrar linha */
        }

        /* Estilo de cada livro */
        .book {
            background-color: white;
            border-radius: 10px;
            padding: 10px;
            flex: 1 1 160px;
            max-width: 180px;
            text-align: center;
        }

        /* Imagem do livro */
        .book img {
            width: 100%;
            border-radius: 5px;
        }

        /* Nome do livro */
        .book p {
            margin: 5px 0 0;
            font-size: 14px;
        }

        /* Nome do autor */
        .author {
            font-size: 12px;
            color: gray;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho com título e ícones -->
    <header>
        <h1>Biblioteca Digital</h1>
        <div class="icons">
            <i class="bi bi-house-door-fill" title="Início"></i>
            <i class="bi bi-bell-fill" id="notification-btn" title="Notificações"></i>
            <i class="bi bi-person-fill" title="Perfil"></i>

            <!-- Caixa de Notificações -->
            <div class="notification-box" id="notification-box">
                <div class="notification-title">Notificações</div>
                <div class="notification-content">
                    Empréstimo em atraso<br>
                    Livro: Dom Casmurro<br>
                    Data: xx/xx/xxxx
                </div>
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

    <!-- Lista de livros em destaque -->
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

    <!-- Script para abrir/fechar caixa de notificações -->
    <script>
        const notificationBtn = document.getElementById('notification-btn'); // Botão do sino
        const notificationBox = document.getElementById('notification-box'); // Caixa de notificações

        // Ao clicar no sino, mostra/esconde a caixa
        notificationBtn.addEventListener('click', () => {
            notificationBox.style.display = notificationBox.style.display === 'block' ? 'none' : 'block';
        });

        // Fecha a caixa se clicar fora dela
        document.addEventListener('click', (event) => {
            if (!notificationBtn.contains(event.target) && !notificationBox.contains(event.target)) {
                notificationBox.style.display = 'none';
            }
        });
    </script>
</body>
</html>