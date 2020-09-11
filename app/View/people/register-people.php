<?php
# Recebendo os dados que o Js esta enviando
if (isset($_POST['loginUserRegister']) && isset($_POST['nameUserRegister']) && isset($_POST['surnameUserRegister']) && isset($_POST['passwordUserRegister'])) {
    if (!empty($_POST['loginUserRegister']) && !empty($_POST['nameUserRegister']) && !empty($_POST['surnameUserRegister']) && !empty($_POST['passwordUserRegister'])) {
        
        include_once '../app/Model/connection-pdo.php';

        $loginUserRegister     = filter_input(INPUT_POST,  'loginUserRegister'     , FILTER_SANITIZE_SPECIAL_CHARS);
        $nameUserRegister      = filter_input(INPUT_POST,  'nameUserRegister'      , FILTER_SANITIZE_SPECIAL_CHARS);
        $surnameUserRegister   = filter_input(INPUT_POST,  'surnameUserRegister'   , FILTER_SANITIZE_SPECIAL_CHARS);
        $permitionUserRegister = filter_input(INPUT_POST,  'permitionUserRegister' , FILTER_DEFAULT);
        $permitionAdminRegister = filter_input(INPUT_POST, 'permitionAdminRegister', FILTER_DEFAULT);
        $statusActiveUserRegister = filter_input(INPUT_POST,  'statusActiveUserRegister' , FILTER_DEFAULT);
        $statusInactiveRegister = filter_input(INPUT_POST, 'statusInactiveRegister', FILTER_DEFAULT);
        $passwordUserRegister  = password_hash($_POST['passwordUserRegister'], PASSWORD_DEFAULT);

        # Query inserir na tb_eventos
        $queryinsertUser = " INSERT INTO tb_usuarios (usu_login, usu_senha, usu_nome, usu_sobrenome, usu_permissoes, usu_status) VALUES (:usu_login, :usu_senha, :usu_nome, :usu_sobrenome, :usu_permissoes, :usu_status) ";

        $user = "user";
        $admin = "admin";
        $active = "A";
        $inactive = "I";
        # Inserindo na tb_eventos
        $insertUser = $connectionDataBase->prepare($queryinsertUser);
        $insertUser->bindParam(':usu_login'     , $loginUserRegister);
        $insertUser->bindParam(':usu_senha'     , $passwordUserRegister);
        $insertUser->bindParam(':usu_nome'      , $nameUserRegister);
        $insertUser->bindParam(':usu_sobrenome' , $surnameUserRegister);
        if (!empty($permitionUserRegister)) { $insertUser->bindParam(':usu_permissoes', $user); }
        else { $insertUser->bindParam(':usu_permissoes', $admin); }

        if (!empty($statusActiveUserRegister)) { $insertUser->bindParam(':usu_status', $active); }
        else { $insertUser->bindParam(':usu_status', $inactive); }
        
        if ($insertUser->execute()) {
            $returnAjax = true;
        }else {
            $returnAjax = false;
        }
        
        header('Content-Type: application/json');
        echo json_encode($returnAjax);
    }
}