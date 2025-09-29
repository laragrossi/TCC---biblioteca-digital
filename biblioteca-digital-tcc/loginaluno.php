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
    <link rel="stylesheet" href="loginaluno.css">
</head>
<body>

    <!-- Container centraliza o conteúdo e d-flex ajuda no alinhamento -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        
        <!-- Cartão de login -->
        <div class="login-card text-center">
            
            <!-- Imagem/logo -->
            <img src="imagens/logotcc.png" alt="Logo" class="mb-3" width="90">
            
            
            <!-- Título e subtítulo -->
            <h5 class="fw-bold">Bem-vindo de volta</h5>
            <p class="text-muted mb-4">Entre com seus dados</p>

            <!-- Campo de RA -->
            <div class="mb-3 text-start">
                <label class="fw-bold">Digite seu RA</label> <!-- Rótulo do campo -->
                <div class="input-group">
    <input type="text" name="ra" placeholder="RA" class="input-ra">
    <input type="text" name="digito" placeholder="Dígito" class="input-digito">
</div>

            </div>
            <!-- Campo de Senha -->
            <div class="mb-3 text-start">
                <label class="fw-bold">Senha</label> <!-- Rótulo do campo -->
                <div class="input-group">
                    <input type="password" id="senha" class="form-control" placeholder="Digite sua senha">
                    <!-- Ícone de olho para mostrar/ocultar senha -->
                    <span class="input-group-text" id="toggleSenha">
                        <i class="bi bi-eye-fill"></i>
                    </span>
                </div>
            </div>

            <!-- Botões -->
            <div class="d-flex justify-content-between">
                <a href="cadastroaluno.php" class="btn btn-custom w-50 me-1">Cadastrar</a>
                <a href="homealuno.php" class="btn btn-custom w-50 ms-1">Entrar</a>
            </div>

            <!-- Link para recuperar senha -->
            <div class="mt-3">
                <a href="#" class="text-link">Esqueceu sua senha?</a>
            </div>
            <!-- Link para consultar RA -->
            <div class="mt-3">
                <a href="#" class="text-link">Esqueceu seu RA?</a>
            </div>
        </div>
    </div>

    <!-- Script do Bootstrap (necessário para algumas funções dele) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Nosso arquivo JavaScript -->
    <script src="script.js"> </script>

</body>
</html>