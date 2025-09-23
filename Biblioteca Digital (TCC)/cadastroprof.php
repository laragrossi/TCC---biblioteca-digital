<?php

    if(isset($_POST['submit']))
    {
       include_once('config.php');

       $nome = $_POST['nome'];
       $email = $_POST['email'];
       $senha = $_POST['senha'];
       $escola = $_POST['escola'];
       $cidade = $_POST['cidade'];

       $result = mysqli_query($conexao, "INSERT INTO tabela(nome,email,senha,escola,cidade) 
       VALUES ('$nome','$email','$senha','$escola','$cidade')");
    }

?>
<!DOCTYPE html>
<html lang="en"> <!-- Define o tipo de documento e a linguagem -->
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Deixa o site responsivo -->
    <title>Cadastro</title> <!-- Título da aba do navegador -->

    <!-- Link para o nosso arquivo de CSS personalizado -->
    <link rel="stylesheet" href="cadastroprof.css">
    </head>
<body>
    <!-- Caixa central -->
    <div class="box">
        <!-- Formulário de cadastro -->
        <form action="formulario.php" method="POST">
            <fieldset>
                <legend><b>Cadastro do Professor</b></legend> <!-- Título do formulário -->
                <br>

                <!-- Campo Nome -->
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome Completo</label>
                </div>
                <br><br>

                <!-- Campo Email -->
                <div class="inputBox">
                    <input type="text" name="email" id="email" class="inputUser" required>
                    <label for="email" class="labelInput">Email</label>
                </div>
                <br><br>

                <!-- Campo Senha -->
                <div class="inputBox">
                    <input type="text" name="senha" id="senha" class="inputUser" required>
                    <label for="senha" class="labelInput">Senha</label>
                </div>
                <br><br>

                <!-- Campo Confirmar Senha -->
                <div class="inputBox">
                    <input type="text" name="csenha" id="csenha" class="inputUser" required>
                    <label for="csenha" class="labelInput">Confirmar Senha</label>
                </div>
                <br><br>

                <!-- Campo Escola -->
                <div class="inputBox">
                    <input type="text" name="escola" id="escola" class="inputUser" required>
                    <label for="escola" class="labelInput">Escola</label>
                </div>
                <br><br>

                <!-- Campo Cidade -->
                <div class="inputBox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" required>
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>
                <br><br>

                <!-- Botão de cadastro -->
                <input type="submit" name="submit" id="submit" value="Cadastrar-se">
                <br><br>
                <a href="login-p-2.php" class="btn btn-secondary">Login</a>
            </fieldset>
        </form>
    </div>
</body>
</html>