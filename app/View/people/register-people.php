<?php

if (isset($_POST['typePerson']) && !empty($_POST['typePerson'])) {
    include_once '../app/Model/connection-pdo.php';

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $cep   = str_replace('-', '',  $dados['cep']);
    $dados['classificationPerson'] == "C" ? $classificationPerson = "C" : $classificationPerson = "F"; 

    if ($dados['typePerson'] === "F") {

        $cpf = str_replace('.', '',  $dados['cpf']);

        $queryInsertPhysicalPerson = " INSERT INTO tb_pessoas (pess_tipo, pess_classificacao, pess_nome, pess_sobrenome, pess_cpfcnpj, pess_cep, pess_logradouro, pess_log_numero, pess_bairro, pess_cidade, pess_estado, pess_edificio, pess_bloco, pess_apartamento, pess_logradouro_condominio, pess_observacao) VALUES (:pess_tipo, :pess_classificacao, :pess_nome, :pess_sobrenome, :pess_cpfcnpj, :pess_cep, :pess_logradouro, :pess_log_numero, :pess_bairro, :pess_cidade, :pess_estado, :pess_edificio, :pess_bloco, :pess_apartamento, :pess_logradouro_condominio, :pess_observacao) ";
        $typePerson = "F";
        $insertPhysicalPerson = $connectionDataBase->prepare($queryInsertPhysicalPerson);
        $insertPhysicalPerson->bindParam(':pess_tipo',                  $typePerson);
        $insertPhysicalPerson->bindParam(':pess_classificacao',         $classificationPerson);
        $insertPhysicalPerson->bindParam(':pess_nome',                  $dados['name']);
        $insertPhysicalPerson->bindParam(':pess_sobrenome',             $dados['surname']);
        $insertPhysicalPerson->bindParam(':pess_cpfcnpj',               $cpf);
        $insertPhysicalPerson->bindParam(':pess_cep',                   $cep);
        $insertPhysicalPerson->bindParam(':pess_logradouro',            $dados['logradouro']);
        $insertPhysicalPerson->bindParam(':pess_log_numero',            $dados['number']);
        $insertPhysicalPerson->bindParam(':pess_bairro',                $dados['bairro']);
        $insertPhysicalPerson->bindParam(':pess_cidade',                $dados['localidade']);
        $insertPhysicalPerson->bindParam(':pess_estado',                $dados['uf']);
        $insertPhysicalPerson->bindParam(':pess_edificio',              $dados['edifice']);
        $insertPhysicalPerson->bindParam(':pess_bloco',                 $dados['block']);
        $insertPhysicalPerson->bindParam(':pess_apartamento',           $dados['apartment']);
        $insertPhysicalPerson->bindParam(':pess_logradouro_condominio', $dados['streetCondominium']);
        $insertPhysicalPerson->bindParam(':pess_observacao',            $dados['observation']);

        $insertPhysicalPerson->execute() ? $returnAjax = 'insertPhysicalPerson' : $returnAjax = 'noInsertPhysicalPerson';

    } else if ($dados['typePerson'] === "J") {

        $cnpj = str_replace(['.', '/', '-'], '',  $dados['cnpj']);

        $queryInsertPhysicalLegal = " INSERT INTO tb_pessoas (pess_tipo, pess_classificacao, pess_razao_social, pess_nome_fantasia, pess_cpfcnpj, pess_cep, pess_logradouro, pess_log_numero, pess_bairro, pess_cidade, pess_estado, pess_edificio, pess_bloco, pess_apartamento, pess_logradouro_condominio, pess_observacao) VALUES (:pess_tipo, :pess_razao_social, :pess_nome_fantasia, :pess_cpfcnpj, :pess_cep, :pess_logradouro, :pess_log_numero, :pess_bairro, :pess_cidade, :pess_estado, :pess_edificio, :pess_bloco, :pess_apartamento, :pess_logradouro_condominio, :pess_observacao) ";
        $typePerson = "J";
        $queryInsertPhysicalLegal = $connectionDataBase->prepare($queryInsertPhysicalLegal);
        $queryInsertPhysicalLegal->bindParam(':pess_tipo',                  $typePerson);
        $queryInsertPhysicalLegal->bindParam(':pess_classificacao',         $classificationPerson);
        $queryInsertPhysicalLegal->bindParam(':pess_razao_social',          $dados['companyName']);
        $queryInsertPhysicalLegal->bindParam(':pess_nome_fantasia',         $dados['fantasyName']);
        $queryInsertPhysicalLegal->bindParam(':pess_cpfcnpj',               $cnpj);
        $queryInsertPhysicalLegal->bindParam(':pess_cep',                   $cep);
        $queryInsertPhysicalLegal->bindParam(':pess_logradouro',            $dados['logradouro']);
        $queryInsertPhysicalLegal->bindParam(':pess_log_numero',            $dados['number']);
        $queryInsertPhysicalLegal->bindParam(':pess_bairro',                $dados['bairro']);
        $queryInsertPhysicalLegal->bindParam(':pess_cidade',                $dados['localidade']);
        $queryInsertPhysicalLegal->bindParam(':pess_estado',                $dados['uf']);
        $queryInsertPhysicalLegal->bindParam(':pess_edificio',              $dados['edifice']);
        $queryInsertPhysicalLegal->bindParam(':pess_bloco',                 $dados['block']);
        $queryInsertPhysicalLegal->bindParam(':pess_apartamento',           $dados['apartment']);
        $queryInsertPhysicalLegal->bindParam(':pess_logradouro_condominio', $dados['streetCondominium']);
        $queryInsertPhysicalLegal->bindParam(':pess_observacao',            $dados['observation']);

        $queryInsertPhysicalLegal->execute() ? $returnAjax = 'insertPhysicalLegal' : $returnAjax = 'noInsertPhysicalLegal';
    }

    header('Content-Type: application/json');
    echo json_encode($returnAjax);
}
