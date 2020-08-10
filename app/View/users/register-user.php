<?php
include_once '../app/Model/connection-pdo.php';

# Recebendo os dados que o Js esta enviando 
//$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$loginUserRegister    = filter_input(INPUT_POST, 'loginUserRegister'  , FILTER_SANITIZE_SPECIAL_CHARS);
$nameUserRegister     = filter_input(INPUT_POST, 'nameUserRegister'   , FILTER_SANITIZE_SPECIAL_CHARS);
$surnameUserRegister  = filter_input(INPUT_POST, 'surnameUserRegister', FILTER_SANITIZE_SPECIAL_CHARS);
$passwordUserRegister = password_hash($_POST['passwordUserRegister'] , PASSWORD_DEFAULT);
//$token = bin2hex(random_bytes(64));

# Verificando no Banco de Dados se existe o usuario
$queryCheckLogin = " SELECT * FROM tb_usuario WHERE usu_login=:usu_login";
$selectLogin = $connectionDataBase->prepare($queryCheckLogin);
$selectLogin->bindParam("usu_login", $userLogin);
$selectLogin->execute();
$countRow = $selectLogin->rowCount(); 


# Query inserir na tb_eventos
$queryinsertUser = " INSERT INTO tb_usuario (usu_login, usu_senha, usu_nome, usu_sobrenome) VALUES (:usu_login, :usu_senha, :usu_nome, :usu_sobrenome) ";

# Inserindo na tb_eventos
$insertUser = $connectionDataBase->prepare($queryinsertUser);
$insertUser->bindParam(':usu_login'    , $loginUserRegister);
$insertUser->bindParam(':usu_senha'    , $passwordUserRegister);
$insertUser->bindParam(':usu_nome'     , $nameUserRegister);
$insertUser->bindParam(':usu_sobrenome', $surnameUserRegister);

$insertUser->execute();

//header('Location: /usuarios');
//header('Content-Type: application/json');

//echo json_encode();