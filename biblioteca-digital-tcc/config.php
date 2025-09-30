<?php

$dbhost = 'Localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'bd_biblioteca';

$conexao = new mysqli($dbhost,$dbUsername,$dbPassword,$dbName);

if($conexao->connect_error)
{
    echo "Erro";
}
else{
    echo "Conexão efetuada com sucesso";
}

?>