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

$query_event = "INSERT INTO events (title, color, start, end) VALUES (:title, :color, :start, :end)";

$insert_event = $conn->prepare($query_event);
$insert_event->bindParam(':title', $dados['title']);
$insert_event->bindParam(':color', $dados['color']);
$insert_event->bindParam(':start', $data_start_conv);
$insert_event->bindParam(':end', $data_end_conv);

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

if ($insert_event->execute()) {
    $retorna = ['sit' => true, 'msg' => $mesageSuccess];
    $_SESSION['msg'] = $mesageSuccess;
    //ou <div class="alert alert-success" role="alert"> Evento cadastrado com Sucesso! </div>
} else {
    $retorna = ['sit' => true, 'msg' => $mesageError];
}

header('Content-Type: application/json');
echo json_encode($retorna);
