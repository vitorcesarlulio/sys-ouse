<?php
session_start();
include_once '../app/Model/connection-pdo.php';

# Recebendo os dados que o Js esta enviando 
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

/* Variaveis */
# Tirar mascara do Celular
$subject = ['(', ')', '-', ' '];
$cellphone = str_replace($subject, '',  $dados['cellphoneRegister']);

# Tirar mascara do Telefone
$telephone = str_replace($subject, '',  $dados['telephoneRegister']);

# Tirar mascara do CEP
$cep = str_replace('-', '',  $dados['cep']);

# Converter a Data no padrão americano 
$dateStart = str_replace('/', '-', $dados['startDateRegister']);
$convertDateStart = date("Y-m-d", strtotime($dateStart));

# Unir a Data Inicial e a Hora Inicial
$hourStart = $dados['startTimeRegister'];
$joinDataHourStart = $convertDateStart . " " . $hourStart;

# Unir a Data Inicial e a Hora Final (obs: data inicial e final sempre serao as mesmas)
$hourEnd = $dados['endTimeRegister'];
$joinDataHourEnd = $convertDateStart . " " . $hourEnd;

# variaveis que guarda o valores que o usuario nao preenche
$valueColor = "";
$valueStatus = "P";

#-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
# Verificando se a opção "Agendar Horario" foi marcada como "Sim" 
if ($dados['scheduleTime'] == "scheduleTimeYes") {

    if ($dados['selectionTitleRegister'] === "Voltar na Obra" || $dados['selectionTitleRegister'] === "Início de Obra") {
        # Query inserir na tb_eventos
        $queryInsertEvent = " INSERT INTO tb_eventos 
        (even_titulo,
        even_cor,
        even_status,
        even_datahorai,
        even_datahoraf, 
        even_observacao, 
        orca_numero) 
        VALUES (:even_titulo, :even_cor, :even_status, :even_datahorai, :even_datahoraf, :even_observacao, :orca_numero) ";

        # Inserindo na tb_eventos
        $insertEvent = $connectionDataBase->prepare($queryInsertEvent);
        $insertEvent->bindParam(':even_titulo',     $dados['selectionTitleRegister']);
        $insertEvent->bindParam(':even_cor',        $valueColor);
        $insertEvent->bindParam(':even_status',     $valueStatus);
        $insertEvent->bindParam(':even_datahorai',  $joinDataHourStart);
        $insertEvent->bindParam(':even_datahoraf',  $joinDataHourEnd);
        $insertEvent->bindParam(':even_observacao', $dados['observationRegister']);
        $insertEvent->bindParam(':orca_numero',     $dados['clientRegister']);

        # Se inserir exibe a mensagem
        if ($insertEvent->execute()) { 
            $msgInsertEvent         = "<script> toastr.success('Sucesso: evento cadastrado!'); </script>";
            $retorna = ['sit' => true, 'msg' => $msgInsertEvent];
            $_SESSION['msg'] = $msgInsertEvent;
        } else {
            $msgNoInsertEventBudget = "<script> toastr.error('Erro: evento não cadastrado!'); </script>";
            $retorna = ['sit' => true, 'msg' => $msgNoInsertEventBudget];
        }

    } else {
        # Query inserir na tb_orcamento
        $queryInsertBudget = " INSERT INTO tb_orcamento 
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
        VALUES (:orca_nome, :orca_sobrenome, :orca_tel, :orca_cel, :orca_email, :orca_logradouro, :orca_log_numero, :orca_bairro, :orca_cidade, :orca_estado, :orca_edificio, :orca_bloco, :orca_apartamento, :orca_logradouro_condominio, :orca_cep) ";

        # Inserindo na tb_orcamento
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

        # Query inserir na tb_eventos
        $queryInsertEvent = " INSERT INTO tb_eventos 
        (even_titulo,
        even_cor,
        even_status,
        even_datahorai,
        even_datahoraf, 
        even_observacao, 
        orca_numero) 
        VALUES (:even_titulo, :even_cor, :even_status, :even_datahorai, :even_datahoraf, :even_observacao, :orca_numero) ";

        # Inserindo na tb_eventos
        $insertEvent = $connectionDataBase->prepare($queryInsertEvent);
        $insertEvent->bindParam(':even_titulo',     $dados['selectionTitleRegister']);
        $insertEvent->bindParam(':even_cor',        $valueColor);
        $insertEvent->bindParam(':even_status',     $valueStatus);
        $insertEvent->bindParam(':even_datahorai',  $joinDataHourStart);
        $insertEvent->bindParam(':even_datahoraf',  $joinDataHourEnd);
        $insertEvent->bindParam(':even_observacao', $dados['observationRegister']);
        $insertEvent->bindParam(':orca_numero',     $idBudget);

        # Google Contato


        # Se inserir exibe a mensagem
        if ($insertEvent->execute()) { 
            $msgInsertEvent         = "<script> toastr.success('Sucesso: evento e orçamento cadastrados!'); </script>";
            $retorna = ['sit' => true, 'msg' => $msgInsertEvent];
            $_SESSION['msg'] = $msgInsertEvent;
        } else {
            $msgNoInsertEventBudget = "<script> toastr.error('Erro: evento e orçamento não cadastrados!'); </script>";
            $retorna = ['sit' => true, 'msg' => $msgNoInsertEventBudget];
        }
    }
}
#-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------#
# Verificando se a opção "Agendar Horario" foi marcada como "Não" 
else if ($dados['scheduleTime'] == "scheduleTimeNo") {
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

    $msgInsertBudget   = "<script> toastr.success('Sucesso: orçamento cadastrado!'); </script>";
    $msgNoInsertBudget = "<script> toastr.error('Erro: orçamento não cadastrado!'); </script>";
    # Se inserir exibe a mensagem
    if ($insertBudget->execute()) { 
        $retorna = ['sit' => true, 'msg' => $msgInsertBudget];
        $_SESSION['msg'] = $msgInsertBudget;
    } else {
        $retorna = ['sit' => true, 'msg' => $msgNoInsertBudget];
    }
}

header('Content-Type: application/json');
echo json_encode($retorna);
