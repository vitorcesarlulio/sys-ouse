<?php
session_start();
include_once '../app/Model/connection-pdo.php';

# Recebendo os dados que o Js esta enviando 
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

# Query inserir na tb_eventos
$queryinsertUser = "INSERT INTO tb_usuario (usu_login, usu_senha, usu_nome, usu_sobrenome) VALUES (:usu_login, :usu_senha, :usu_nome, :usu_sobrenome)";

# Inserindo na tb_eventos
$insertUser = $connectionDataBase->prepare($queryinsertUser);
$insertUser->bindParam(':usu_login',      $dados['loginUserRegister']);
$insertUser->bindParam(':usu_senha',      $dados['passwordUserRegister']);
$insertUser->bindParam(':usu_nome',      $dados['nameUserRegister']);
$insertUser->bindParam(':usu_sobrenome', $dados['surnameUserRegister']);

$insertUser->execute();

//header('Location: /usuarios');
//header('Content-Type: application/json');

//echo json_encode();
