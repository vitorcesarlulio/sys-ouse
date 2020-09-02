<?php
if (isset($_POST['idUser']) && !empty($_POST['idUser'])) {
    
    include_once '../app/Model/connection-pdo.php';

    $idUser = filter_input(INPUT_POST, 'idUser', FILTER_SANITIZE_NUMBER_INT);
    $queryDeleteUser = " DELETE FROM tb_usuarios WHERE usu_codigo=:usu_codigo ";
    $deleteUser = $connectionDataBase->prepare($queryDeleteUser);
    $deleteUser->bindParam("usu_codigo", $idUser);

    if ($deleteUser->execute()) {
        $returnAjax = true;
    }else {
        $returnAjax = false;
    }
    header('Content-Type: application/json');
    echo json_encode($returnAjax);
}
?>