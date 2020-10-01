<?php
if (isset($_POST['idPeople']) && !empty($_POST['idPeople'])) {

    include_once '../app/Model/connection-pdo.php';

    $idPeople = filter_input(INPUT_POST, 'idPeople', FILTER_SANITIZE_NUMBER_INT);
    $queryDeleteUser = " DELETE FROM tb_pessoas WHERE pess_codigo=:pess_codigo ";
    $deletePeople = $connectionDataBase->prepare($queryDeleteUser);
    $deletePeople->bindParam(":pess_codigo", $idPeople);

    if ($deletePeople->execute()) {
        $returnAjax = true;
    } else {
        $returnAjax = false;
    }

    header('Content-Type: application/json');
    echo json_encode($returnAjax);
    exit;
}
