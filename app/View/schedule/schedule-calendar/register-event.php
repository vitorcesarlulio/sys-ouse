<?php
session_start();

include_once '../app/Model/connection-pdo.php';

/* Recebendo os dados que o Js esta enviando */
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

/* Verificando se a opção "Agendar Horario" foi marcada como "Sim" */
if ($dados['scheduleTime'] == "timeYes") {

    /* Converter a Data em no padrão americano */
    $dateStart = str_replace('/', '-', $dados['startDate']);
    $convertDateStart = date("Y-m-d", strtotime($dateStart));

    /* Unir a Data Inicial e a Hora Inicial*/
    $hourStart = $dados['startTime'];
    $joinDataHourStart = $convertDateStart . " " . $hourStart;

    /* Unir a Data Inicial e a Hora Final*/
    $hourEnd = $dados['endTime'];
    $joinDataHourEnd = $convertDateStart . " " . $hourEnd;

    $queryInsertEvent = "INSERT INTO events (title, start, end, status, cor) VALUES (:title, :start, :end, :status, :cor)"; //observation

    /*$queryInsertClient = "INSERT INTO tb_clientes 
                        (name, surname, cellphone, telephone, email, cep, street, neighborhood, city, state, number, edifice, block, apartment) 
                    VALUES
                        (:name, :surname, :cellphone, :telephone, :email, :cep, :street, :neighborhood, :city, :state, :number, :edifice, :block, :apartment)";
*/

    $valueStatus = "A";
    $valueCor = "";

    $insertEvent = $connectionDataBase->prepare($queryInsertEvent);
    $insertEvent->bindParam(':title', $dados['title']);
    $insertEvent->bindParam(':cor', $valueCor);
    $insertEvent->bindParam(':start', $joinDataHourStart);
    $insertEvent->bindParam(':end', $joinDataHourEnd);
    $insertEvent->bindParam(':status', $valueStatus);
    //$insertEvent->bindParam(':observation', $dados['observation']);

    /*
    $insertClient = $connectionDataBase->prepare($queryInsertClient);
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
    
    */

    $mesageSuccess = '<div id="toast-container" class="toast-top-right"><div class="toast toast-success" aria-live="polite" style=""><div class="toast-message">Sucesso: evento e cliente cadastrados!</div></div></div>';
    $mesageError   = '<div id="toast-container" class="toast-top-right"><div class="toast toast-error" aria-live="assertive" style=""><div class="toast-message">Erro: evento e cliente não cadastrados!</div></div></div>';

    if ($insertEvent->execute()) {
        $retorna = ['sit' => true, 'msg' => $mesageSuccess];
        $_SESSION['msg'] = $mesageSuccess;
    } else {
        $retorna = ['sit' => true, 'msg' => $mesageError];
    }

    header('Content-Type: application/json');
    echo json_encode($retorna);
} else if ($dados['scheduleTime'] == "timeNo") {

    //so cadastra a pessoa
}
