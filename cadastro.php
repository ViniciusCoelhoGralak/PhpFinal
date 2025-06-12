<?php
require_once 'includes/funcoes.php';
require_once 'includes/conexao.php';

$conn = conectar_banco();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirm_senha = $_POST['confirm_senha'] ?? '';

    if (empty($login) || empty($email) || empty($senha) || empty($confirm_senha)) {
        header('location:cadastro.php?codigo=2'); 
        exit;

    } elseif ($senha !== $confirm_senha) {
        $message = "<h3 class='text-danger'>As senhas não coincidem.</h3>";

    } elseif (strlen($senha) < 6) { 
        $message = "<h3 class='text-warning'>A senha deve ter no mínimo 6 caracteres.</h3>";

    } else {
        
        if (usuario_ou_email_ja_existe($login, $email, $conn)) {
            header('location:cadastro.php?codigo=8');
            exit;
        }
            
            $hashed_password = password_hash($senha, PASSWORD_DEFAULT);

            $sql_insert = "INSERT INTO usuarios (login, senha, email) VALUES (?, ?, ?)";
            $stmt_insert = mysqli_prepare($conn, $sql_insert);
            mysqli_stmt_bind_param($stmt_insert, "sss", $login, $hashed_password, $email);

            if (mysqli_stmt_execute($stmt_insert)) {
                header('location:index.php?codigo=9'); //Sucesso ao cadastrar
                exit;
            } else {
                header('location:index.php?codigo=12'); //Erro ao cadastrar
            }
            mysqli_stmt_close($stmt_insert);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
    
    <h1 class="my-4">Cadastro de Novo Usuário</h1>

    <nav class="mb-4">
        <a href="index.php" class="btn btn-secondary me-2">Voltar ao Login</a>
    </nav>

    <?php verificar_codigo();?>
    <?php echo $message;?>

    <form action="cadastro.php" method="post">
        <div class="mb-3">
            <label for="login" class="form-label">Login:</label>
            <input type="text" name="login" id="login" class="form-control" required value="<?= htmlspecialchars($_POST['login'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" name="senha" id="senha" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="confirm_senha" class="form-label">Confirmar Senha:</label>
            <input type="password" name="confirm_senha" id="confirm_senha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Cadastrar</button>
    </form>
</body>
</html>