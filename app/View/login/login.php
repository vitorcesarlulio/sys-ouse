<?php
include_once '../app/Model/connection-pdo.php';

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

if ($r >= 5) {
    $block = true;
} else {
    $block = false;
}

# Lembre-me
$loginRemember    = (isset($_COOKIE['CookieUser'])) ? base64_decode($_COOKIE['CookieUser']) : '';
$passwordRemember = (isset($_COOKIE['CookiePassword'])) ? base64_decode($_COOKIE['CookiePassword']) : '';
$remember         = (isset($_COOKIE['CookieRemember'])) ? base64_decode($_COOKIE['CookieRemember']) : '';
$checkedRemember  = ($remember == 'rememberYes') ? 'checked' : '';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Ouse Inteligência em Marcas">
    <title>Sys Ouse | Log in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= DIRPLUGINS . 'fontawesome-free/css/all.min.css' ?>">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= DIRPLUGINS . 'icheck-bootstrap/icheck-bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?= DIRCSS . 'adminlte.min.css' ?>">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="<?= DIRPLUGINS . 'toastr/toastr.min.css' ?>">
    <style>
        .login-page {
            background-image: url("<?= DIRIMG . 'image-rio-janeiro-ouse-inteligencia-em-marcas.jpg' ?>");
            max-width: 100%;
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }

        .btn-primary {
            background-color: #FE5000;
            border-color: #FE5000;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #F23207;
            border-color: #F23207;
            color: #fff;
        }

        .btn.disabled, .btn:disabled{
            background-color: #F23207;
            border-color: #F23207;
            color: #fff;
        }

        .icheck-primary>input:first-child:checked+input[type=hidden]+label::before,
        .icheck-primary>input:first-child:checked+label::before {
            background-color: #FE5000;
            border-color: #FE5000;
        }

        .login-card-body,
        .register-card-body {
            color: #000;
        }

        /*         @font-face {
            font-family: 'montserratmedium';
            src: url("<?= DIRIMG . 'montserrat-medium-webfont.woff2' ?>") format('woff2'),
                url("<?= DIRIMG . 'montserrat-medium-webfont.woff' ?>") format('woff');
            font-weight: normal;
            font-style: normal;

        }

        * {
            font-family: 'montserratmedium';
        } */
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <div class="login-logo"><img src="<?= DIRIMG . 'logotipo-responsivo-ouse-inteligencia-em-marcas-200x37.png' ?>" value="Logotipo Ouse - inteligência em Marcas"></div>
                <p class="login-box-msg">Faça login para iniciar sua sessão</p>
                <form id="formLogin" method="POST" autocomplete="off">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Usuário" name="userLogin" id="userLogin" value="<?= $loginRemember ?>">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Senha" name="passwordLogin" id="passwordLogin" value="<?= $passwordRemember ?>">
                        <div class="input-group-append">
                            <div class="input-group-text" id="divShowPassword">
                                <span class="far fa-eye" onclick="ShowHidePassword()" style="cursor: pointer;" id="showPassword">
                            </div>
                        </div>
                    </div>
                    <div id="divErrors">
                        <?php
                        if ($block === true) {
                            echo 'Tentativas excedidas, tente novamente daqui 20 minutos ou entre em contato com o Administrador do sistema!';
                        } ?>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember" value="rememberYes" <?= $checkedRemember ?>>
                                <label for="remember">Lembre-me</label>
                            </div>
                        </div>
                        <div class="col-4" id="divBtnLogin">
                            <button type="submit" value="Entrar" class="btn btn-primary btn-block" id="btnLogin" <?php if ($block === true) {
                                                                                                                        echo ' disabled';
                                                                                                                    } ?>>Entrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="<?= DIRPLUGINS . 'jquery/jquery.min.js' ?>"></script>
    <script src="<?= DIRPLUGINS . 'bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
    <script src="<?= DIRJS . 'adminlte.min.js' ?>"></script>
    <script src="<?= DIRPLUGINS . 'jquery-validation/jquery.validate.min.js' ?>"></script>
    <script src="<?= DIRPLUGINS . 'jquery-validation/additional-methods.min.js' ?>"></script>
    <script src="<?= DIRJS . 'login/login.js' ?>"></script>
    <script src="<?= DIRPLUGINS . 'toastr/toastr.min.js' ?>"></script>
    <script>
        function ShowHidePassword() {
            var x = document.getElementById("passwordLogin");
            var shwoPassword = document.getElementById("showPassword");
            if (x.type === "password") {
                x.type = "text";
                $('#showPassword').hide();
                $('#divShowPassword').html('<span class="far fa-eye-slash" onclick="ShowHidePassword()" style="cursor: pointer;" id="showPassword">');
            } else {
                x.type = "password";
                $('#showPassword').hide();
                $('#divShowPassword').html('<span class="far fa-eye" onclick="ShowHidePassword()" style="cursor: pointer;" id="showPassword">');
            }
        }
    </script>
</body>

</html>