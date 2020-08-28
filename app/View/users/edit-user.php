<?php

# Recebendo os dados que o Js esta enviando
if (isset($_POST['idUserEdit']) && isset($_POST['nameUserEdit']) && isset($_POST['surnameUserEdit']) && isset($_POST['passwordUserEdit'])) {
    if (!empty($_POST['idUserEdit']) && !empty($_POST['nameUserEdit']) && !empty($_POST['surnameUserEdit']) && !empty($_POST['passwordUserEdit'])) {

        include_once '../app/Model/connection-pdo.php';

        $idUserEdit        = filter_input(INPUT_POST, 'idUserEdit', FILTER_SANITIZE_NUMBER_INT);
        $nameUserEdit      = filter_input(INPUT_POST, 'nameUserEdit', FILTER_SANITIZE_SPECIAL_CHARS);
        $surnameUserEdit   = filter_input(INPUT_POST, 'surnameUserEdit', FILTER_SANITIZE_SPECIAL_CHARS);
        $passwordUserEdit  = password_hash($_POST['passwordUserEdit'], PASSWORD_DEFAULT);
        if (isset($_POST['permitionUserEdit']) && !empty($_POST['permitionUserEdit'])) {
            $permitionUserEdit = $_POST['permitionUserEdit'];
        }
        if (isset($_POST['permitionAdminEdit']) && !empty($_POST['permitionAdminEdit'])) {
            $permitionAdminEdit = $_POST['permitionAdminEdit'];
        }

        # Query update na tb_eventos
        $queryUpdateUser = " UPDATE tb_usuario SET usu_senha=:usu_senha, usu_nome=:usu_nome, usu_sobrenome=:usu_sobrenome, usu_permissoes=:usu_permissoes WHERE usu_codigo=:usu_codigo ";

        $user = "user";
        $admin = "admin";
        # Inserindo na tb_eventos
        $updateUser = $connectionDataBase->prepare($queryUpdateUser);
        $updateUser->bindParam(':usu_codigo', $idUserEdit);
        $updateUser->bindParam(':usu_senha', $passwordUserEdit);
        $updateUser->bindParam(':usu_nome', $nameUserEdit);
        $updateUser->bindParam(':usu_sobrenome', $surnameUserEdit);
        if (!empty($permitionUserEdit)) { $updateUser->bindParam(':usu_permissoes', $user); }
        else{ $updateUser->bindParam(':usu_permissoes', $admin); }


        if ($updateUser->execute()) {
            $returnAjax = true;
        } else {
            $returnAjax = false;
        }
        header('Content-Type: application/json');
        echo json_encode($returnAjax);
    }
}
