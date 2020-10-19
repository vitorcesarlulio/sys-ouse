<?php
if (isset($_POST['data']) && !empty($_POST['data'])) {
    
    include_once '../app/Model/connection-pdo.php';

    $idUser = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);
    $queryDeleteUser = " DELETE FROM tb_usuarios WHERE usu_codigo=:usu_codigo ";
    $deleteUser = $connectionDataBase->prepare($queryDeleteUser);
    $deleteUser->bindParam(":usu_codigo", $idUser);

    $deleteUser->execute() ? $returnAjax = true : $returnAjax = false;

    header('Content-Type: application/json');
    echo json_encode($returnAjax);
    exit;
}
?>