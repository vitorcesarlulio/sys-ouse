<?php
session_start();

include_once '../app/Model/connection-pdo.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$mesageSuccess =
    '<div id="toast-container" class="toast-top-right">
    <div class="toast toast-success" aria-live="polite" style="">
        <div class="toast-message">Evento apagado com sucesso!</div>
    </div>
</div>';

$mesageError =
    '<div id="toast-container" class="toast-top-right">
    <div class="toast toast-error" aria-live="assertive" style="">
        <div class="toast-message">Erro: o evento não foi apagado com sucesso!</div>
    </div>
</div>';

if (!empty($id)) {
    $queryDeleteEvent = "DELETE FROM events WHERE id=:id";
    $deleteEvent = $conn->prepare($queryDeleteEvent);

    $deleteEvent->bindParam("id", $id);

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
