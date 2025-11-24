<?php
session_start();
include "conexaoconsulta.php";

if (!isset($_SESSION['AlunoID'])) {
    header("Location: loginaluno.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("ID do empréstimo não informado.");
}

$id = intval($_GET['id']);

// Atualiza o banco — marca como devolvido
$sql = "UPDATE emprestimo 
        SET Status = 'Devolvido',
            DataDevolucaoReal = CURDATE()
        WHERE IDEmprestimo = ?";

$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: meusemprestimos.php?ok=1");
    exit();
} else {
    echo "Erro ao registrar devolução.";
}
?>
