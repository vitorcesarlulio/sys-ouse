<?php
include_once '../app/Model/connection-pdo.php';

# Recebendo os dados que o usuário informou e verifcando se existe os dados
if (isset($_POST['userLogin']) && isset($_POST['passwordLogin'])) {
    $userLogin     = filter_input(INPUT_POST, 'userLogin', FILTER_SANITIZE_SPECIAL_CHARS);
    $passwordLogin = filter_input(INPUT_POST, 'passwordLogin', FILTER_DEFAULT);
}
$remember = (isset($_POST['remember'])) ? $_POST['remember'] : '';

# verifico se nao esta vazio esses dados
if (!empty($userLogin) && !empty($passwordLogin)) {
    # Pegando IP do usuário
    $ipAdressUser = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipAdressUser = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipAdressUser = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipAdressUser = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipAdressUser = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipAdressUser = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipAdressUser = getenv('REMOTE_ADDR');
    else
        $ipAdressUser = 'UNKNOWN';

    # Consultando no banco para ver se encontra algum usuário
    $queryCheckLogin = " SELECT usu_login, usu_senha, usu_nome, usu_sobrenome, usu_permissoes, usu_status FROM tb_usuarios WHERE usu_login=:usu_login ";
    $selectLogin = $connectionDataBase->prepare($queryCheckLogin);
    $selectLogin->bindParam("usu_login", $userLogin);
    $selectLogin->execute();

    # Vejo seencontrou alguma linha (registro)
    $countRow = 0;
    $countRow = $selectLogin->rowCount();

    # Pegando os dados do usuario que esta tentando fazer o login
    $dataUserLogin = $selectLogin->fetch(\PDO::FETCH_ASSOC);

    # Verifico se encontrou o registro (1 sim, 0 não) e se a senha bate com a do banco
    if ($countRow === 1 && password_verify($passwordLogin, $dataUserLogin['usu_senha'])) {
        # verifico se o status dele é ativo
        if ($dataUserLogin['usu_status'] === "A") {
            # Deletando as tentativas do usuario de acordo com o ip que ele esta acessando
            $queryDeleteAttempt = " DELETE FROM tb_tentativas WHERE ten_ip=:ten_ip ";
            $deleteAttempt = $connectionDataBase->prepare($queryDeleteAttempt);
            $deleteAttempt->bindParam("ten_ip", $ipAdressUser);
            $deleteAttempt->execute();

            session_start();
            # Criando as sessions que vou usar
            $_SESSION["login"]     = true;
            $_SESSION["time"]      = time();
            $_SESSION["name"]      = $dataUserLogin['usu_nome'] . " " . $dataUserLogin['usu_sobrenome'];
            $_SESSION["loginUser"] = $dataUserLogin['usu_login'];
            $_SESSION["permition"] = $dataUserLogin['usu_permissoes'];

            # Proteger contra roubo de sessão
            $par = null;
            if ($par == null) {
                $_SESSION['canary'] = [
                    "birth" => time(),
                    "IP" => $ipAdressUser
                ];
            } else {
                $_SESSION['canary']['birth'] = time();
            }

            # Dizendo que não houve tentativas
            $attempts    = false;
            $errors      = false;
            $errorStatus = false;
            $opportunities = false;

            # Criando Cookies para o "Lembre-me"
            if ($remember == 'rememberYes') {
                $expireCookie = time() + 60 * 60 * 24 * 30; //30 dias
                setCookie('CookieRemember', base64_encode('rememberYes'), $expireCookie);
                setCookie('CookieUser', base64_encode($userLogin), $expireCookie);
                setCookie('CookiePassword', base64_encode($passwordLogin), $expireCookie);
            } else {
                setCookie('CookieRemember');
                setCookie('CookieUser');
                setCookie('CookiePassword');
            }    

        } else {
            $errorStatus = true;
            $attempts = "";
            $errors = "";
            $opportunities = false;
        }
    } else {
        # Dizendo que houve tentativas
        $errors = true;
        $errorStatus = false;

        # Opcional
        //$_SESSION["login"]     = false;

        # Contando as tentativas de erro
        $querySelectAttempt = " SELECT ten_ip, ten_data FROM tb_tentativas WHERE ten_ip=:ten_ip ";
        $selectAttempt = $connectionDataBase->prepare($querySelectAttempt);
        $selectAttempt->bindParam('ten_ip', $ipAdressUser);
        $selectAttempt->execute();

        # Pegando a data de e hora de agora
        $dateNow = date('Y-m-d H:i:s');

        $r = 0;
        while ($f = $selectAttempt->fetch(\PDO::FETCH_ASSOC)) {
            if (strtotime($f['ten_data']) > strtotime($dateNow) - 1200) { //20 minutos
                $r++;
            }
        }

        # Vendo se ja foram 5 tentativas, se sim, para de inserir
        if ($r < 5) {
            $queryinsertAttempt = " INSERT INTO tb_tentativas (ten_ip) VALUES (:ten_ip) ";
            $insertAttempt = $connectionDataBase->prepare($queryinsertAttempt);
            $insertAttempt->bindParam(':ten_ip', $ipAdressUser);
            $insertAttempt->execute();

            $opportunities = $r;
        }

        # Se errar mais de 5 vezes deixo a variavel $attempts como true
        if ($r >= 5) {
            $attempts = true;
            $opportunities = false;
        } else {
            $attempts = false;
        }
    }

    # Retornando os resultados para o Ajax
    $returnAjax = ['redirect' => '/home', 'attempts' => $attempts, 'errors' => $errors, 'errorStatus' => $errorStatus, 'opportunities' => $opportunities];
    header('Content-Type: application/json');
    echo json_encode($returnAjax);
}
