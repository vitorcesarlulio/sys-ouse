<?php
if (isset($_POST['idPeopleEdit']) && !empty($_POST['idPeopleEdit'])) {
    include_once '../app/Model/connection-pdo.php';

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $cep   = str_replace('-', '',  $dados['cepEdit']);
    $dados['classificationPersonEdit'] == "C" ? $classificationPerson = "C" : $classificationPerson = "F"; 

    $queryUpDatePeople = " UPDATE tb_pessoas SET pess_classificacao=:pess_classificacao, pess_nome=:pess_nome, pess_sobrenome=:pess_sobrenome, pess_razao_social=:pess_razao_social, pess_nome_fantasia=:pess_nome_fantasia, 
    pess_cep=:pess_cep, pess_logradouro=:pess_logradouro, pess_log_numero=:pess_log_numero, pess_bairro=:pess_bairro, pess_cidade=:pess_cidade, pess_estado=:pess_estado, 
    pess_edificio=:pess_edificio, pess_bloco=:pess_bloco, pess_apartamento=:pess_apartamento, pess_logradouro_condominio=:pess_logradouro_condominio, 
    pess_observacao=:pess_observacao 
    WHERE pess_codigo=:pess_codigo ";

    $upDatePeople = $connectionDataBase->prepare($queryUpDatePeople);
    $upDatePeople->bindParam(':pess_classificacao',         $classificationPerson);
    $upDatePeople->bindParam(':pess_nome',                  $dados['nameEdit']);
    $upDatePeople->bindParam(':pess_sobrenome',             $dados['surnameEdit']);
    $upDatePeople->bindParam(':pess_razao_social',          $dados['companyNameEdit']);
    $upDatePeople->bindParam(':pess_nome_fantasia',         $dados['fantasyNameEdit']);
    $upDatePeople->bindParam(':pess_cep',                   $cep);
    $upDatePeople->bindParam(':pess_logradouro',            $dados['logradouroEdit']);
    $upDatePeople->bindParam(':pess_log_numero',            $dados['numberEdit']);
    $upDatePeople->bindParam(':pess_bairro',                $dados['bairroEdit']);
    $upDatePeople->bindParam(':pess_cidade',                $dados['localidadeEdit']);
    $upDatePeople->bindParam(':pess_estado',                $dados['ufEdit']);
    $upDatePeople->bindParam(':pess_edificio',              $dados['edificeEdit']);
    $upDatePeople->bindParam(':pess_bloco',                 $dados['blockEdit']);
    $upDatePeople->bindParam(':pess_apartamento',           $dados['apartmentEdit']);
    $upDatePeople->bindParam(':pess_logradouro_condominio', $dados['streetCondominiumEdit']);
    $upDatePeople->bindParam(':pess_observacao',            $dados['observationEdit']);
    $upDatePeople->bindParam(':pess_codigo',                $dados['idPeopleEdit']);

    $upDatePeople->execute() ? $returnAjax = true : $returnAjax = false;

    header('Content-Type: application/json');
    echo json_encode($returnAjax);
    exit;
}
