<?php
session_start();
include '../app/Model/connection-pdo.php';

# Recebendo os dados que o Js esta enviando 
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

# Converter a Data no padrão americano 
$dateStart = str_replace('/', '-', $dados['startDateEdit']);
$convertDateStart = date("Y-m-d", strtotime($dateStart));

# Unir a Data Inicial e a Hora Inicial
$hourStart = $dados['startTimeEdit'];
$joinDataHourStart = $convertDateStart . " " . $hourStart;

# Unir a Data Inicial e a Hora Final (obs: data inicial e final sempre serao as mesmas)
$hourEnd = $dados['endTimeEdit'];
$joinDataHourEnd = $convertDateStart . " " . $hourEnd;

# Tirar mascara do Celular
$subject = ['(', ')', '-', ' '];
$cellphone = str_replace($subject, '',  $dados['cellphoneEdit']);

# Tirar mascara do Telefone
$telephone = str_replace($subject, '',  $dados['telephoneEdit']);

# Tirar mascara do CEP
$cep = str_replace('-', '',  $dados['cepEdit']);

$queryUpdateEvent = " UPDATE tb_eventos SET even_datahorai=:even_datahorai, even_datahoraf=:even_datahoraf, even_observacao=:even_observacao WHERE even_codigo=:even_codigo ";
$updateEvent = $connectionDataBase->prepare($queryUpdateEvent);
$updateEvent->bindParam(':even_datahorai', $joinDataHourStart);
$updateEvent->bindParam(':even_datahoraf', $joinDataHourEnd);
$updateEvent->bindParam(':even_observacao', $dados['observationEdit']);
$updateEvent->bindParam(':even_codigo', $dados['idEvent']);

if ($updateEvent->execute()) {
    $queryUpdateBudget = " UPDATE tb_orcamento SET orca_nome=:orca_nome, orca_sobrenome=:orca_sobrenome, orca_tel=:orca_tel, orca_cel=:orca_cel, orca_email=:orca_email, orca_cep=:orca_cep, orca_logradouro=:orca_logradouro, orca_bairro=:orca_bairro, orca_cidade=:orca_cidade, orca_estado=:orca_estado, orca_log_numero=:orca_log_numero, orca_edificio=:orca_edificio, orca_bloco=:orca_bloco, orca_apartamento=:orca_apartamento, orca_logradouro_condominio=:orca_logradouro_condominio WHERE orca_numero =:orca_numero ";
    $updateBudget = $connectionDataBase->prepare($queryUpdateBudget);
    $updateBudget->bindParam(':orca_numero', $dados['idBudget']);
    $updateBudget->bindParam(':orca_nome', $dados['nameEdit']);
    $updateBudget->bindParam(':orca_sobrenome', $dados['surnameEdit']);
    $updateBudget->bindParam(':orca_tel', $telephone);
    $updateBudget->bindParam(':orca_cel', $cellphone);
    $updateBudget->bindParam(':orca_email', $dados['emailEdit']);
    $updateBudget->bindParam(':orca_cep', $cep);
    $updateBudget->bindParam(':orca_logradouro', $dados['logradouroEdit']);
    $updateBudget->bindParam(':orca_bairro', $dados['bairroEdit']);
    $updateBudget->bindParam(':orca_cidade', $dados['localidadeEdit']);
    $updateBudget->bindParam(':orca_estado', $dados['ufEdit']);
    $updateBudget->bindParam(':orca_log_numero', $dados['numberEdit']);
    $updateBudget->bindParam(':orca_edificio', $dados['edificeEdit']);
    $updateBudget->bindParam(':orca_bloco', $dados['blockEdit']);
    $updateBudget->bindParam(':orca_apartamento', $dados['apartmentEdit']);
    $updateBudget->bindParam(':orca_logradouro_condominio', $dados['streetCondominiumEdit']);

    if ($updateBudget->execute()) {
        $msgUpDateEvent   = "<script> toastr.success('Sucesso: evento editado!'); </script>";
        $retorna = ['sit' => true, 'msg' => $msgUpDateEvent];
        $_SESSION['msg'] = $msgUpDateEvent;
    } else {
        $msgNoUpDateEvent = "<script> toastr.error('Erro: evento não editado!'); </script>";
        $retorna = ['sit' => false, 'msg' => $msgNoUpDateEvent];
    }
} else {
    $msgNoUpDateEvent = "<script> toastr.error('Erro: evento não editado!'); </script>";
    $retorna = ['sit' => false, 'msg' => $msgNoUpDateEvent];
}

header('Content-Type: application/json');
echo json_encode($retorna);
