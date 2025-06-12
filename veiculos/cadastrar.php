<?php
    require_once '../includes/auth.php';
    require_once '../includes/conexao.php';
    require_once '../includes/funcoes.php';

    // Verifica se o form foi enviado via POST
    if (form_nao_enviado()) {
        header('location:../dashboard.php?codigo=0'); 
        exit;
    }

    $placa = $_POST['placa'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $id_usuario = $_SESSION['id'];

    // Verifica compos em branco
    if (veiculo_campos_em_branco($modelo, $placa)) {
        header('location:../dashboard.php?codigo=6'); 
        exit;
    }

    $conn = conectar_banco();

    if (placa_ja_existe($placa, $conn)) { 
        header('location:../dashboard.php?codigo=7'); // Codigo para placas duplicadas
        exit;
    }

    $sql = "INSERT INTO veiculos (usuario_id, placa, modelo) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        header('location:../dashboard.php?codigo=5'); // Verifica se a variavel stmt foi criada com sucesso
        exit;
    }

    mysqli_stmt_bind_param($stmt, "iss", $id_usuario, $placa, $modelo); // associa as variaveis PHP aos parametros da instrução de insert

    if(!mysqli_stmt_execute($stmt)){
        header('location:../dashboard.php?codigo=5'); // Se o insert de cima der errado roda o erro
        exit;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header('location:../dashboard.php');
    exit;
?>