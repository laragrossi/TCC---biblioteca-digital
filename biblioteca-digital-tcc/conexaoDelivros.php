<?php
// conexaoDelivros.php
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
    
    // Dados do formulário
    $numero_tombo = $_POST['número de tombo'];
    $isbn = $_POST['ISBN'];
    $titulo = $_POST['título'];
    $subtitulo = $_POST['subtítulo'];
    $sinopse = $_POST['sinopse'];
    $autor = $_POST['autor'];
    $editora = $_POST['editora'];
    $ano_publicacao = $_POST['ano de publicação'];
    $numero_paginas = $_POST['número de páginas'];
    $idioma = $_POST['idioma'];
    $genero = $_POST['gênero'];
    $area_conhecimento = $_POST['área de conhecimento'];
    
    // Processar upload da foto
    $foto = "";
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto_nome = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_destino = "fotos_livros/" . $foto_nome;
        
        // Mover arquivo para pasta
        if (move_uploaded_file($foto_tmp, $foto_destino)) {
            $foto = $foto_destino;
        }
    }
    
    // Inserir no banco
    $sql = "INSERT INTO livros (
        numero_tombo, isbn, titulo, subtitulo, sinopse, autor, editora, 
        ano_publicacao, numero_paginas, idioma, genero, area_conhecimento, foto
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param(
        "sssssssiissss", 
        $numero_tombo, $isbn, $titulo, $subtitulo, $sinopse, $autor, $editora,
        $ano_publicacao, $numero_paginas, $idioma, $genero, $area_conhecimento, $foto
    );
    
    if ($stmt->execute()) {
        header('Location: cadastrolivros.php?sucesso=1');
    } else {
        echo "Erro: " . $stmt->error;
    }
    
    $stmt->close();
}

$conexao->close();
?>

