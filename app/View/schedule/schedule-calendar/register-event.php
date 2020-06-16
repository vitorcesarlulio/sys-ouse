<?php
session_start();

include_once '../app/Model/connection-pdo.php';

//var que recebe os dados que o Js esta enviando                
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//Converter a data e hora do formato brasileiro para o formato do Banco de Dados
$dateStart = str_replace('/', '-', $dados['start']);
$convertDateStart = date("Y-m-d H:i:s", strtotime($dateStart));

$dateEnd = str_replace('/', '-', $dados['end']);
$convertDateEnd = date("Y-m-d H:i:s", strtotime($dateEnd));

$queryInsertEvent = "INSERT INTO events (title, cor, start, end) VALUES (:title, :cor, :start, :end)";

$insertEvent = $conn->prepare($queryInsertEvent);
$insertEvent->bindParam(':title', $dados['title']);
$insertEvent->bindParam(':cor', $dados['color']);
$insertEvent->bindParam(':start', $convertDateStart);
$insertEvent->bindParam(':end', $convertDateEnd);

$mesageSuccess =
    '<div id="toast-container" class="toast-top-right">
    <div class="toast toast-success" aria-live="polite" style="">
        <div class="toast-message">Evento cadastrado com Sucesso!</div>
    </div>
</div>';

$mesageError =
    '<div id="toast-container" class="toast-top-right">
    <div class="toast toast-error" aria-live="assertive" style="">
        <div class="toast-message">Erro: evento não cadastrado com Sucesso!</div>
    </div>
</div>';

if ($insertEvent->execute()) {
    $retorna = ['sit' => true, 'msg' => $mesageSuccess];
    $_SESSION['msg'] = $mesageSuccess;
    //ou <div class="alert alert-success" role="alert"> Evento cadastrado com Sucesso! </div>
} else {
    $retorna = ['sit' => true, 'msg' => $mesageError];
}

header('Content-Type: application/json');
echo json_encode($retorna);
