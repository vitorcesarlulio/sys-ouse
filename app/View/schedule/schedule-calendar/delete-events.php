<?php
session_start();

include_once '../app/Model/connection-pdo.php';

if (isset($_POST['idDelete']) && !empty($_POST['idDelete'])) {
    $idEvent = filter_input(INPUT_POST, 'idDelete', FILTER_SANITIZE_NUMBER_INT);
} else {
    $idEvent = filter_input(INPUT_POST, 'idEvent', FILTER_SANITIZE_NUMBER_INT);
}

if (isset($idEvent) && !empty($idEvent)) {
    $queryDeleteEvent = " DELETE FROM tb_eventos WHERE even_codigo=:even_codigo ";
    $deleteEvent = $connectionDataBase->prepare($queryDeleteEvent);
    $deleteEvent->bindParam(":even_codigo", $idEvent);

    if (isset($_POST['idDelete']) && !empty($_POST['idDelete'])) {

        $msgDeleteEvent   = "<script> toastr.success('Sucesso: evento deletado!'); </script>";
        $msgNoDeleteEvent = "<script> toastr.error('Erro: evento não deletado!'); </script>";
        # Se inserir exibe a mensagem
        if ($deleteEvent->execute()) {
            $retorna = ['sit' => true, 'msg' => $msgDeleteEvent];
            $_SESSION['msg'] = $msgDeleteEvent;
        } else {
            $retorna = ['sit' => true, 'msg' => $msgNoDeleteEvent];
        }

        header('Content-Type: application/json');
        echo json_encode($retorna);
    } else {

        if ($deleteEvent->execute()) {
            $returnAjax = true;
        } else {
            $returnAjax = false;
        }
        header('Content-Type: application/json');
        echo json_encode($returnAjax);
    }
}
