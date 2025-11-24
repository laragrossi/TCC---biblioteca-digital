<?php
session_start();
include "conexaoconsulta.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($email) || empty($senha)) {
        header("Location: loginprof.php?erro=vazio");
        exit();
    }

    // Buscar na tabela correta
    $sql = "SELECT id, nome, senha FROM professor WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $dados = $resultado->fetch_assoc();

        // *** SEM CRIPTOGRAFIA ***
        if ($senha === $dados['senha']) {

            $_SESSION['ProfID'] = $dados['id'];
            $_SESSION['NomeProf'] = $dados['nome'];

            header("Location: homeprof.php");
            exit();
        } else {
            header("Location: loginprof.php?erro=senha");
            exit();
        }
    } else {
        header("Location: loginprof.php?erro=invalido");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/loginprof.css">
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="login-card text-center">

        <img src="imagens/logotcc.png" alt="Logo" class="mb-3" width="80">

        <h5 class="fw-bold">Bem-vindo de volta</h5>
        <p class="text-muted mb-4">Entre com seus dados</p>

        <?php
        if (isset($_GET['erro'])) {
            if ($_GET['erro'] === "vazio") {
                echo '<div class="alert alert-danger">Preencha todos os campos!</div>';
            }
            if ($_GET['erro'] === "invalido") {
                echo '<div class="alert alert-danger">Email não encontrado!</div>';
            }
            if ($_GET['erro'] === "senha") {
                echo '<div class="alert alert-danger">Senha incorreta!</div>';
            }
            if ($_GET['erro'] === "proibido") {
                echo '<div class="alert alert-warning">Faça login para acessar!</div>';
            }
        }
        ?>

        <!-- O formulário envia para ele mesmo -->
        <form action="loginprof.php" method="POST">

            <!-- Email -->
            <div class="mb-3 text-start">
                <label class="fw-bold">Digite seu email</label>
                <div class="input-group">
                    <input type="email" name="email" class="form-control" placeholder="Digite seu email" required>
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                </div>
            </div>

            <!-- Senha -->
            <div class="mb-3 text-start">
                <label class="fw-bold">Senha</label>
                <div class="input-group">
                    <input type="password" id="senha" name="senha" class="form-control" placeholder="Digite sua senha" required>
                    <span class="input-group-text" id="toggleSenha">
                        <i class="bi bi-eye-fill"></i>
                    </span>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-custom w-100 ms-1">Entrar</button>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <a href="index.php" class="btn-voltar">Voltar</a>
            </div>

            <div class="mt-3">
                <a href="recuperacaosenhaprof.php" class="text-link">Esqueceu sua senha?</a>
            </div>

        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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