<?php
if (isset($_POST['data']) && !empty($_POST['data'])) {
	include_once '../app/Model/connection-pdo.php';

	$idEvent = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);
	$valueStatus = "R";
	$valueCor = "#28A745";

	# Deletando Orçamento
	$queryUpdateStatusEvent = " UPDATE tb_eventos SET even_status=:even_status, even_cor=:even_cor WHERE even_codigo=:even_codigo ";
	$updateStatusEvent = $connectionDataBase->prepare($queryUpdateStatusEvent);
	$updateStatusEvent->bindParam(":even_status", $valueStatus);
	$updateStatusEvent->bindParam(":even_cor", $valueCor);
	$updateStatusEvent->bindParam(":even_codigo", $idEvent);
	$updateStatusEvent->execute();

	$updateStatusEvent->execute() ? $returnAjax = true : $returnAjax = false;

	header('Content-Type: application/json');
	echo json_encode($returnAjax);
	exit;
}
