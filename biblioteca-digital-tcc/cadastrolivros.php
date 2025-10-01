<!DOCTYPE html>
<html lang="en"> <!-- Define o tipo de documento e a linguagem -->
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Deixa o site responsivo -->
    <title>Cadastro</title> <!-- Título da aba do navegador -->
    
    <!-- Link para o nosso arquivo de CSS personalizado -->
    <link rel="stylesheet" href="cadastroaluno.css">
</head>
<body>
    <!-- Caixa central -->
    <div class="box">
        <!-- Formulário de cadastro -->
        <form action="controladores/cadastro.php" method="POST">
            <fieldset>
                <legend><b>Cadastro de Livros</b></legend> <!-- Título do formulário -->
                <br>

                <!-- Campo Nome -->
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Titulo</label>
                </div>
                <br><br>

                <!-- Campo RA -->
                <div class="inputBox">
                    <input type="text" name="ra" id="ra" class="inputUser" required>
                    <label for="ra" class="labelInput">Editora</label>
                </div>
                <br><br>

                <!-- Campo Digito -->
                <div class="inputBox">
                    <input type="text" name="digito" id="digito" class="inputUser" required>
                    <label for="digito" class="labelInput">Autor</label>
                </div>
                <br><br>

                <!-- Campo Senha -->
                <div class="inputBox">
                    <input type="text" name="senha" id="senha" class="inputUser" required>
                    <label for="senha" class="labelInput">Ano</label>
                </div>
                <br><br>
                <!-- Botão de cadastro -->
                <input type="submit" name="submit" class="btn" value="Cadastrar-se">
                <br><br>
                <a href="homeprof.php"><input type="button" name="submit" class="btn" value="Voltar"></a>          
            </fieldset>
        </form>
    </div>
</body>
</html>