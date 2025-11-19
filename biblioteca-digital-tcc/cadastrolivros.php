<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Livros</title>
    <link rel="stylesheet" href="css/cadastrolivros.css">
</head>
<body>
    <div class="login-card">
        <!-- ATUALIZE O FORM PARA ENCTYPE -->
        <form action="conexaoDelivros.php" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend><b>Cadastro de Livros</b></legend>
                <br>

                <?php if (isset($_GET['sucesso'])): ?>
                    <div style="color: green; margin-bottom: 15px;">Livro cadastrado com sucesso!</div>
                <?php endif; ?>

                <!-- Campo Número de tombo -->
                <div class="inputBox">
                    <input type="text" name="numero_tombo" id="numero_tombo" class="inputUser" required>
                    <label for="numero_tombo" class="labelInput">Número de tombo</label>
                </div>
                <br><br>

                <!-- Campo ISBN -->
                <div class="inputBox">
                    <input type="text" name="isbn" id="isbn" class="inputUser" required>
                    <label for="isbn" class="labelInput">ISBN</label>
                </div>
                <br><br>

                <!-- Campo Título -->
                <div class="inputBox">
                    <input type="text" name="titulo" id="titulo" class="inputUser" required>
                    <label for="titulo" class="labelInput">Título</label>
                </div>
                <br><br>

                <!-- Campo Subtítulo -->
                <div class="inputBox">
                    <input type="text" name="subtitulo" id="subtitulo" class="inputUser">
                    <label for="subtitulo" class="labelInput">Subtítulo</label>
                </div>
                <br><br>

                <!-- Campo Sinopse -->
                <div class="inputBox">
                    <textarea name="sinopse" id="sinopse" class="inputUser" required></textarea>
                    <label for="sinopse" class="labelInput">Sinopse</label>
                </div>
                <br><br>

                <!-- Campo Autor -->
                <div class="inputBox">
                    <input type="text" name="autor" id="autor" class="inputUser" required>
                    <label for="autor" class="labelInput">Autor</label>
                </div>
                <br><br>

                <!-- Campo Editora -->
                <div class="inputBox">
                    <input type="text" name="editora" id="editora" class="inputUser" required>
                    <label for="editora" class="labelInput">Editora</label>
                </div>
                <br><br>

                <!-- Campo Ano de publicação -->
                <div class="inputBox">
                    <input type="number" name="ano_publicacao" id="ano_publicacao" class="inputUser" required>
                    <label for="ano_publicacao" class="labelInput">Ano de publicação</label>
                </div>
                <br><br>

                <!-- Campo Número de páginas -->
                <div class="inputBox">
                    <input type="number" name="numero_paginas" id="numero_paginas" class="inputUser" required>
                    <label for="numero_paginas" class="labelInput">Número de páginas</label>
                </div>
                <br><br>

                <!-- Campo Idioma -->
                <div class="inputBox">
                    <input type="text" name="idioma" id="idioma" class="inputUser" required>
                    <label for="idioma" class="labelInput">Idioma</label>
                </div>
                <br><br>

                <!-- Campo Gênero -->
                <div class="inputBox">
                    <input type="text" name="genero" id="genero" class="inputUser" required>
                    <label for="genero" class="labelInput">Gênero</label>
                </div>
                <br><br>

                <!-- Campo Área de conhecimento -->
                <div class="inputBox">
                    <input type="text" name="area_conhecimento" id="area_conhecimento" class="inputUser" required>
                    <label for="area_conhecimento" class="labelInput">Área de conhecimento</label>
                </div>
                <br><br>

                <!-- CAMPO NOVO: Foto do Livro -->
                <div class="inputBox">
                    <input type="file" name="foto" id="foto" class="inputUser" accept="image/*">
                    <label for="foto" class="labelInput">Foto do Livro</label>
                </div>
                <br><br>

                <!-- Botão de cadastro -->
                <input type="submit" name="submit" class="btn" value="Cadastrar Livro">
                <br><br>
                <a href="homeadm.php"><input type="button" class="btn" value="Voltar"></a>          
            </fieldset>
        </form>
    </div>
</body>
</html>