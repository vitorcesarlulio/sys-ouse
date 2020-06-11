<?php
session_start();

include_once '../app/Model/conexao.php';

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
    $query_event = "DELETE FROM events WHERE id=:id";
    $delete_event = $conn->prepare($query_event);

    $delete_event->bindParam("id", $id);

    if ($delete_event->execute()) {
        $_SESSION['msg'] = $mesageSuccess;
        header("Location: /calendario");
    } else {
        $_SESSION['msg'] = $mesageError;
        header("Location: /calendario");
    }
} else {
    $_SESSION['msg'] = $mesageError;
    header("Location: /calendario");
}
