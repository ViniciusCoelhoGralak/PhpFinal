<?php
require_once 'includes/funcoes.php';
require_once 'includes/conexao.php';

if (form_nao_enviado()) {
    header('location:login.php?codigo=0');
    exit;
}

if (campos_em_branco()) {
    header('location:login.php?codigo=2');
    exit;
}


$conn = conectar_banco();


$login = $_POST['login'];
$senha = $_POST['senha'];


$sql = "SELECT id, login, senha, email FROM usuarios WHERE login = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    header('location:login.php?codigo=3');
    exit;
}

// Bind e execução
mysqli_stmt_bind_param($stmt, "s", $login);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

// Verifica se encontrou o usuário
if (mysqli_stmt_num_rows($stmt) <= 0) {
    header('location:login.php?codigo=1');
    exit;
}

// Bind do resultado 
mysqli_stmt_bind_result($stmt, $id, $login, $senha_hash, $email);
mysqli_stmt_fetch($stmt);


if (!password_verify($senha, $senha_hash)) {
    header('location:login.php?codigo=1');
    exit;
}

session_start();
$_SESSION['id'] = $id;
$_SESSION['login'] = $login;
$_SESSION['email'] = $email;

header('location:dashboard.php');
exit;
?>