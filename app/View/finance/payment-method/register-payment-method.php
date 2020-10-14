<?php

if (isset($_POST['descriptionRegister']) && !empty($_POST['descriptionRegister']) && isset($_POST['installmentRegister']) && !empty($_POST['installmentRegister'])) {
    include_once '../app/Model/connection-pdo.php';

    $description     = filter_input(INPUT_POST, 'descriptionRegister', FILTER_SANITIZE_SPECIAL_CHARS);
    $installment = filter_input(INPUT_POST, 'installmentRegister', FILTER_VALIDATE_INT);

    $queryInsertPaymentMethod = " INSERT INTO tb_tipo_pagamento (tpg_descricao, tpg_parcelas, tpg_observacao) VALUES (:tpg_descricao, :tpg_parcelas, :tpg_observacao) ";
    $descriptionPaymentMethod = $description . " " . $installment . "x";
    $insertPaymentMethod = $connectionDataBase->prepare($queryInsertPaymentMethod);
    $insertPaymentMethod->bindParam(':tpg_descricao',  $descriptionPaymentMethod);
    $insertPaymentMethod->bindParam(':tpg_parcelas', $installment);
    $insertPaymentMethod->bindParam(':tpg_observacao', $_POST['observationRegister']);

    $insertPaymentMethod->execute() ? $returnAjax = true : $returnAjax = false;

    header('Content-Type: application/json');
    echo json_encode($returnAjax);
}
