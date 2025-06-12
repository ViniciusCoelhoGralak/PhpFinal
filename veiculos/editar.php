<?php
require_once '../includes/auth.php';
require_once '../includes/conexao.php';
require_once '../includes/funcoes.php';

$id_usuario = $_SESSION['id'];
$conn = conectar_banco();
$message = '';
$veiculo = null;

if (!isset($_GET['id']) && !isset($_POST['id'])) {
    header('location:../dashboard.php?codigo=0'); //Se nao apresentar id volta pro dashboard
    exit;
}

$id_veiculo_param = (int)($_GET['id'] ?? $_POST['id']);

// Obter dados do veículo para edição, garantindo a propriedade
$veiculo = obter_dados_veiculo_para_edicao($id_veiculo_param, $id_usuario, $conn);

if (!$veiculo) { // Se a função retornar null, significa que o veículo não foi encontrado ou não pertence ao usuário
    mysqli_close($conn); // Fecha a conexão
    header('location:../dashboard.php?codigo=0');
    exit;
}


// Manipula o envio do formulário para atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_veiculo_post = (int)$_POST['id'];
    $placa_post = $_POST['placa'] ?? '';
    $modelo_post = $_POST['modelo'] ?? '';

    // Garante que o id do POST corresponda ao obtido e pertença ao usuário
    if ($id_veiculo_post !== $veiculo['id']) {
         header('location:../dashboard.php?codigo=0'); // se o id nao for igual ou houver manipulacao volta pro dash
         exit;
    }

    if (veiculo_campos_em_branco($modelo_post, $placa_post)) {
        header('location:editar.php?id=' . $id_veiculo_post . '&codigo=6');
        exit;
    }

    $conn = conectar_banco();

    if (placa_ja_existe($placa_post, $conn, $id_veiculo_post)) {
        header('location:editar.php?id=' . $id_veiculo_post . '&codigo=7');
        exit;
    }

    // Atualiza o veiculo
     if (atualizar_veiculo($placa_post, $modelo_post, $id_veiculo_post, $id_usuario, $conn)) {
        // Se a atualização foi bem-sucedida, atualiza os dados locais para exibir 
        $veiculo['placa'] = $placa_post;
        $veiculo['modelo'] = $modelo_post;
        mysqli_close($conn); // Fecha a conexão
        header('location:../dashboard.php?codigo=11');
    } else {
        mysqli_close($conn); // Fecha a conexão
        header('location:../dashboard.php?codigo=10');
    }
    exit;
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Veículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
    <h1 class="my-4">Editar Veículo</h1>

    <nav class="mb-4">
        <a href="../dashboard.php" class="btn btn-info me-2">Voltar para o Dashboard</a>
        <a href="../logout.php" class="btn btn-danger">Sair</a>
    </nav>

    <?php verificar_codigo(); // Display messages for codes 6, 7, 10 ?>

    <?php if ($veiculo): ?>
        <form action="editar.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($veiculo['id']) ?>">
            <div class="mb-3">
                <label for="placa" class="form-label">Placa:</label>
                <input type="text" name="placa" id="placa" class="form-control" value="<?= htmlspecialchars($veiculo['placa']) ?>" maxlength="8" required>
            </div>
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo:</label>
                <input type="text" name="modelo" id="modelo" class="form-control" value="<?= htmlspecialchars($veiculo['modelo']) ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Salvar Alterações</button>
            <a href="../dashboard.php" class="btn btn-secondary">Cancelar</a>
        </form>
    <?php else: ?>
        <p class="text-danger">Veículo não encontrado ou você não tem permissão para editá-lo.</p>
    <?php endif; ?>
</body>
</html>