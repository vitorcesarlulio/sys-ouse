<?php
include_once '../app/Model/connection-pdo.php';

# Pegando IP
$ipaddress = '';
if (getenv('HTTP_CLIENT_IP'))
    $ipaddress = getenv('HTTP_CLIENT_IP');
else if (getenv('HTTP_X_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
else if (getenv('HTTP_X_FORWARDED'))
    $ipaddress = getenv('HTTP_X_FORWARDED');
else if (getenv('HTTP_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_FORWARDED_FOR');
else if (getenv('HTTP_FORWARDED'))
    $ipaddress = getenv('HTTP_FORWARDED');
else if (getenv('REMOTE_ADDR'))
    $ipaddress = getenv('REMOTE_ADDR');
else
    $ipaddress = 'UNKNOWN';

$userLogin     = filter_input(INPUT_POST, 'userLogin', FILTER_SANITIZE_SPECIAL_CHARS);
$passwordLogin = filter_input(INPUT_POST, 'passwordLogin', FILTER_DEFAULT);

# Verificando no Banco de Dados se existe o usuario
$queryCheckLogin = " SELECT * FROM tb_usuario WHERE usu_login=:usu_login";
$selectLogin = $connectionDataBase->prepare($queryCheckLogin);
$selectLogin->bindParam("usu_login", $userLogin);
$selectLogin->execute();

# Vejo seencontrou alguma linha (registro)
$countRow = 0;
$countRow = $selectLogin->rowCount();

# Pegando os dados do usuario que esta tentando fazer o login
$dataUserLogin = $selectLogin->fetch(\PDO::FETCH_ASSOC);

# Verifico se encontrou o registro (1 sim, 0 não)
if ($countRow === 1) {
    # Descriptografo a senha (true ou false)
    $checkPassword = password_verify($passwordLogin, $dataUserLogin['usu_senha']);

    # Verifico se as senhas realmente sao iguais
    if ($checkPassword === true) {
        echo 'entrou'; 

        # Deletando as tentativas do usuario de acordo com o ip que ele esta acessando
        $queryDeleteAttempt = " DELETE FROM tb_tentativas WHERE ten_ip=:ten_ip ";
        $deleteAttempt = $connectionDataBase->prepare($queryDeleteAttempt);
        $deleteAttempt->bindParam("ten_ip", $ipaddress);
        $deleteAttempt->execute();

        if (session_id() == '') {
            ini_set("session.save_handler", "files");
            ini_set("session.use_cookies", 1);
            ini_set("session.use_only_cookies", 1);
            ini_set("session.cookie_domain", DOMAIN);
            ini_set("session.cookie_httponly", 1);
            if (DOMAIN != "localhost") {
                ini_set("session.cookie_secure", 1);
            }

            /*Criptografia das nossas sessions*/
            ini_set("session.entropy_length", 512);
            ini_set("session.entropy_file", '/dev/urandom');
            ini_set("session.hash_function", 'sha256');
            ini_set("session.hash_bits_per_character", 5);
            session_start();
        }

        # Criando as sessions que vou usar
        $_SESSION["login"]     = true;
        $_SESSION["time"]      = time();
        $_SESSION["name"]      = $dataUserLogin['usu_nome'];
        $_SESSION["loginUser"] = $dataUserLogin['usu_login'];
        $_SESSION["permition"] = $dataUserLogin['usu_permissoes'];

        session_regenerate_id(true);
        $par = null;
        if($par === null){
            $_SESSION['canary']=[
                "birth" => time(),
                "IP" => $ipaddress
            ];
        }else{
            $_SESSION['canary']["birth"]=time();
        }

        # Vejo se a Session canary existe, se nao ja seto eu 
        if (!isset($_SESSION['canary'])) {
            $_SESSION['canary']=[
                "birth" => time(),
                "IP" => $ipaddress
            ];
        }

        if ($_SESSION['canary']["IP"] !== $ipaddress) {
            #Destruir as sessoes, caso o ip seja diferente no meio da sessao
            foreach (array_keys($_SESSION) as $key) {
                unset($_SESSION[$key]);
                $_SESSION['canary']=[
                    "birth" => time(),
                    "IP" => $ipaddress
                ];
            }
        }

        # Se passou 5 minutos quer dizer que é o mesmo usuario 
        if ($_SESSION['canary']["birth"] < time() - 300) {
            $_SESSION['canary']=[
                "birth" => time(),
                "IP" => $ipaddress,
                "time" => time()
            ];

        }

        # Verificando as paginas internas
        if (!isset($_SESSION['login']) || !isset($_SESSION['permition']) || !isset($_SESSION['canary'])) {
            foreach (array_keys($_SESSION) as $key) {
                unset($_SESSION[$key]);
            }
            echo "<script> alert('Voce nao esta logado'); window.location.href='/login'; </script>";
        }else{
            if ($_SESSION['time'] >= time() - 1200) {
                $_SESSION['time'] = time();
            }else{
                foreach (array_keys($_SESSION) as $key) {
                    unset($_SESSION[$key]);
                }
                echo "<script> alert('Sua sessao expirou'); window.location.href='/login'; </script>";
            }
        }
    } else {
        echo 'usuario ou senha incorretos'; //ou senha incorreta

        # Contando as tentativas de erro
        $querySelectAttempt = " SELECT * FROM tb_tentativa WHERE ten_ip=:ten_ip";
        $selectAttempt = $connectionDataBase->prepare($querySelectAttempt);
        $selectAttempt->bindParam("ten_ip", $ipaddress);
        $selectAttempt->execute();
        $f = $selectAttempt->fetch(\PDO::FETCH_ASSOC);
        $dateNow = date('Y-m-d H:i:s');
        $r = 0;
        while ($f = $selectAttempt->fetch(\PDO::FETCH_ASSOC)) {
            if ($f["ten_data"] > $dateNow - 1200) { //20 minutos
                $r++;
            }
        }
        echo $r;

        # Vendo se ja foram 5 tentativas, se sim, para de inserir
        if ($r < 5) {
            $queryinsertAttempt = " INSERT INTO tb_tentativas (ten_ip) VALUES (:ten_ip) ";
            $insertAttempt = $connectionDataBase->prepare($queryinsertAttempt);
            $insertAttempt->bindParam(':ten_ip', $ipaddress);
            $insertAttempt->execute();
        }

        # Se errar mais de 5 vezes exibi a mensagem
        if ($r >= 5) {
            echo "Voce realizou mais de 5 tentativas";
            $tentativas = true;
        } else {
            $tentativas = false;
        }
    }
} else {
    echo 'usuario ou senha incorretos'; //ou user inexistente
}
