<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Digital</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS personalizado -->
    <link rel="stylesheet" href="acesso.css">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card text-center p-4 shadow-lg card-custom">
            <img src= "imagens/" 
                 alt="Biblioteca" class="mx-auto mb-3 logo">

            <h4 class="fw-bold text-brown">Bem-Vindo à Biblioteca Digital</h4>
            <p class="text-muted">Inicie seu acesso:</p>

            <a href="cadastroaluno.php" class="btn btn-custom w-50 me-1">Aluno</a>
            <br>
            <a href="cadastroprof.php" class="btn btn-custom w-50 me-1">Professor</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- JS personalizado -->
    <script src="script.js"></script>
</body>
</html>
