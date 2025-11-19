<?php
session_start();
include "conexaoconsulta.php";  // ✅ MUDEI PARA conexaoconsulta.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $ra = trim($_POST['ra']);
    $digito = trim($_POST['digito']);
    $senha = trim($_POST['senha']);

    if (empty($ra) || empty($senha) || empty($digito)) {
        header("Location: loginaluno.php?erro=vazio");
        exit();
    }

    // Usar tabela ALUNO
    $ra_completo = $ra . '-' . $digito;
    
    $sql = "SELECT * FROM aluno WHERE ra_completo = ? AND ativo = true";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $ra_completo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $dados = $result->fetch_assoc();

        if (password_verify($senha, $dados['senha'])) {
            $_SESSION['AlunoID'] = $dados['id'];
            $_SESSION['RA'] = $dados['ra_completo'];
            $_SESSION['NomeAluno'] = $dados['nome'];
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