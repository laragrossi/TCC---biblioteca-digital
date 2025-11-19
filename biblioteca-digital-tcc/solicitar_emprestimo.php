<?php
session_start();
include "conexaoconsulta.php";

if (!isset($_SESSION['AlunoID'])) {
    header("Location: loginaluno.php");
    exit();
}

if (isset($_POST['solicitar_emprestimo'])) {
    $livro_id = $_POST['livro_id'];
    $aluno_id = $_SESSION['AlunoID'];
    $ra_aluno = $_SESSION['RA'];
    $nome_aluno = $_SESSION['NomeAluno'];
    
    // Verificar se o livro está disponível
    $sql_check = "SELECT titulo, quantidade_disponivel FROM livros WHERE id = ?";
    $stmt_check = $conexao->prepare($sql_check);
    $stmt_check->bind_param("i", $livro_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $livro = $result_check->fetch_assoc();
    
    if ($livro && $livro['quantidade_disponivel'] > 0) {
        // Fazer o empréstimo
        $data_emprestimo = date('Y-m-d');
        $data_devolucao = date('Y-m-d', strtotime('+15 days'));
        
        $sql_emprestimo = "INSERT INTO emprestimo (RA_Aluno, IDLivro, DataEmprestimo, DataDevolucaoPrevista, Status) 
                          VALUES (?, ?, ?, ?, 'Ativo')";
        $stmt_emprestimo = $conexao->prepare($sql_emprestimo);
        $stmt_emprestimo->bind_param("siss", $ra_aluno, $livro_id, $data_emprestimo, $data_devolucao);
        
        if ($stmt_emprestimo->execute()) {
            // Atualizar quantidade disponível
            $sql_update = "UPDATE livros SET quantidade_disponivel = quantidade_disponivel - 1 WHERE id = ?";
            $stmt_update = $conexao->prepare($sql_update);
            $stmt_update->bind_param("i", $livro_id);
            $stmt_update->execute();
            
            // ✅ CORREÇÃO: Voltar para detalhes com mensagem de sucesso
            header("Location: detalhes_livros.php?id=$livro_id&sucesso=1");
            exit();
        } else {
            // Erro no empréstimo
            header("Location: detalhes_livros.php?id=$livro_id&erro=1");
            exit();
        }
    } else {
        // Livro indisponível
        header("Location: detalhes_livros.php?id=$livro_id&erro=indisponivel");
        exit();
    }
} else {
    // Se acessou sem dados POST
    header("Location: pesquisar_livros.php");
    exit();
}
?>