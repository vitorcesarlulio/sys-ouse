<?php
session_start();
include_once '../app/Model/connection-pdo.php';

$userLogin = $_SESSION["loginUser"];

# Consultando no banco para ver se encontra algum usuário
$queryCheckLogin = " SELECT usu_login FROM tb_usuario WHERE usu_login=:usu_login ";
$selectLogin = $connectionDataBase->prepare($queryCheckLogin);
$selectLogin->bindParam("usu_login", $userLogin);
$selectLogin->execute();

# Vejo seencontrou alguma linha (registro)
$countRow = 0;
$countRow = $selectLogin->rowCount();

if ($countRow === 0) {
    header("Location: /");
}


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

# Proteger contra roubo de sessão
session_regenerate_id(true);

if ($_SESSION['canary']['IP'] !== $ipAdressUser) {
    # Destruir as sessoes, caso o ip seja diferente no meio da sessao
    foreach (array_keys($_SESSION) as $key) {
        unset($_SESSION[$key]);
        # Seto uma nova sessao
        $_SESSION['canary'] = [
            "birth" => time(),
            "IP" => $ipAdressUser
        ];
    }
}

# Se passou 5 minutos quer dizer que é o mesmo usuario 
if ($_SESSION['canary']['birth'] < time() - 300) {
    $_SESSION['canary'] = [
        "birth" => time(),
        "IP" => $ipAdressUser,
        "time" => time()
    ];
}

# Verificando as paginas internas
if (!isset($_SESSION['login']) || !isset($_SESSION['permition']) || !isset($_SESSION['canary'])) {
    foreach (array_keys($_SESSION) as $key) {
        unset($_SESSION[$key]);
    }
    echo " <script> alert('Você não está logado'); window.location.href='/'; </script> ";
} else {
    if ($_SESSION['time'] >= time() - 300) { //1200
        $_SESSION['time'] = time();
    } else {
        foreach (array_keys($_SESSION) as $key) {
            unset($_SESSION[$key]);
        }
        echo " <script> alert('Sua sessão expirou. Faça login novamente!'); window.location.href='/'; </script> ";
exit;
    }
}
