<?php
// conexaoDelivros.php

// ✅ CRIAR PASTA AUTOMATICAMENTE
$pasta_fotos = "fotos_livros";
if (!file_exists($pasta_fotos)) {
    mkdir($pasta_fotos, 0777, true);
}

$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "bd_biblioteca";

// Criar conexão
$conexao = new mysqli($servidor, $usuario, $senha, $dbname);

// Verificar conexão
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

if (isset($_POST['submit'])) {
    
    // ✅ DEBUG: Ver quais campos estão chegando
    echo "<pre>DEBUG - Campos recebidos:";
    print_r($_POST);
    echo "</pre>";
    
    // ✅ Dados do formulário - USANDO NOMES SIMPLIFICADOS
    $numero_tombo = $_POST['numero_tombo'] ?? '';
    $isbn = $_POST['isbn'] ?? '';
    $titulo = $_POST['titulo'] ?? '';
    $subtitulo = $_POST['subtitulo'] ?? '';
    $sinopse = $_POST['sinopse'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $editora = $_POST['editora'] ?? '';
    $ano_publicacao = $_POST['ano_publicacao'] ?? '';
    $numero_paginas = $_POST['numero_paginas'] ?? '';
    $idioma = $_POST['idioma'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $area_conhecimento = $_POST['area_conhecimento'] ?? '';
    
    // ✅ VERIFICAR SE OS CAMPOS OBRIGATÓRIOS ESTÃO PREENCHIDOS
    if (empty($numero_tombo) || empty($titulo) || empty($autor)) {
        die("Preencha os campos obrigatórios: Número de tombo, Título e Autor");
    }
    
    // Processar upload da foto
    $foto = "";
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto_nome = uniqid() . "_" . $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_destino = "fotos_livros/" . $foto_nome;
        
        // Mover arquivo para pasta
        if (move_uploaded_file($foto_tmp, $foto_destino)) {
            $foto = $foto_destino;
        }
    }
    
    // ✅ CONVERTER PARA NÚMEROS
    $ano_publicacao = intval($ano_publicacao);
    $numero_paginas = intval($numero_paginas);
    
    // Inserir no banco
    $sql = "INSERT INTO livros (
        numero_tombo, isbn, titulo, subtitulo, sinopse, autor, editora, 
        ano_publicacao, numero_paginas, idioma, genero, area_conhecimento, foto
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conexao->prepare($sql);
    if ($stmt) {
        $stmt->bind_param(
            "sssssssiissss", 
            $numero_tombo, $isbn, $titulo, $subtitulo, $sinopse, $autor, $editora,
            $ano_publicacao, $numero_paginas, $idioma, $genero, $area_conhecimento, $foto
        );
        
        if ($stmt->execute()) {
            header('Location: cadastrolivros.php?sucesso=1');
            exit();
        } else {
            echo "Erro ao cadastrar livro: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Erro na preparação da query: " . $conexao->error;
    }
}

$conexao->close();
?>