<?php
session_start();
include_once '../app/Model/connection-pdo.php';

/* Recebendo os dados que o Js esta enviando */
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

# Tirar mascara do Celular
$subject = ['(', ')', '-', ' '];
$cellphone = str_replace($subject, '',  $dados['cellphoneRegister']);

# Tirar mascara do Telefone
$telephone = str_replace($subject, '',  $dados['telephoneRegister']);

# Tirar mascara do CEP
$cep = str_replace('-', '',  $dados['cep']);

/* Verificando se a opção "Agendar Horario" foi marcada como "Sim" */
if ($dados['scheduleTime'] == "scheduleTimeYes") {

    # Query insert na tb_orcamento
    $queryInsertBudget = "INSERT INTO tb_orcamento 
    (orca_nome, 
    orca_sobrenome, 
    orca_tel, 
    orca_cel, 
    orca_email, 
    orca_logradouro, 
    orca_log_numero, 
    orca_bairro, 
    orca_cidade, 
    orca_estado, 
    orca_edificio, 
    orca_bloco, 
    orca_apartamento, 
    orca_logradouro_condominio, 
    orca_cep) 
    VALUES (:orca_nome, :orca_sobrenome, :orca_tel, :orca_cel, :orca_email, :orca_logradouro, :orca_log_numero, :orca_bairro, :orca_cidade, :orca_estado, :orca_edificio, :orca_bloco, :orca_apartamento, :orca_logradouro_condominio, :orca_cep)";


    $insertBudget = $connectionDataBase->prepare($queryInsertBudget);
    $insertBudget->bindParam(':orca_nome',                  $dados['nameRegister']);
    $insertBudget->bindParam(':orca_sobrenome',             $dados['surnameRegister']);
    $insertBudget->bindParam(':orca_tel',                   $telephone);
    $insertBudget->bindParam(':orca_cel',                   $cellphone);
    $insertBudget->bindParam(':orca_email',                 $dados['emailRegister']);
    $insertBudget->bindParam(':orca_logradouro',            $dados['logradouro']);
    $insertBudget->bindParam(':orca_log_numero',            $dados['numberRegister']);
    $insertBudget->bindParam(':orca_bairro',                $dados['bairro']);
    $insertBudget->bindParam(':orca_cidade',                $dados['localidade']);
    $insertBudget->bindParam(':orca_estado',                $dados['uf']);
    $insertBudget->bindParam(':orca_edificio',              $dados['edificeRegister']);
    $insertBudget->bindParam(':orca_bloco',                 $dados['blockRegister']);
    $insertBudget->bindParam(':orca_apartamento',           $dados['apartmentRegister']);
    $insertBudget->bindParam(':orca_logradouro_condominio', $dados['streetCondominiumRegister']);
    $insertBudget->bindParam(':orca_cep',                   $cep);
    $insertBudget->execute();

    # Guardar o orca_numero para inserir na tb_eventos
    $idBudget = $connectionDataBase->lastInsertId();

    # Converter a Data no padrão americano 
    $dateStart = str_replace('/', '-', $dados['startDateRegister']);
    $convertDateStart = date("Y-m-d", strtotime($dateStart));

    # Unir a Data Inicial e a Hora Inicial
    $hourStart = $dados['startTimeRegister'];
    $joinDataHourStart = $convertDateStart . " " . $hourStart;

    # Unir a Data Inicial e a Hora Final
    $hourEnd = $dados['endTimeRegister'];
    $joinDataHourEnd = $convertDateStart . " " . $hourEnd;

    $queryInsertEvent = "INSERT INTO tb_eventos (even_titulo, even_cor, even_status, even_datahorai, even_datahoraf, even_observacao, orca_numero) 
    VALUES (:even_titulo, :even_cor, :even_status, :even_datahorai, :even_datahoraf, :even_observacao, :orca_numero)";

    $valueColor = "";
    $valueStatus = "P";

    $insertEvent = $connectionDataBase->prepare($queryInsertEvent);
    $insertEvent->bindParam(':even_titulo',     $dados['selectionTitleRegister']);
    $insertEvent->bindParam(':even_cor',        $valueColor);
    $insertEvent->bindParam(':even_status',     $valueStatus);
    $insertEvent->bindParam(':even_datahorai',  $joinDataHourStart);
    $insertEvent->bindParam(':even_datahoraf',  $joinDataHourEnd);
    $insertEvent->bindParam(':even_observacao', $dados['observationRegister']);
    $insertEvent->bindParam(':orca_numero',     $idBudget);

    $mesageSuccess = '<div id="toast-container" class="toast-top-right"><div class="toast toast-success" aria-live="polite" style=""><div class="toast-message">Sucesso: evento e orçamento cadastrados!</div></div></div>';
    $mesageError   = '<div id="toast-container" class="toast-top-right"><div class="toast toast-error" aria-live="assertive" style=""><div class="toast-message">Erro: evento e orçamento não cadastrados!</div></div></div>';

    # Se inserir exibe a mensagem
    if ($insertEvent->execute()) {
        $retorna = ['sit' => true, 'msg' => $mesageSuccess];
        $_SESSION['msg'] = $mesageSuccess;
    } else {
        $retorna = ['sit' => true, 'msg' => $mesageError];
    }

    header('Content-Type: application/json');
    echo json_encode($retorna);
}
/* Verificando se a opção "Agendar Horario" foi marcada como "Não" */ else if ($dados['scheduleTime'] == "scheduleTimeNo") {
    # Query insert na tb_orcamento
    $queryInsertBudget = "INSERT INTO tb_orcamento 
     (orca_nome, 
     orca_sobrenome, 
     orca_tel, 
     orca_cel, 
     orca_email, 
     orca_logradouro, 
     orca_log_numero, 
     orca_bairro, 
     orca_cidade, 
     orca_estado, 
     orca_edificio, 
     orca_bloco, 
     orca_apartamento, 
     orca_logradouro_condominio, 
     orca_cep,
     orca_observacao) 
     VALUES (:orca_nome, :orca_sobrenome, :orca_tel, :orca_cel, :orca_email, :orca_logradouro, :orca_log_numero, :orca_bairro, :orca_cidade, :orca_estado, :orca_edificio, :orca_bloco, :orca_apartamento, :orca_logradouro_condominio, :orca_cep, :orca_observacao)";


    $insertBudget = $connectionDataBase->prepare($queryInsertBudget);
    $insertBudget->bindParam(':orca_nome',                  $dados['nameRegister']);
    $insertBudget->bindParam(':orca_sobrenome',             $dados['surnameRegister']);
    $insertBudget->bindParam(':orca_tel',                   $telephone);
    $insertBudget->bindParam(':orca_cel',                   $cellphone);
    $insertBudget->bindParam(':orca_email',                 $dados['emailRegister']);
    $insertBudget->bindParam(':orca_logradouro',            $dados['logradouro']);
    $insertBudget->bindParam(':orca_log_numero',            $dados['numberRegister']);
    $insertBudget->bindParam(':orca_bairro',                $dados['bairro']);
    $insertBudget->bindParam(':orca_cidade',                $dados['localidade']);
    $insertBudget->bindParam(':orca_estado',                $dados['uf']);
    $insertBudget->bindParam(':orca_edificio',              $dados['edificeRegister']);
    $insertBudget->bindParam(':orca_bloco',                 $dados['blockRegister']);
    $insertBudget->bindParam(':orca_apartamento',           $dados['apartmentRegister']);
    $insertBudget->bindParam(':orca_logradouro_condominio', $dados['streetCondominiumRegister']);
    $insertBudget->bindParam(':orca_cep',                   $cep);
    $insertBudget->bindParam(':orca_observacao', $dados['observationRegister']);

    $mesageSuccess = '<div id="toast-container" class="toast-top-right"><div class="toast toast-success" aria-live="polite" style=""><div class="toast-message">Sucesso: orçamento cadastrados!</div></div></div>';
    $mesageError   = '<div id="toast-container" class="toast-top-right"><div class="toast toast-error" aria-live="assertive" style=""><div class="toast-message">Erro: orçamento não cadastrado!</div></div></div>';

    # Se inserir exibe a mensagem
    if ($insertBudget->execute()) {
        $retorna = ['sit' => true, 'msg' => $mesageSuccess];
        $_SESSION['msg'] = $mesageSuccess;
    } else {
        $retorna = ['sit' => true, 'msg' => $mesageError];
    }

    header('Content-Type: application/json');
    echo json_encode($retorna);
}
