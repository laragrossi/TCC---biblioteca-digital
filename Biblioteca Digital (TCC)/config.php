<?php

$dbhost = 'Localhost';
$dbUsername = 'root';
$dbPasswhord = '';
$dbName = 'Biblioteca'

$conexao = new mysqli($dbhost,$dbUsername,$dbPasswhord,$dbName);

if($conexao->connect_errno)
{
    echo "Erro";
}
else{
    echo "Conexão efetuada com sucesso";
}

?>