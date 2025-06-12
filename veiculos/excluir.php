<?php

require_once '../includes/auth.php';
require_once '../includes/conexao.php';
require_once '../includes/funcoes.php';


if (!isset($_GET['id'])) {
    header('location:../dashboard.php?codigo=0');
    exit;
}

$id_veiculo = (int)$_GET['id'];
$id_usuario = $_SESSION['id'];
$conn = conectar_banco();

$sql = "DELETE FROM veiculos WHERE id = ? AND usuario_id = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    header('location:../dashboard.php?codigo=4'); 
}

mysqli_stmt_bind_param($stmt, "ii", $id_veiculo, $id_usuario);

if (!mysqli_stmt_execute($stmt)) {
    header('location:../dashboard.php?codigo=4');
    exit;
}

if (mysqli_stmt_affected_rows($stmt) <= 0) {
    header('location:../dashboard.php?codigo=4');
    exit;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

header('location:../dashboard.php');
exit;
?>