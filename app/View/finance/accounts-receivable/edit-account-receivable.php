<?php
if (isset($_POST['idUpDate']) && !empty($_POST['idUpDate'])) {
    include_once '../app/Model/connection-pdo.php';

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (isset($dados['settledUpDate']) && !empty($dados['settledUpDate']) && $dados['settledUpDate'] == "settledUpDateYes") {
        $queryUpDateAccountReceivable =
            " UPDATE tb_receber_pagar 
            SET tpg_codigo=:tpg_codigo, 
                crp_vencimento=:crp_vencimento, 
                crp_status=:crp_status, 
                cat_codigo=:cat_codigo, 
                crp_datapagto=:crp_datapagto, 
                crp_obs=:crp_obs 
         WHERE 
            crp_numero=:crp_numero ";

        $upDateAccountReceivable = $connectionDataBase->prepare($queryUpDateAccountReceivable);
        $upDateAccountReceivable->bindParam(':crp_numero',          $dados['idUpDate']);
        $upDateAccountReceivable->bindParam(':tpg_codigo',                  $dados['paymentMethodUpDate']);
        $upDateAccountReceivable->bindParam(':crp_vencimento',             $dados['dateExpiryUpDate']);
        $upDateAccountReceivable->bindParam(':crp_status',          $dados['statusUpDate']);
        $upDateAccountReceivable->bindParam(':cat_codigo',         $dados['categoryUpDate']);
        $upDateAccountReceivable->bindParam(':crp_datapagto',         $dados['payDayUpDate']);
        $upDateAccountReceivable->bindParam(':crp_obs',         $dados['observationUpDate']);

        $upDateAccountReceivable->execute() ? $returnAjax = true : $returnAjax = false;
    } else {
        $queryUpDateAccountReceivable =
            " UPDATE tb_receber_pagar 
            SET tpg_codigo=:tpg_codigo, 
                crp_vencimento=:crp_vencimento, 
                crp_status=:crp_status, 
                cat_codigo=:cat_codigo,  
                crp_obs=:crp_obs 
         WHERE 
            crp_numero=:crp_numero ";

        $upDateAccountReceivable = $connectionDataBase->prepare($queryUpDateAccountReceivable);
        $upDateAccountReceivable->bindParam(':crp_numero',          $dados['idUpDate']);
        $upDateAccountReceivable->bindParam(':tpg_codigo',                  $dados['paymentMethodUpDate']);
        $upDateAccountReceivable->bindParam(':crp_vencimento',             $dados['dateExpiryUpDate']);
        $upDateAccountReceivable->bindParam(':crp_status',          $dados['statusUpDate']);
        $upDateAccountReceivable->bindParam(':cat_codigo',         $dados['categoryUpDate']);
        $upDateAccountReceivable->bindParam(':crp_obs',         $dados['observationUpDate']);

        $upDateAccountReceivable->execute() ? $returnAjax = true : $returnAjax = false;
    }



    header('Content-Type: application/json');
    echo json_encode($returnAjax);
    exit;
}
