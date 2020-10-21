<?php
if (isset($_POST['peopleRegister']) && !empty($_POST['peopleRegister']) && isset($_POST['paymentMethodRegister']) && !empty($_POST['paymentMethodRegister'])) {
}
include_once '../app/Model/connection-pdo.php';

//$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$peopleRegister         = filter_input(INPUT_POST, 'peopleRegister', FILTER_SANITIZE_NUMBER_INT);
$paymentMethodRegister  = filter_input(INPUT_POST, 'paymentMethodRegister', FILTER_SANITIZE_NUMBER_INT);
$amountRegister         = filter_input(INPUT_POST, 'amountRegister', FILTER_DEFAULT);
$installmentRegister    = filter_input(INPUT_POST, 'installmentRegister', FILTER_SANITIZE_NUMBER_INT);
$dateIssueRegister      = filter_input(INPUT_POST, 'dateIssueRegister', FILTER_SANITIZE_SPECIAL_CHARS);
$statusRegister         = filter_input(INPUT_POST, 'statusRegister', FILTER_SANITIZE_SPECIAL_CHARS);
$otherStatusRegister    = filter_input(INPUT_POST, 'otherStatusRegister', FILTER_SANITIZE_SPECIAL_CHARS);
$dateExpiryRegister     = filter_input(INPUT_POST, 'dateExpiryRegister', FILTER_SANITIZE_SPECIAL_CHARS);
$classificationRegister = filter_input(INPUT_POST, 'classificationRegister', FILTER_DEFAULT);
$observationRegister    = filter_input(INPUT_POST, 'observationRegister', FILTER_DEFAULT);

# Data de hoje 
$today = new DateTime('now');

# Padrao R de Receber
$typeAccount = "R";

# Se ele selcionar status = outro ai eu pego o valor do input
$statusRegister === 'Outro' ? $status = $otherStatusRegister  : $status = $statusRegister;

# Tratando o Valor Total e as Parcelas
$amountFormated = floatval(str_replace(",", ".", str_replace(".", "", $amountRegister))); //10000 
$num_parcelas = floatval($installmentRegister); //3

# Calculando valor das parcelas (sem jogar a diferença na ultima)
$valueInstallment = round($amountFormated / $num_parcelas, 2, PHP_ROUND_HALF_DOWN);

# Algoritmo para gerar as datas de vencimento
$parc[] = $dateExpiryRegister;
list($ano, $mes, $dia) = explode("-", $dateExpiryRegister);
for ($i = 1; $i < $installmentRegister; $i++) {
    $mes++;
    if ((int)$mes == 13) {
        $ano++;
        $mes = 1;
    }
    $tira = $dia;
    while (!checkdate($mes, $tira, $ano)) {
        $tira--;
    }
    $parc[] = sprintf("%02d-%02d-%02d", $ano, $mes, $tira);
}

$o = 0;
for ($i = 1; $i <= $installmentRegister; $i++) {

    # Se existir mais que 1 parcela ai eu faço somar os meses (data de vencimento)
    //$installmentRegister == 1 ? $date = $dateExpiryRegister : $date = $today->modify("+ 1 month")->format("Y-m-d");

    if ($installmentRegister == $i) {
        // se $i valer o que o user digitou entao faço essa conta pra ver se tem diferença para jogar na ultima parcela 333.34
        $valueInstallment = $amountFormated - $valueInstallment * ($installmentRegister - 1);
    } else {
        //se nao, continua o valor normal da parcela 333.33, 333.33
        $valueInstallment = $valueInstallment;
    }

    $queryInsertAccountReceivable = " INSERT INTO tb_receber_pagar (pess_codigo, tpg_codigo, crp_parcela, crp_valor, crp_emissao, crp_vencimento, crp_status, crp_tipo, crp_classificacao ,crp_obs) 
                                                               VALUES (:pess_codigo, :tpg_codigo, :crp_parcela, :crp_valor, :crp_emissao, :crp_vencimento, :crp_status, :crp_tipo, :crp_classificacao, :crp_obs) ";
    $insertAccountReceivable = $connectionDataBase->prepare($queryInsertAccountReceivable);
    $insertAccountReceivable->bindParam(':pess_codigo', $peopleRegister);
    $insertAccountReceivable->bindParam(':tpg_codigo', $paymentMethodRegister);
    $insertAccountReceivable->bindParam(':crp_parcela', $i);
    $insertAccountReceivable->bindParam(':crp_valor', $valueInstallment);
    $insertAccountReceivable->bindParam(':crp_emissao', $dateIssueRegister);
    $insertAccountReceivable->bindParam(':crp_vencimento', $parc[$o]);
    $insertAccountReceivable->bindParam(':crp_status', $status);
    $insertAccountReceivable->bindParam(':crp_tipo', $typeAccount);
    $insertAccountReceivable->bindParam(':crp_classificacao', $classificationRegister);
    $insertAccountReceivable->bindParam(':crp_obs', $observationRegister);
    $insertAccountReceivable->execute();
    $o++;
}
