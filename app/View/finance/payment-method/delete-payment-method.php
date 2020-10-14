<?php
if (isset($_POST['data']) && !empty($_POST['data'])) {

    include_once '../app/Model/connection-pdo.php';

    $idPaymentMethod = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);
    $queryDeletePaymentMethod = " DELETE FROM tb_tipo_pagamento WHERE tpg_codigo=:tpg_codigo ";
    $deletePaymentMethod = $connectionDataBase->prepare($queryDeletePaymentMethod);
    $deletePaymentMethod->bindParam(":tpg_codigo", $idPaymentMethod);

    $deletePaymentMethod->execute() ? $returnAjax = true : $returnAjax = false;

    header('Content-Type: application/json');
    echo json_encode($returnAjax);
    exit;
}
