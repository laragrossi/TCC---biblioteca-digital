<?php
$servername = "localhost";
$username = "root"; // use "root" se estiver no XAMPP
$password = ""; // deixe vazio se não tem senha
$database = "bd_biblioteca";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Conexão realizada com sucesso
?>

