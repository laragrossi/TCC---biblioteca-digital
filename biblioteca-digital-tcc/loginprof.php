<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Faz o site se ajustar em celulares -->
    <title>Página de Login</title>
    
    <!-- Link do Bootstrap CSS para usar classes prontas de layout e design -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Link para os ícones do Bootstrap (para usar o ícone de email e olho) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Link para o nosso arquivo de CSS personalizado -->
    <link rel="stylesheet" href="css/loginprof.css">
    
</head>
<body>

    <!-- Container centraliza o conteúdo e d-flex ajuda no alinhamento -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        
        <!-- Cartão de login -->
        <div class="login-card text-center">
            
 <!-- Imagem/logo -->
            <img src="imagens/logotcc.png" alt="Logo" class="mb-3" width="80">
            
            <!-- Título e subtítulo -->
            <h5 class="fw-bold">Bem-vindo de volta</h5>
            <p class="text-muted mb-4">Entre com seus dados</p>

        <?php
if (isset($_GET['mensagem']) && $_GET['mensagem'] === 'sucesso') {
    echo '<div class="alert alert-success" role="alert">Você foi cadastrado com sucesso!</div>';
}
?>

           <form action="homeprof.php" method="POST">

    <!-- Campo de Email -->
    <div class="mb-3 text-start">
        <label class="fw-bold">Digite seu email</label>
        <div class="input-group">
            <input type="email" name="email" class="form-control" placeholder="Digite seu email" required>
            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
        </div>
    </div>

    <!-- Campo de Senha -->
    <div class="mb-3 text-start">
        <label class="fw-bold">Senha</label>
        <div class="input-group">
            <input type="password" id="senha" name="senha" class="form-control" placeholder="Digite sua senha" required>
            <span class="input-group-text" id="toggleSenha">
                <i class="bi bi-eye-fill"></i>
            </span>
        </div>
    </div>
    <!-- Botão Entrar -->
                 <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-custom w-100 ms-1">Entrar</button>
                </div>
               <!-- Botão Voltar -->
                <div class="d-flex justify-content-center mt-3">
                    <a href="index.php" class="btn-voltar">Voltar</a>
                </div>




            <!-- Link para recuperar senha -->
            <div class="mt-3">
                <a href="recuperacaosenha.php" class="text-link">Esqueceu sua senha?</a>
            </div>
        </div>
    </div>

    <!-- Script do Bootstrap (necessário para algumas funções dele) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Nosso arquivo JavaScript -->
    <script>
        // Pega o elemento do ícone do olho
const toggleSenha = document.getElementById('toggleSenha');

// Pega o campo da senha
const senha = document.getElementById('senha');

// Quando clicar no ícone, executa essa função
toggleSenha.addEventListener('click', () => {
    // Se o tipo do campo for "password" troca para "text" (mostra senha)
    if (senha.type === 'password') {
        senha.type = 'text';
        // Muda o ícone para o olho fechado
        toggleSenha.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
    } 
    // Se já estiver como texto, troca de volta para "password"
    else {
        senha.type = 'password';
        // Muda o ícone para o olho aberto
        toggleSenha.innerHTML = '<i class="bi bi-eye-fill"></i>';
    }
});
    </script>

</body>
</html>