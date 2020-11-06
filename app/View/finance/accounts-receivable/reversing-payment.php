<?php
if (isset($_POST['idAccountReceivable']) && !empty($_POST['idAccountReceivable'])) {
    include_once '../app/Model/connection-pdo.php';

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $queryUpDateAccountReceivable =
        " UPDATE tb_receber_pagar 
            SET crp_datapagto=:crp_datapagto, 
                crp_status=:crp_status
         WHERE 
            crp_numero=:crp_numero ";

    $crp_datapagto = null;
    $crp_status = "ABERTO";
    $upDateAccountReceivable = $connectionDataBase->prepare($queryUpDateAccountReceivable);
    $upDateAccountReceivable->bindParam(':crp_numero',     $dados['idAccountReceivable']);
    $upDateAccountReceivable->bindParam(':crp_datapagto', $crp_datapagto);
    $upDateAccountReceivable->bindParam(':crp_status',     $crp_status);

    $upDateAccountReceivable->execute() ? $returnAjax = true : $returnAjax = false;

    header('Content-Type: application/json');
    echo json_encode($returnAjax);
    exit;
}
