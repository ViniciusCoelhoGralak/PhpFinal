<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial - Gerenciamento de Veículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link href="css/estilo.css" rel="stylesheet">
</head>

<body class="container py-5"> 

    <h1 class="text-center mb-4">Bem-vindo ao Sistema de Gerenciamento de Veículos!</h1> 

        <nav class="d-flex justify-content-center mb-4"> 

            <a href="login.php" class="btn btn-primary me-2">Fazer Login</a> 
            <a href="cadastro.php" class="btn btn-secondary">Cadastre-se</a> 

        </nav>

    <div class="alert alert-info text-center" role="alert"> 
        Este sistema permite que você cadastre e gerencie seus veículos.
        Faça login ou cadastre-se para começar!
    </div>

    <?php
        require_once 'includes/funcoes.php';
        verificar_codigo();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>