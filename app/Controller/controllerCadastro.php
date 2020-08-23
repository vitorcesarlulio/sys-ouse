<?php
$validate=new Classes\ClassValidate();
$validate->validateFields($_POST);
$validate->validateEmail($email);
$validate->validateIssetEmail($email);
var_dump($validate->getErro());

$validate->validateFinalCad($arrVar);