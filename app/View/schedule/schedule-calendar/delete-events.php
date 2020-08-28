<?php
session_start();

include_once '../app/Model/connection-pdo.php';

$idEvent = filter_input(INPUT_POST, 'idEvent', FILTER_SANITIZE_NUMBER_INT);

if (isset($idEvent) && !empty($idEvent)) {
    $queryDeleteEvent = " DELETE FROM tb_eventos WHERE even_codigo=:even_codigo ";
    $deleteEvent = $connectionDataBase->prepare($queryDeleteEvent);

    $deleteEvent->bindParam("even_codigo", $idEvent);

    if ($deleteEvent->execute()) {
        $returnAjax = true;
    }else {
        $returnAjax = false;
    }
    
    header('Content-Type: application/json');
    echo json_encode($returnAjax);
} 
