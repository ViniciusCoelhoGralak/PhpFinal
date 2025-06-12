<?php 
function conectar_banco() {

    $servidor   = 'localhost:3306';
    $login    = 'root';
    $senha      = '';
    $banco      = 'bd_veiculos';   
    
    $conn = mysqli_connect($servidor, $login, $senha, $banco);

    if (!$conn) {
        exit("Erro na conexão: " . mysqli_connect_error());
    }

    return $conn;
}

?>