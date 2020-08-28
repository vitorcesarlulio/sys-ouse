<?php
if (isset($_POST['idUserEdit']) && !empty($_POST['idUserEdit'])) {

    include '../app/Model/connection-pdo.php';

    $idUserEdit = filter_input(INPUT_POST, 'idUserEdit', FILTER_SANITIZE_NUMBER_INT);
    $querySelectUser = " SELECT usu_codigo, usu_login, usu_nome, usu_sobrenome, usu_permissoes FROM tb_usuario ";
    
    $parametros = [];
    if (isset($idUserEdit)) {
        $querySelectUser = $querySelectUser . " WHERE usu_codigo = :id ";
        $parametros = [':id' => intval($idUserEdit)];
    }

    $searchUser = $connectionDataBase->prepare($querySelectUser);
    $searchUser->execute($parametros);

    $users = [];
    while ($rowUser = $searchUser->fetch(PDO::FETCH_ASSOC)) {
        $users[] = [
            'idUser'       => $rowUser['usu_codigo'],
            'loginUser'    => $rowUser['usu_login'],
            'nameUser'     => $rowUser['usu_nome'],
            'surnameUser'  => $rowUser['usu_sobrenome'],
            'permitionUser'=> $rowUser['usu_permissoes']
        ];
    }

    echo json_encode($users);

    
}
