<?php 
if (isset($_POST['loginUserRegister']) && !empty($_POST['loginUserRegister'])) {

    include_once '../app/Model/connection-pdo.php';
    
    # Verificando se ja existe o usuario no banco
    $userLogin  = filter_input(INPUT_POST, 'loginUserRegister', FILTER_SANITIZE_SPECIAL_CHARS);

    # Consultando no banco para ver se encontra algum usuário
    $queryCheckLogin = " SELECT usu_login FROM tb_usuario WHERE usu_login=:usu_login ";
    $selectLogin = $connectionDataBase->prepare($queryCheckLogin);
    $selectLogin->bindParam("usu_login", $userLogin);
    $selectLogin->execute();

    # Vejo seencontrou alguma linha (registro)
    $countRow = 0;
    $countRow = $selectLogin->rowCount();

    # Rtorno para o ajax falso ou verdadeiro
    if ($countRow != 0) {
        $returnAjax = true;
    } else {
        $returnAjax = false;
    }
    header('Content-Type: application/json');
    echo json_encode($returnAjax);
}
