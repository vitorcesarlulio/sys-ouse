<?php
session_start();

include_once '../app/Model/connection-pdo.php';

$idEvent = filter_input(INPUT_GET, 'idEvent', FILTER_SANITIZE_NUMBER_INT);

$mesageSuccess = '<div id="toast-container" class="toast-top-right"><div class="toast toast-success" aria-live="polite" style=""><div class="toast-message">Evento apagado com sucesso!</div></div></div>';

$mesageError = '<div id="toast-container" class="toast-top-right"><div class="toast toast-error" aria-live="assertive" style=""><div class="toast-message">Erro: o evento não foi apagado com sucesso!</div></div></div>';

if (!empty($idEvent)) {
    $queryDeleteEvent = "DELETE FROM tb_eventos WHERE even_codigo=:even_codigo";
    $deleteEvent = $connectionDataBase->prepare($queryDeleteEvent);

    $deleteEvent->bindParam("even_codigo", $idEvent);

    if ($deleteEvent->execute()) {
        $_SESSION['msg'] = $mesageSuccess;
        header("Location: /agenda/calendario");
    } else {
        $_SESSION['msg'] = $mesageError;
        header("Location: /agenda/calendario");
    }
} else {
    $_SESSION['msg'] = $mesageError;
    header("Location: /agenda/calendario");
}
