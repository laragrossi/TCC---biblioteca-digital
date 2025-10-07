<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>

    <!-- Bootstrap e ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="loginprof.css">
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="login-card text-center shadow">
        
        <!-- Logo -->
        <img src="imagens/logotcc.png" alt="Logo" class="mb-3" width="80">
        
        <!-- Título -->
        <h5 class="fw-bold">Recuperar Senha</h5>
        <p class="text-muted mb-4">Digite seu email e crie uma nova senha</p>

        <!-- Mensagem de sucesso/erro -->
        <?= $mensagem ?>

        <!-- Formulário -->
        <form method="POST" action="">
            <!-- Campo Email -->
            <div class="mb-3 text-start">
                <label class="fw-bold">Email</label>
                <div class="input-group">
                    <input type="email" name="email" class="form-control" placeholder="Digite seu email" required>
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                </div>
            </div>

            <!-- Campo Nova Senha -->
            <div class="mb-3 text-start">
                <label class="fw-bold">Nova Senha</label>
                <div class="input-group">
                    <input type="password" name="nova_senha" id="nova_senha" class="form-control" placeholder="Digite sua nova senha" required>
                    <span class="input-group-text" id="toggleSenha">
                        <i class="bi bi-eye-fill"></i>
                    </span>
                </div>
            </div>

            <!-- Botão -->
            <button type="submit" class="btn btn-custom w-100 mt-2">Atualizar Senha</button>
        </form>

        <!-- Voltar ao login -->
        <div class="mt-3">
            <a href="loginprof.php" class="text-link">Voltar para o login</a>
        </div>
    </div>
</div>

<!-- Script do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Mostrar/Ocultar Senha -->
<script>
    document.getElementById('toggleSenha').addEventListener('click', function() {
        const senhaInput = document.getElementById('nova_senha');
        const icon = this.querySelector('i');
        if (senhaInput.type === 'password') {
            senhaInput.type = 'text';
            icon.classList.remove('bi-eye-fill');
            icon.classList.add('bi-eye-slash-fill');
        } else {
            senhaInput.type = 'password';
            icon.classList.remove('bi-eye-slash-fill');
            icon.classList.add('bi-eye-fill');
        }
    });
</script>

</body>
</html>
