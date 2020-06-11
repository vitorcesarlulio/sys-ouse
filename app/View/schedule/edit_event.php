<?php
session_start();

include_once '../app/Model/conexao.php';

//var que recebe os dados que o Js esta enviando                
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//Converter a data e hora do formato brasileiro para o formato do Banco de Dados
$data_start = str_replace('/', '-', $dados['start']);
$data_start_conv = date("Y-m-d H:i:s", strtotime($data_start));

$data_end = str_replace('/', '-', $dados['end']);
$data_end_conv = date("Y-m-d H:i:s", strtotime($data_end));

$query_event = "UPDATE events SET title=:title, color=:color, start=:start, end=:end WHERE id=:id";

$update_event = $conn->prepare($query_event);
$update_event->bindParam(':title', $dados['title']);
$update_event->bindParam(':color', $dados['color']);
$update_event->bindParam(':start', $data_start_conv);
$update_event->bindParam(':end', $data_end_conv);
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
