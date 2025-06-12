<?php

//So permite acesso ao usuario se estiver logado

session_start();
if (!isset($_SESSION['id'])) {
    header('location:../login.php?codigo=0');
    exit;
}

?>