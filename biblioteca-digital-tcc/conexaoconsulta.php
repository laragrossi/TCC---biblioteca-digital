<?php
// conexaoconsulta.php - Para consultas, empréstimos e pesquisas
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
?>