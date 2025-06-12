<?php

function form_nao_enviado() {
    return $_SERVER['REQUEST_METHOD'] !== 'POST';
}

function campos_em_branco() {
    return empty($_POST['login']) || empty($_POST['senha']);
}

function usuario_ou_email_ja_existe($login, $email, $conn) {
    
    $sql = "SELECT COUNT(*) FROM usuarios WHERE login = ? OR email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $login, $email);

    if (!$stmt) {
        error_log("Erro ao preparar consulta de usuario_ou_email_ja_existe: " . mysqli_error($conn));
        return true; // Assume que existe em caso de erro para segurança
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $count > 0;
}

function veiculo_campos_em_branco($modelo, $placa) {
    return empty($modelo) || empty($placa);
}

// $id_veiculo_excluir = excluir da procura por placa, caso esteja editando o veiculo
function placa_ja_existe($placa, $conn, $id_veiculo_excluir = null) {
    
    if ($id_veiculo_excluir) {
        $sql = "SELECT COUNT(*) FROM veiculos WHERE placa = ? AND id != ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $placa, $id_veiculo_excluir);
    } else {
        $sql = "SELECT COUNT(*) FROM veiculos WHERE placa = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $placa);
    }

    if (!$stmt) {
        // Retorna true para evitar duplicação em caso de erro na query.
        error_log("Erro ao preparar consulta de placa_ja_existe: " . mysqli_error($conn));
        return true;
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    return $count > 0;
}

function obter_dados_veiculo_para_edicao($id_veiculo, $id_usuario, $conn) {
    $sql = "SELECT id, placa, modelo FROM veiculos WHERE id = ? AND usuario_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        error_log("Erro ao preparar consulta para obter dados do veículo: " . mysqli_error($conn));
        return null;
    }

    mysqli_stmt_bind_param($stmt, "ii", $id_veiculo, $id_usuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) == 0) {
        mysqli_stmt_close($stmt);
        return null; // Veículo não encontrado ou não pertence ao usuário
    }

    $veiculo = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt);

    return $veiculo;
}

function atualizar_veiculo($placa, $modelo, $id_veiculo, $id_usuario, $conn) {
    $sql_update = "UPDATE veiculos SET placa = ?, modelo = ? WHERE id = ? AND usuario_id = ?";
    $stmt_update = mysqli_prepare($conn, $sql_update);

    if (!$stmt_update) {
        error_log("Erro ao preparar consulta para atualizar veículo: " . mysqli_error($conn));
        return false;
    }

    mysqli_stmt_bind_param($stmt_update, "ssii", $placa, $modelo, $id_veiculo, $id_usuario);

    if (!mysqli_stmt_execute($stmt_update)) {
        error_log("Erro ao executar atualização do veículo: " . mysqli_error($conn));
        mysqli_stmt_close($stmt_update);
        return false;
    }

    $affected_rows = mysqli_stmt_affected_rows($stmt_update);
    mysqli_stmt_close($stmt_update);

    // Retorna true se alguma linha foi afetada
    return $affected_rows > 0;
}

function verificar_codigo() {

    if (!isset($_GET['codigo'])) {
        return;
    }

    $codigo = (int)$_GET['codigo'];

    switch ($codigo) {

        case 0:
            $msg = "<h3 class='text-danger'>Você não tem permissão para acessar a página requisitada.</h3>";
            break;

        case 1:
            $msg = "<h3 class='text-danger'>Login ou senha inválidos. Por favor, tente novamente!</h3>";
            break;

        case 2:
            $msg = "<h3 class='text-warning'>Por favor, preencha todos os campos do formulário.</h3>";
            break;

        case 3:
            $msg = "<h3 class='text-danger'>Erro na estrutura da consulta SQL.</h3>";
            break;

        case 4:
            $msg = "<h3 class='text-danger'>Erro ao excluir veículo selecionado.</h3>";
            break;

        case 5:
            $msg = "<h3 class='text-danger'>Erro ao cadastrar veículo.</h3>";
            break;

        case 6:
            $msg = "<h3 class='text-warning'>Por favor, preencha todos os campos do veículo (placa e modelo).</h3>";
            break;

        case 7:
            $msg = "<h3 class='text-warning'>Placa já cadastrada. Por favor, insira uma placa única.</h3>";
            break;

        case 8:
            $msg = "<h3 class='text-warning'>Login ou E-mail já existem. Por favor, tente outro.</h3>";
            break;

        case 9:
            $msg = "<h3 class='text-success'>✅ Usuário cadastrado com sucesso! Faça login.</h3>";
            break;

        case 10:
            $msg = "<h3 class='text-danger'>Erro ao editar veículo. Verifique os dados.</h3>";
            break;

        case 11:
            $msg = "<h3 class='text-success'>✅ Veículo atualizado com sucesso!</h3>";
            break;

        case 12: 
            $msg = "<h3 class='text-danger'>Erro ao cadastrar usuário. Tente novamente.</h3>";
            break;

        default:
            $msg = "";
            break;
    }

    echo $msg;

}

?>