<?php
include_once '../app/Model/connection-pdo.php';

$idUser = filter_input(INPUT_POST, 'idUser', FILTER_SANITIZE_NUMBER_INT);

if (!empty($idUser)) {
    $queryDeleteUser = " DELETE FROM tb_usuario WHERE usu_codigo=:usu_codigo ";
    $deleteUser = $connectionDataBase->prepare($queryDeleteUser);

    $deleteUser->bindParam("usu_codigo", $idUser);
    $deleteUser->execute();

    $_SESSION['msg'] = 'Inserido com sucesso';
    header('Location: Pagina.php');

} else {
    //header("Location: /agenda/calendario");
} 
?>
