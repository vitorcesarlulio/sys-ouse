<?php 
$validate=new Classes\ClassValidate();
// $validate->validateFields($_POST);
// $validate->validateEmail($email);
$loginUser = $_POST['userLogin'];
$validate->validateIssetEmail($loginUser, "login");

var_dump($validete->getErro());
?>