<?php
session_start();
include "conexaoconsulta.php";

if (!isset($_SESSION['AlunoID'])) {
    header("Location: loginaluno.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: pesquisar_livros.php");
    exit();
}

$livro_id = intval($_GET['id']);
$sql = "SELECT * FROM livros WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $livro_id);
$stmt->execute();
$result = $stmt->get_result();
$livro = $result->fetch_assoc();

if (!$livro) {
    die("Livro não encontrado.");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $aluno_id = $_SESSION["AlunoID"];
    $livro_id = intval($_POST["livro_id"]);

    // Verificar disponibilidade
    $sql = "SELECT quantidade_disponivel FROM livros WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $livro_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $livro = $result->fetch_assoc();

    if (!$livro || $livro["quantidade_disponivel"] < 1) {
        header("Location: detalhes_livro.php?id=$livro_id&erro=indisponivel");
        exit();
    }

    // Inserir empréstimo
    $sql = "INSERT INTO emprestimos (id_aluno, id_livro, data_emprestimo, data_prevista_devolucao, status)
            VALUES (?, ?, NOW(), DATE_ADD(NOW(), INTERVAL 15 DAY), 'emprestado')";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ii", $aluno_id, $livro_id);
    $stmt->execute();

    // Atualizar quantidade disponível
    $sql = "UPDATE livros SET quantidade_disponivel = quantidade_disvenivel - 1 WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $livro_id);
    $stmt->execute();

    header("Location: detalhes_livro.php?id=$livro_id&sucesso=1");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($livro['titulo']) ?> - Detalhes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/homealuno.css">
</head>
<body>
    <header>
        <h1>Detalhes do Livro</h1>
        <div class="icons">
            <a href="pesquisar_livros.php"><i class="bi bi-arrow-left" title="Voltar"></i></a>
            <a href="homealuno.php"><i class="bi bi-house-door-fill" title="Início"></i></a>
        </div>
    </header>

    <div style="padding: 20px; max-width: 800px; margin: 0 auto;">
        <!-- ✅ MENSAGENS DE SUCESSO/ERRO -->
        <?php if (isset($_GET['sucesso'])): ?>
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                ✅ <strong>Empréstimo realizado com sucesso!</strong><br>
                Você tem 15 dias para devolver o livro.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['erro'])): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                ❌ <strong>Erro ao realizar empréstimo!</strong><br>
                <?= $_GET['erro'] == 'indisponivel' ? 'Livro indisponível no momento.' : 'Tente novamente.' ?>
            </div>
        <?php endif; ?>

       <div style="display: flex; gap: 30px; margin-bottom: 30px;">
    <!-- Foto do Livro -->
    <div>
        <?php if (!empty($livro['foto'])): ?>
            <!-- ✅ CORREÇÃO DEFINITIVA: Removido "fotos_livros/" duplicado -->
            <img src="<?= $livro['foto'] ?>" alt="<?= htmlspecialchars($livro['titulo']) ?>" 
                 style="width: 200px; height: 280px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
        <?php else: ?>
            <div style="width: 200px; height: 280px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 8px; border: 1px solid #ddd;">
                <i class="bi bi-book" style="font-size: 48px; color: #6c757d;"></i>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Informações -->
    <div style="flex: 1;">
        <h2 style="margin: 0 0 10px 0;"><?= htmlspecialchars($livro['titulo']) ?></h2>
        <?php if (!empty($livro['subtitulo'])): ?>
            <h3 style="margin: 0 0 20px 0; color: #666; font-size: 18px;"><?= htmlspecialchars($livro['subtitulo']) ?></h3>
        <?php endif; ?>
        
        <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
        <p><strong>Editora:</strong> <?= htmlspecialchars($livro['editora']) ?></p>
        <p><strong>Ano:</strong> <?= $livro['ano_publicacao'] ?></p>
        <p><strong>Páginas:</strong> <?= $livro['numero_paginas'] ?></p>
        <p><strong>Gênero:</strong> <?= htmlspecialchars($livro['genero']) ?></p>
        <p><strong>ISBN:</strong> <?= htmlspecialchars($livro['isbn']) ?></p>
        
        <!-- Status -->
        <div style="margin: 20px 0;">
            <?php if ($livro['quantidade_disponivel'] > 0): ?>
                <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; display: inline-block;">
                    🟢 DISPONÍVEL - <?= $livro['quantidade_disponivel'] ?> exemplar(es)
                </div>
                <form method="POST" action="solicitar_emprestimo.php" style="margin-top: 15px;">
                    <input type="hidden" name="livro_id" value="<?= $livro['id'] ?>">
                    <button type="submit" name="solicitar_emprestimo" 
                            style="background: #007bff; color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; font-size: 16px; font-weight: bold;">
                        📚 Solicitar Empréstimo
                    </button>
                </form>
            <?php else: ?>
                <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; display: inline-block;">
                    🔴 INDISPONÍVEL - Todos os exemplares estão emprestados
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
        
        <!-- Sinopse -->
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px;">
            <h3>Sinopse</h3>
            <p style="line-height: 1.6;"><?= nl2br(htmlspecialchars($livro['sinopse'])) ?></p>
        </div>
    </div>
</body>
</html>