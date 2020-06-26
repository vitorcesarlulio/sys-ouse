<?php
session_start();

include_once '../app/Model/connection-pdo.php';

//var que recebe os dados que o Js esta enviando                
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//Converter a data e hora do formato brasileiro para o formato do Banco de Dados
$dateStart = str_replace('/', '-', $dados['startDate']);
$convertDateStart = date("Y-m-d", strtotime($dateStart));

$hourStart = $dados['startTime'];
$joinDataHourStart = $convertDateStart . " " . $hourStart;

$dateEnd = str_replace('/', '-', $dados['endDate']);
$convertDateEnd = date("Y-m-d", strtotime($dateEnd));

$hourEnd = $dados['endTime'];
$joinDataHourEnd = $convertDateStart . " " . $hourEnd;

$queryInsertEvent = "INSERT INTO events (title, cor, start, end) VALUES (:title, :cor, :start, :end)";//observation
/*$queryInsertClient = "INSERT INTO tb_clientes 
                        (name, surname, cellphone, telephone, email, cep, street, neighborhood, city, state, number, edifice, block, apartment) 
                    VALUES
                        (:name, :surname, :cellphone, :telephone, :email, :cep, :street, :neighborhood, :city, :state, :number, :edifice, :block, :apartment)";
*/

$insertEvent = $conn->prepare($queryInsertEvent);
$insertEvent->bindParam(':title', $dados['title']);
$insertEvent->bindParam(':cor', $dados['color']);
$insertEvent->bindParam(':start', $joinDataHourStart);
$insertEvent->bindParam(':end', $joinDataHourEnd);
//$insertEvent->bindParam(':observation', $dados['observation']);

/*
$insertClient = $conn->prepare($queryInsertClient);
$insertClient->bindParam(':name', $dados['name']);
$insertClient->bindParam(':surname', $dados['surname']);
$insertClient->bindParam(':cellphone', $dados['cellphone']);
$insertClient->bindParam(':telephone', $dados['telephone']);
$insertClient->bindParam(':email', $dados['email']);
$insertClient->bindParam(':cep', $dados['cep']);
$insertClient->bindParam(':street', $dados['street']);
$insertClient->bindParam(':neighborhood', $dados['neighborhood']);
$insertClient->bindParam(':city', $dados['city']);
$insertClient->bindParam(':state', $dados['state']);
$insertClient->bindParam(':edifice', $dados['edifice']);
$insertClient->bindParam(':block', $dados['block']);
$insertClient->bindParam(':apartment', $dados['apartment']);
v
*/

/*
name  
surname 
cellphone
 telephone 
 email 
 cep 
 street 
 neighborhood
  city 
  state 
  number 
  edifice 
  block 
  apartment
 */

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
} else {
    $retorna = ['sit' => true, 'msg' => $mesageError];
}

header('Content-Type: application/json');
echo json_encode($retorna);
