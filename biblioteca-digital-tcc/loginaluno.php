<?php
session_start();
include "conexao.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Juntar RA + Dígito
    $ra = trim($_POST['ra']) . '-' . trim($_POST['digito']);
    $senha = trim($_POST['senha']);

    if (empty($ra) || empty($senha)) {
        header("Location: loginaluno.php?erro=vazio");
        exit();
    }

    $sql = "SELECT * FROM login WHERE RA_Aluno = ? AND TipoUsuario = 'Aluno'";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $ra);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $dados = $result->fetch_assoc();

        if (password_verify($senha, $dados['Senha'])) {

            $_SESSION['AlunoID'] = $dados['IDLogin'];
            $_SESSION['RA'] = $dados['RA_Aluno'];

            header("Location: homealuno.php");
            exit();

        } else {
            header("Location: loginaluno.php?erro=senha");
            exit();
        }

    } else {
        header("Location: loginaluno.php?erro=invalido");
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
    <link rel="stylesheet" href="css/loginaluno.css">
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-card text-center">

            <img src="imagens/logotcc.png" alt="Logo" class="mb-3" width="90">
            <h5 class="fw-bold">Bem-vindo de volta</h5>
            <p class="text-muted mb-4">Entre com seus dados</p>

            <?php
            if (isset($_GET['mensagem']) && $_GET['mensagem'] === 'sucesso') {
                echo '<div class="alert alert-success" role="alert">Você foi cadastrado com sucesso!</div>';
            }

            if (isset($_GET['erro'])) {
                if ($_GET['erro'] === "vazio") {
                    echo '<div class="alert alert-danger">Preencha todos os campos!</div>';
                }
                if ($_GET['erro'] === "invalido") {
                    echo '<div class="alert alert-danger">RA não encontrado!</div>';
                }
                if ($_GET['erro'] === "senha") {
                    echo '<div class="alert alert-danger">Senha incorreta!</div>';
                }
                if ($_GET['erro'] === "proibido") {
                    echo '<div class="alert alert-warning">Faça login para acessar!</div>';
                }
            }
            ?>

            <!-- CORREÇÃO AQUI ↓ -->
            <form action="loginaluno.php" method="POST">

                <!-- Campo de RA -->
                <div class="mb-3 text-start">
                    <label class="fw-bold">Digite seu RA</label>
                    <div class="input-group">
                        <input type="text" name="ra" placeholder="RA" class="input-ra" required>
                        <input type="text" name="digito" placeholder="Dígito" class="input-digito" required>
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

            </form>

            <div class="mt-3">
                <a href="https://sed.educacao.sp.gov.br/NCA/CadastroAluno/ConsultaRAAluno/" class="text-link">Esqueceu seu RA?</a>
            </div>

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