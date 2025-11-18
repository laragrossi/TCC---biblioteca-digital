<?php
if (isset($_POST['submit'])) {
    include_once('../config.php');

    if (isset($_POST['ra'])) {
        // ✅ CADASTRO DO ALUNO CORRIGIDO
        $nome = $_POST['nome'];
        $ra = $_POST['ra'];
        $digito = $_POST['digito'];
        $senha = $_POST['senha'];
        $escola = $_POST['escola'];
        
        // Criptografar senha do aluno
        $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);
        
        // Juntar RA + Dígito
        $ra_completo = $ra . '-' . $digito;

        $result = mysqli_query($conexao, "INSERT INTO aluno(nome, ra, digito, senha, escola, ra_completo) 
            VALUES ('$nome', '$ra', '$digito', '$senha_criptografada', '$escola', '$ra_completo')");
        
        if ($result) {
            header('Location: ../loginaluno.php?mensagem=sucesso');
        } else {
            die("Erro no cadastro do aluno: " . mysqli_error($conexao));
        }
        exit();
        
    } else {
        // ✅ CADASTRO DO PROFESSOR CORRIGIDO
        $nome = $_POST['nome'];
        $cidade = $_POST['cidade'];
        $escola = $_POST['escola'];
        
        // ✅ EMAIL E SENHA FIXOS
        $email_fixo = "professor@biblioteca.com";
        $senha_fixa = "prof123";
        
        // Criptografar senha fixa
        $senha_criptografada = password_hash($senha_fixa, PASSWORD_DEFAULT);

        $result = mysqli_query($conexao, "INSERT INTO professor(nome, email, senha, escola, cidade) 
            VALUES ('$nome', '$email_fixo', '$senha_criptografada', '$escola', '$cidade')");
        
        if ($result) {
            header('Location: ../loginprof.php?mensagem=sucesso');
        } else {
            die("Erro no cadastro do professor: " . mysqli_error($conexao));
        }
        exit();
    }
}
?>