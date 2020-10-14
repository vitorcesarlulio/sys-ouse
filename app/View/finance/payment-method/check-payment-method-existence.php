<?php
if (isset($_POST['descriptionRegister']) && !empty($_POST['descriptionRegister']) && isset($_POST['installmentRegister']) && !empty($_POST['installmentRegister'])) {
}

include_once '../app/Model/connection-pdo.php';

$descriptionPaymentMethod = $_POST['descriptionRegister'] . " " . $_POST['installmentRegister'] . "x";

$queryCheckPaymentMethod = " SELECT tpg_descricao FROM tb_tipo_pagamento WHERE tpg_descricao=:tpg_descricao ";
$selectPaymentMethod = $connectionDataBase->prepare($queryCheckPaymentMethod);
$selectPaymentMethod->bindParam(":tpg_descricao", $descriptionPaymentMethod);
$selectPaymentMethod->execute();

$countRow = 0;
$countRow = $selectPaymentMethod->rowCount();

$countRow === 0 ? $returnAjax = false : $returnAjax = true;

header('Content-Type: application/json');
echo json_encode($returnAjax);
