<?php
if (isset($_POST) && !empty($_POST)) {
    include_once '../app/Model/connection-pdo.php';
    session_start();

    if (isset($_POST['idEventBudget']) && !empty($_POST['idEventBudget'])) {
        $idEventBudget = filter_input(INPUT_POST, 'idEventBudget', FILTER_SANITIZE_NUMBER_INT);

        # Consultando evento para pegar numero do orçamento
        $querySelectEvent = " SELECT even_codigo, orca_numero FROM tb_eventos WHERE even_codigo=:even_codigo ";
        $selectEvent = $connectionDataBase->prepare($querySelectEvent);
        $selectEvent->bindParam(':even_codigo', $idEventBudget);
        $selectEvent->execute();
        $idbudget = $selectEvent->fetch(\PDO::FETCH_ASSOC);

        # Deletando Orçamento
        $queryDeleteBudget = " DELETE FROM tb_orcamento WHERE orca_numero=:orca_numero ";
        $deleteBudget = $connectionDataBase->prepare($queryDeleteBudget);
        $deleteBudget->bindParam(":orca_numero", $idbudget['orca_numero']);
        $deleteBudget->execute();

        # Deletando Evento
        $queryDeleteEvent = " DELETE FROM tb_eventos WHERE even_codigo=:even_codigo ";
        $deleteEvent = $connectionDataBase->prepare($queryDeleteEvent);
        $deleteEvent->bindParam(":even_codigo", $idEventBudget);

        $msgDeleteEvent   = "<script> toastr.success('Sucesso: evento e orçamento deletados!'); </script>";
        $msgNoDeleteEvent = "<script> toastr.error('Erro: evento e orçamento não deletados!'); </script>";

        # Se inserir exibe a mensagem
        if ($deleteEvent->execute()) {
            $retorna = ['sit' => true, 'msg' => $msgDeleteEvent];
            $_SESSION['msg'] = $msgDeleteEvent;
        } else {
            $retorna = ['sit' => true, 'msg' => $msgNoDeleteEvent];
        }

        header('Content-Type: application/json');
        echo json_encode($retorna);
        exit;
    } else if (isset($_POST['idEvent']) && !empty($_POST['idEvent'])) {
        $idEvent = filter_input(INPUT_POST, 'idEvent', FILTER_SANITIZE_NUMBER_INT);

        $queryDeleteEvent = " DELETE FROM tb_eventos WHERE even_codigo=:even_codigo ";
        $deleteEvent = $connectionDataBase->prepare($queryDeleteEvent);
        $deleteEvent->bindParam(":even_codigo", $idEvent);

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
        exit;
    }
}
