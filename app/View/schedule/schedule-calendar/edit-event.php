<?php
session_start();

include_once '../app/Model/connection-pdo.php';

//var que recebe os dados que o Js esta enviando                
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//Converter a data e hora do formato brasileiro para o formato do Banco de Dados

$query_event = "UPDATE events SET title=:title WHERE id=:id";

$update_event = $connectionDataBase->prepare($query_event);
$update_event->bindParam(':title', $dados['title']);

$update_event->bindParam(':id', $dados['id']);

$mesageSuccess =
    '<div id="toast-container" class="toast-top-right">
    <div class="toast toast-success" aria-live="polite" style="">
        <div class="toast-message">Evento editado com sucesso!</div>
    </div>
</div>';

$mesageError =
    '<div id="toast-container" class="toast-top-right">
    <div class="toast toast-error" aria-live="assertive" style="">
        <div class="toast-message">Erro: o evento não foi editado com sucesso!</div>
    </div>
</div>';

if ($update_event->execute()) {
    $retorna = ['sit' => true, 'msg' => $mesageSuccess];
    $_SESSION['msg'] = $mesageSuccess;
} else {
    $retorna = ['sit' => true, 'msg' => $mesageError];
}

header('Content-Type: application/json');
echo json_encode($retorna);