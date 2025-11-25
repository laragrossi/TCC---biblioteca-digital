
<!DOCTYPE html>
<html lang="en"> <!-- Define o tipo de documento e a linguagem -->
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Deixa o site responsivo -->
    <title>Cadastro</title> <!-- Título da aba do navegador -->
    
    <!-- Link para o nosso arquivo de CSS personalizado -->
    <link rel="stylesheet" href="css/cadastroaluno.css">
</head>
<body>
    <!-- Caixa central -->
    <div class="box">
        <!-- Formulário de cadastro -->
        <form action="controladores/cadastro.php" method="POST">
            <fieldset>
                <legend><b>Cadastro do Aluno</b></legend> <!-- Título do formulário -->
                <br>

                <!-- Campo Nome -->
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome Completo</label>
                </div>
                <br><br>

                <!-- Campo RA -->
                <div class="inputBox">
                    <input type="text" name="ra" id="ra" class="inputUser" required>
                    <label for="ra" class="labelInput">RA</label>
                </div>
                <br><br>

                <!-- Campo Digito -->
                <div class="inputBox">
                    <input type="text" name="digito" id="digito" class="inputUser" required>
                    <label for="digito" class="labelInput">Digito</label>
                </div>
                <br><br>
                
                <!-- SÉRIE DO ALUNO -->
                 <label for="serie">Série:</label>
                 <select id="serie" name="serie" required>
                    <option value="">Selecione</option>
                    <option value="1º ano">1º ano</option>
                    <option value="2º ano">2º ano</option>
                    <option value="3º ano">3º ano</option>
                </select>
                
                <!-- TURMA DO ALUNO -->
                 <label for="turma">Turma:</label>
                 <select id="turma" name="turma" required>
                    <option value="">Selecione</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
                <br><br>
                
                <!-- Campo Senha -->
                <div class="inputBox">
                    <input type="password" name="senha" id="senha" class="inputUser" required>
                    <label for="senha" class="labelInput">Senha</label>
                </div>
                <br><br>

                <!-- Campo csenha -->
                <div class="inputBox">
                    <input type="password" name="csenha" id="csenha" class="inputUser" required>
                    <label for="csenha" class="labelInput">Confirmar Senha</label>
                </div>
                <br><br>

                <!-- Campo Escola -->
                <div class="inputBox">
                    <input type="text" name="escola" id="escola" class="inputUser" required>
                    <label for="escola" class="labelInput">Escola</label>
                </div>
                <br><br>

                <!-- Botão de cadastro -->
                <input type="submit" name="submit" class="btn" value="Cadastrar-se">
                <br><br>
                <a href="homeadm.php"><input type="button" name="submit" class="btn" value="Voltar"></a>          
            </fieldset>
        </form>
    </div>
</body>
</html>