<?php
session_start();
session_destroy(); // Encerra a sessão do usuário

header("Location: index.php"); // Redireciona de volta ao login
exit;
