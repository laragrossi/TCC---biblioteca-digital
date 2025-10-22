<?php
include('conexao.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM administrador WHERE email = '$email' AND senha = '$senha'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        header("Location: homeadm.php");
        exit;
    } else {
        echo "<div class='alert alert-danger text-center'>Email ou senha incorretos!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login do Administrador</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Ícones Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="css/loginprof.css">
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-card text-center">
            
            <!-- Logo -->
            <img src="imagens/logotcc.png" alt="Logo" class="mb-3" width="80">

            <!-- Título -->
            <h5 class="fw-bold">Bem-vindo de volta</h5>
            <p class="text-muted mb-4">Entre com seus dados de administrador</p>

            <!-- Mensagem de sucesso (exemplo de cadastro anterior) -->
            <?php
            if (isset($_GET['mensagem']) && $_GET['mensagem'] === 'sucesso') {
                echo '<div class="alert alert-success" role="alert">Você foi cadastrado com sucesso!</div>';
            }

            if (isset($erro)) {
                echo "<div class='alert alert-danger' role='alert'>$erro</div>";
            }
            ?>

            <!-- Formulário funcional -->
            <form method="POST">
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

                <!-- Botões -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-custom w-50 ms-1">Entrar</button>
                </div>
            </form>

            <!-- Link de recuperação -->
            <div class="mt-3">
                <a href="recuperacaosenha.php" class="text-link">Esqueceu sua senha?</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Mostrar/Ocultar senha -->
    <script>
    const toggleSenha = document.getElementById('toggleSenha');
    const senha = document.getElementById('senha');

    toggleSenha.addEventListener('click', () => {
        if (senha.type === 'password') {
            senha.type = 'text';
            toggleSenha.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
        } else {
            senha.type = 'password';
            toggleSenha.innerHTML = '<i class="bi bi-eye-fill"></i>';
        }
    });
    </script>

</body>
</html>
