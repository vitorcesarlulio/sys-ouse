<?php
if (isset($_POST['data']) && !empty($_POST['data'])) {

    include_once '../app/Model/connection-pdo.php';

    $idInstallment = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);
    $queryDeleteInstallment = " DELETE FROM tb_receber_pagar WHERE crp_numero=:crp_numero AND crp_tipo = 'R' ";
    $deleteInstallment = $connectionDataBase->prepare($queryDeleteInstallment);
    $deleteInstallment->bindParam(":crp_numero", $idInstallment);

    $deleteInstallment->execute() ? $returnAjax = true : $returnAjax = false;

    header('Content-Type: application/json');
    echo json_encode($returnAjax);
    exit;
}
