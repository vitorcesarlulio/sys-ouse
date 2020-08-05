<?php
include_once '../app/Model/connection-pdo.php';

$idEvent = filter_input(INPUT_POST, 'idEvent', FILTER_SANITIZE_NUMBER_INT);

if (!empty($idEvent)) {
    $queryDeleteEvent = " DELETE FROM tb_eventos WHERE even_codigo=:even_codigo ";
    $deleteEvent = $connectionDataBase->prepare($queryDeleteEvent);

    $deleteEvent->bindParam("even_codigo", $idEvent);
    $deleteEvent->execute();

} else {
    //header("Location: /agenda/calendario");
} 
?>