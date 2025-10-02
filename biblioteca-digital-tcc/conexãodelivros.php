<?php include("conexaodelivros.php"); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Livro</title>
</head>
<body>
    <h2>Cadastrar Livro</h2>
    <form method="POST" action="">
        Número Tombo: <input type="text" name="numero_tombo" required><br>
        ISBN: <input type="text" name="isbn"><br>
        Autor: <input type="text" name="autor" required><br>
        Editora: <input type="text" name="editora"><br>
        Ano de Publicação: <input type="number" name="ano_publicacao"><br>
        Número de Páginas: <input type="number" name="numero_paginas"><br>
        Idioma: <input type="text" name="idioma"><br>
        Gênero: <input type="text" name="genero"><br>
        Área do Conhecimento: <input type="text" name="area_conhecimento"><br>
        Subtítulo: <input type="text" name="subtitulo"><br>
        Sinopse: <textarea name="sinopse"></textarea><br>
        <input type="submit" name="cadastrar" value="Cadastrar">
    </form>
</body>
</html>

<?php
if (isset($_POST['cadastrar'])) {
    $numero_tombo      = $_POST['numero_tombo'];
    $isbn              = $_POST['isbn'];
    $autor             = $_POST['autor'];
    $editora           = $_POST['editora'];
    $ano_publicacao    = $_POST['ano_publicacao'];
    $numero_paginas    = $_POST['numero_paginas'];
    $idioma            = $_POST['idioma'];
    $genero            = $_POST['genero'];
    $area_conhecimento = $_POST['area_conhecimento'];
    $subtitulo         = $_POST['subtitulo'];
    $sinopse           = $_POST['sinopse'];

    $sql = "INSERT INTO livros 
            (numero_tombo, isbn, autor, editora, ano_publicacao, numero_paginas, idioma, genero, area_conhecimento, subtitulo, sinopse)
            VALUES 
            ('$numero_tombo', '$isbn', '$autor', '$editora', '$ano_publicacao', '$numero_paginas', '$idioma', '$genero', '$area_conhecimento', '$subtitulo', '$sinopse')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Livro cadastrado com sucesso!</p>";
    } else {
        echo "<p style='color:red;'>Erro: " . $conn->error . "</p>";
    }
}
?>
