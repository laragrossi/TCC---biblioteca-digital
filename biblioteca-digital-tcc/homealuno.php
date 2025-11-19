<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna o site responsivo -->
    <title>Biblioteca Digital</title>
    
    <!-- Link para o pacote de ícones Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/homealuno.css">

</head>
<body>
    <!-- Cabeçalho com título e ícones -->
    <header>
        <h1>Biblioteca Digital</h1>
        <div class="icons">
            <i class="bi bi-house-door-fill" title="Início"></i>
            <i class="bi bi-bell-fill" id="notification-btn" title="Notificações"></i>
            <a href="dadosaluno.php"><i class="bi bi-person-fill" title="Perfil"></i></a>

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
            <!-- ✅ LINK ADICIONADO: Ao clicar na barra de pesquisa, vai para a página de pesquisa -->
            <input type="text" placeholder="Pesquisar livros, autores..." onclick="window.location.href='pesquisar_livros.php'">
        </div>
    </div>

    <!-- Botões principais -->
    <div class="main-buttons">
         <a href="meusemprestimos.php" class="btn"><i class="bi bi-book-half"></i><br>Meus empréstimos</a>
        <a href="dadosaluno.php" class="btn"><i class="bi bi-person-vcard-fill"></i><br>Dados Cadastrais</a>
        <!-- ✅ NOVO BOTÃO: Pesquisar Livros -->
        <a href="pesquisar_livros.php" class="btn"><i class="bi bi-search"></i><br>Pesquisar Livros</a>
    </div>

    <!-- Lista de livros em destaque -->
    <h2>Livros em Destaque</h2>
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
        // ✅ Opcional: Se quiser que a barra de pesquisa seja clicável
        document.querySelector('.search-box').addEventListener('click', function() {
            window.location.href = 'pesquisar_livros.php';
        });
    </script>
</body>
</html>