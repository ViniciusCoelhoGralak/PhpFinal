<?php
session_start(); // Inicia a sessão para poder acessá-la e destruí-la

// Apaga todos os dados da variável de sessão
unset($_SESSION); // Isso remove todas as variáveis registradas na sessão

// Finaliza a sessão atual no servidor
session_destroy(); // Destrói todos os dados registrados em uma sessão

header('location:login.php'); // Redireciona para a nova página de login.php
exit; // Garante que nenhum outro código seja executado após o redirecionamento
?>