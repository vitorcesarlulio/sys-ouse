<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Ouse Inteligência em Marcas">
    <title>Sys Ouse | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= DIRPLUGINS . 'fontawesome-free/css/all.min.css' ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= DIRPLUGINS . 'icheck-bootstrap/icheck-bootstrap.min.css' ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= DIRCSS . 'adminlte.min.css' ?>">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo"><b>Admin</b>LTE</div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Faça login para iniciar sua sessão</p>

                <form id="formLogin" method="post">

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Usuário" name="userLogin" id="userLogin">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Senha" name="passwordLogin" id="passwordLogin">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">Remember Me</label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" value="Entrar" class="btn btn-primary btn-block">Entrar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>


                <p class="mb-1">
                    <a href="forgot-password.html">Esqueci a minha senha</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- PADRÃO jQuery -->
    <script src="<?= DIRPLUGINS . 'jquery/jquery.min.js' ?>"></script>
    <!-- Bootstrap 4 (nao sei o que é) -->
    <script src="<?= DIRPLUGINS . 'bootstrap/js/bootstrap.bundle.min.js' ?>"></script>
    <!-- AdminLTE App (nao sei o que é)-->
    <script src="<?= DIRJS . 'adminlte.min.js' ?>"></script>
    <!-- JQuery validation -->
    <script src="<?= DIRPLUGINS . 'jquery-validation/jquery.validate.min.js' ?>"></script>
    <script src="<?= DIRPLUGINS . 'jquery-validation/additional-methods.min.js' ?>"></script>
    <script src="<?= DIRJS . 'login/login.js' ?>"></script>

</body>

</html>