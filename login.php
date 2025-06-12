<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Gerenciamento de Veículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link href="css/estilo.css" rel="stylesheet">
</head>

<body class="container py-5"> 

    <h1 class="my-4 text-center">Login no Sistema</h1> 
    
    <nav class="d-flex justify-content-center mb-4"> 
        <a href="index.php" class="btn btn-primary me-2">Página Inicial</a>   
        <a href="cadastro.php" class="btn btn-secondary">Cadastrar Usuário</a> 
    </nav>

    <?php
        require_once 'includes/funcoes.php';
        verificar_codigo();
    ?>

    <div class="row justify-content-center"> 
        <div class="col-md-6 col-lg-4"> 
            <form action="validar_login.php" method="post" class="p-4 border rounded shadow-sm bg-light"> 
                <div class="mb-3"> 
                    <label for="login" class="form-label">Login:</label>
                    <input type="text" name="login" id="login" class="form-control" placeholder="Seu login" required>
                </div>
                <div class="mb-3"> 
                    <label for="senha" class="form-label">Senha:</label>
                    <input type="password" name="senha" id="senha" class="form-control" placeholder="Sua senha" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Entrar</button> </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>