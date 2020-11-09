<?php
if (isset($_POST['typePerson']) && !empty($_POST['typePerson'])) {
    include_once '../app/Model/connection-pdo.php';

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $cep   = str_replace('-', '',  $dados['cep']);
    $dados['classificationPerson'] == "C" ? $classificationPerson = "C" : $classificationPerson = "F";

    if ($dados['typePerson'] === "F") {

        $cpf = str_replace('.', '',  $dados['cpf']);

        $queryInsertPhysicalPerson = " INSERT INTO tb_pessoas 
        (pess_tipo, 
        pess_classificacao, 
        pess_nome, 
        pess_sobrenome, 
        pess_cpfcnpj, 
        pess_cep, 
        pess_logradouro, 
        pess_log_numero, 
        pess_bairro, 
        pess_cidade, 
        pess_estado, 
        pess_edificio, 
        pess_bloco, 
        pess_apartamento, 
        pess_logradouro_condominio, 
        pess_observacao) 
        VALUES 
        (:pess_tipo, 
        :pess_classificacao, 
        :pess_nome, 
        :pess_sobrenome,
        :pess_cpfcnpj, 
        :pess_cep, 
        :pess_logradouro, 
        :pess_log_numero, 
        :pess_bairro, 
        :pess_cidade, 
        :pess_estado, 
        :pess_edificio, 
        :pess_bloco, 
        :pess_apartamento, 
        :pess_logradouro_condominio, 
        :pess_observacao) ";

        $insertPhysicalPerson = $connectionDataBase->prepare($queryInsertPhysicalPerson);
        $typePerson = "F";
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

        $queryInsertPhysicalLegal = " INSERT INTO tb_pessoas 
        (pess_tipo, 
        pess_classificacao, 
        pess_razao_social, 
        pess_nome_fantasia, 
        pess_cpfcnpj, 
        pess_cep, 
        pess_logradouro, 
        pess_log_numero, 
        pess_bairro, 
        pess_cidade, 
        pess_estado, 
        pess_edificio, 
        pess_bloco, 
        pess_apartamento, 
        pess_logradouro_condominio, 
        pess_observacao) 
        VALUES 
        (:pess_tipo, 
        :pess_classificacao, 
        :pess_razao_social, 
        :pess_nome_fantasia, 
        :pess_cpfcnpj, 
        :pess_cep, 
        :pess_logradouro, 
        :pess_log_numero, 
        :pess_bairro, 
        :pess_cidade, 
        :pess_estado, 
        :pess_edificio, 
        :pess_bloco, 
        :pess_apartamento, 
        :pess_logradouro_condominio, 
        :pess_observacao) ";

        $insertPhysicalLegal = $connectionDataBase->prepare($queryInsertPhysicalLegal);
        $typePerson = "J";
        $insertPhysicalLegal->bindParam(':pess_tipo',                  $typePerson);
        $insertPhysicalLegal->bindParam(':pess_classificacao',         $classificationPerson);
        $insertPhysicalLegal->bindParam(':pess_razao_social',          $dados['companyName']);
        $insertPhysicalLegal->bindParam(':pess_nome_fantasia',         $dados['fantasyName']);
        $insertPhysicalLegal->bindParam(':pess_cpfcnpj',               $cnpj);
        $insertPhysicalLegal->bindParam(':pess_cep',                   $cep);
        $insertPhysicalLegal->bindParam(':pess_logradouro',            $dados['logradouro']);
        $insertPhysicalLegal->bindParam(':pess_log_numero',            $dados['number']);
        $insertPhysicalLegal->bindParam(':pess_bairro',                $dados['bairro']);
        $insertPhysicalLegal->bindParam(':pess_cidade',                $dados['localidade']);
        $insertPhysicalLegal->bindParam(':pess_estado',                $dados['uf']);
        $insertPhysicalLegal->bindParam(':pess_edificio',              $dados['edifice']);
        $insertPhysicalLegal->bindParam(':pess_bloco',                 $dados['block']);
        $insertPhysicalLegal->bindParam(':pess_apartamento',           $dados['apartment']);
        $insertPhysicalLegal->bindParam(':pess_logradouro_condominio', $dados['streetCondominium']);
        $insertPhysicalLegal->bindParam(':pess_observacao',            $dados['observation']);

        $insertPhysicalLegal->execute() ? $returnAjax = 'insertPhysicalLegal' : $returnAjax = 'noInsertPhysicalLegal';
    }

    header('Content-Type: application/json');
    echo json_encode($returnAjax);
    exit;
}
