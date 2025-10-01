<?php

    if(isset($_POST['submit']))
    {
        include_once('../config.php');
       if (isset($_POST['ra'])) {

       $nome = $_POST['nome'];
       $ra = $_POST['ra'];
       $digito = $_POST['digito'];
       $senha = $_POST['senha'];
       $escola = $_POST['escola'];

       $result = mysqli_query($conexao, "INSERT INTO aluno(nome,ra,digito,senha,escola) 
       VALUES ('$nome','$ra','$digito','$senha','$escola')");
       header('Location: ../homealuno.php');
       } else {
        $nome = $_POST['nome'];
       $email = $_POST['email'];
       $cidade = $_POST['cidade'];
       $senha = $_POST['senha'];
       $escola = $_POST['escola'];

       $result = mysqli_query($conexao, "INSERT INTO professor(nome, email,senha,escola, cidade) 
       VALUES ('$nome','$email','$senha','$escola','$cidade')");
       header('Location: ../homeprof.php');
       }
    }

?>
