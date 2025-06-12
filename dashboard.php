<?php
require_once 'includes/auth.php';
require_once 'includes/conexao.php';
require_once 'includes/funcoes.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Veículos - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>

<body class="container"> 

    <h1 class="my-4">Meus Veículos</h1>

    <nav class="mb-4">  
        <a href="logout.php" class="btn btn-danger">Sair</a> 
    </nav>

    <h2 class="mb-3">Bem-vindo, <?= htmlspecialchars($_SESSION['login']) ?>!</h2>

    <?php verificar_codigo(); ?>

    <h3 class="mt-4 mb-3">Cadastrar Novo Veículo</h3> 
    <form action="veiculos/cadastrar.php" method="post" class="mb-5"> 
        <div class="row g-3 align-items-end"> 
            <div class="col-md-3"> 
                <label for="placa" class="form-label">Placa:</label> 
                <input type="text" name="placa" id="placa" class="form-control" placeholder="Placa" maxlength="7" required> 
            </div>
            <div class="col-md-4"> 
                <label for="modelo" class="form-label">Modelo:</label> 
                <input type="text" name="modelo" id="modelo" class="form-control" placeholder="Modelo do Veículo" required> 
            </div>
            <div class="col-md-2"> 
                <button type="submit" class="btn btn-primary">Cadastrar</button> 
            </div>
        </div>
    </form>

    <h3 class="mt-4 mb-3">Lista de Veículos Cadastrados</h3>

    <?php

    $conn = conectar_banco();
    $id_usuario = $_SESSION['id'];

    $sql = "SELECT id, placa, modelo, data_criacao FROM veiculos WHERE usuario_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {

        echo "<p class='text-danger'>Erro ao preparar consulta: " . mysqli_error($conn) . "</p>";
        
    } else {

        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) > 0) {

            echo "<table class='table table-striped table-bordered'>";
            echo "<thead><tr><th>Placa</th><th>Modelo</th><th>Data de Criação</th><th>Ações</th></tr></thead>";
            echo "<tbody>";

            while ($veiculo = mysqli_fetch_assoc($resultado)) {

                echo "<tr>";
                echo "<td>" . htmlspecialchars($veiculo['placa']) . "</td>";
                echo "<td>" . htmlspecialchars($veiculo['modelo']) . "</td>";
                echo "<td>" . htmlspecialchars($veiculo['data_criacao']) . "</td>";
                echo "<td>";
                echo "<a href='veiculos/editar.php?id=" . $veiculo['id'] . "' class='btn btn-sm btn-warning me-2'>Editar</a>"; 
                echo "<a href='veiculos/excluir.php?id=" . $veiculo['id'] . "' class='btn btn-sm btn-danger' onclick=\"return confirm('Tem certeza que deseja excluir este veículo?');\">Excluir</a>";
                echo "</td>";
                echo "</tr>";

            }

            echo "</tbody>";
            echo "</table>";

        } else {

            echo "<p>Nenhum veículo cadastrado ainda.</p>";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);

    ?>

</body>

</html>