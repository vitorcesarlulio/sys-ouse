<?php

if (isset($_POST['idPeopleContact']) && !empty($_POST['idPeopleContact']) && isset($_POST['typeContact']) && !empty($_POST['typeContact']) 
    && isset($_POST['responsibleContact']) && !empty($_POST['responsibleContact']) && isset($_POST['contact']) && !empty($_POST['contact'])) {
    include_once '../app/Model/connection-pdo.php';

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $subject = ['(', ')', '-', ' '];
    if (strlen($dados['contact']) == 15) {
        # Tirar mascara do Celular
        $contato = str_replace($subject, '', $dados['contact']);
    }else if (strlen($dados['contact']) == 14) {
        # Tirar mascara do Telefone
        $contato = str_replace($subject, '',  $dados['contact']);
    } else {
        $contato = $dados['contact'];
    } 

    $queryInsertContact = " INSERT INTO tb_contatos (cont_tipo, cont_responsavel, cont_contato, pess_codigo) VALUES (:cont_tipo, :cont_responsavel, :cont_contato, :pess_codigo) ";
    $insertContact = $connectionDataBase->prepare($queryInsertContact);
    $insertContact->bindParam(':cont_tipo',        $dados['typeContact']);
    $insertContact->bindParam(':cont_responsavel', $dados['responsibleContact']);
    $insertContact->bindParam(':cont_contato',     $contato);
    $insertContact->bindParam(':pess_codigo',      $dados['idPeopleContact']);

    $insertContact->execute() ? $returnAjax = true : $returnAjax = false;

    header('Content-Type: application/json');
    echo json_encode($returnAjax);
} else {
    header('Content-Type: application/json');
    $returnAjax = 'emptyFilds';
    echo json_encode($returnAjax);
}
