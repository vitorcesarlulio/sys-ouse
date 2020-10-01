<?php
//header("Content-Type: text/html; charset=utf-8");
require_once '../app/View/login/check-login.php'; 
# Sortear Imagem
$image = array();
$image[1] = DIRIMG . "/images-user-128x128/image-user-1.png";
$image[2] = DIRIMG . "/images-user-128x128/image-user-2.png";
$image[3] = DIRIMG . "/images-user-128x128/image-user-3.png";
$image[4] = DIRIMG . "/images-user-128x128/image-user-4.png";
$image[5] = DIRIMG . "/images-user-128x128/image-user-5.png";
$image[6] = DIRIMG . "/images-user-128x128/image-user-6.png";
$image[7] = DIRIMG . "/images-user-128x128/image-user-7.png";
$image[8] = DIRIMG . "/images-user-128x128/image-user-8.png";
$count = count($image);
$imageRandom = rand(1, $count);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="author" content="Ouse Inteligência em Marcas">
  <title>Sys Ouse | @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= DIRPLUGINS . 'fontawesome-free/css/all.min.css' ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  @yield('head')
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= DIRCSS . 'adminlte.min.css' ?>">
    <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= DIRPLUGINS . 'overlayScrollbars/css/OverlayScrollbars.min.css' ?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- pace-progress -->
  <link rel="stylesheet" href="<?= DIRPLUGINS . 'pace-progress/themes/black/pace-theme-flat-top.css' ?>">
  <link rel="stylesheet" href="<?= DIRPLUGINS . 'toastr/toastr.min.css' ?>">
  @yield('css')
  <style>
        .brand-link .brand-image{
          margin-top: 3px !important;
        }
        .brand-text{
          margin-left: 2px !important;
        }
        .elevation-2{
          box-shadow: none !important; 
        }
        .main-header{
          border-bottom:none;
        }
        [class*=sidebar-dark] .brand-link{
          border-bottom:none;
        }
        [class*=sidebar-dark-] .sidebar a{
          color: #fff;
        }
  </style>
</head>

<body class="hold-transition pace-primary pace-done sidebar-mini sidebar-collapse">
  <!--layout-navbar-fixed-->
  <div class="pace pace-inactive">
    <div class="pace-progress" data-progress-text="100%" data-progress="99" style="transform: translate3d(100%, 0px, 0px);">
      <div class="pace-progress-inner"></div>
    </div>
    <div class="pace-activity"></div>
  </div>
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>
        <li class="nav-item dropdown user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <img src="<?= $image[$imageRandom]; ?>" class="user-image img-circle elevation-2" alt="User Image">
            <span class="d-none d-md-inline"> <?= $_SESSION['name']; ?> </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
            <!-- User image -->
            <li class="user-header bg-primary">
              <img src="<?= $image[$imageRandom]; ?>" class="img-circle elevation-2" alt="User Image">
              <p> 
                <?= $_SESSION['name']; ?> 
                <small> <b>Nível de acesso:</b> <?php if($_SESSION['permition'] === 'admin'){echo 'Administrador';}else{ echo 'Usuário';} ?> </small>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <!--<a href="#" class="btn btn-default btn-flat">Conta</a>-->
              <a href="/logout" class="btn btn-default btn-flat float-right">Sair</a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/home" class="brand-link">
        <img src=<?= DIRIMG . 'pictograma-ouse-inteligencia-em-marcas-35x28.png' ?> alt="Ouse - Inteligência em Marcas - Pictograma" class="brand-image">
        
        <span class="brand-text font-weight-light"><img src=<?= DIRIMG . 'logotipo-responsivo-ouse-inteligencia-em-marcas-35x8.png' ?> alt="Ouse - Inteligência em Marcas - Logotipo"></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p> Agenda <i class="right fas fa-angle-left"></i> </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/agenda/calendario" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Calendário</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/agenda/eventos" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Eventos</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-money-check"></i>
                <p> Orçamentos <i class="right fas fa-angle-left"></i> </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/orcamentos" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Orçamentos</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="/pessoas" class="nav-link">
                <i class="nav-icon fas fa-user-circle"></i> <p> Pessoas </p> 
              </a> 
            </li>

            <?php
            if ($_SESSION["permition"] === "admin") {
              echo '<li class="nav-item has-treeview"> <a href="/usuarios" class="nav-link"> <i class="nav-icon fas fa-users"></i> <p> Usuários </p> </a> </li>';
            } else {
              
            }
            ?>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>@yield('title')</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                @yield('breadcrumb')
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        @yield('content')
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal de confirmação Global -->
    <div class="modal fade" id="modalConfirm" data-toggle="modal" data-target="targetModalConfirm">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="titulo"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p id="texto"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger" id="btnConfirm">Sim</button>
          </div>
        </div>
      </div>
    </div>

    <footer class="main-footer">
      <strong>Copyright &copy; {{date('Y')}} <a href="https://ouse.com.br" target="_blank">Ouse</a>.</strong>
      Todos os direitos reservados.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>
  </div>

  <!-- Scripts, JavaScript (efeitos, validaçoes), jQuery -->
  <!-- PADRÃO jQuery -->
  <script src="<?= DIRPLUGINS . 'jquery/jquery.min.js' ?>"></script>

  <!-- Bootstrap 4 (nao sei o que é) -->
  <script src="<?= DIRPLUGINS . 'bootstrap/js/bootstrap.bundle.min.js' ?>"></script>

  <!-- jQuery UI -->
  <script src="<?= DIRPLUGINS . 'jquery-ui/jquery-ui.min.js' ?>"></script>

  <!-- AdminLTE App (nao sei o que é)-->
  <script src="<?= DIRJS . 'adminlte.min.js' ?>"></script>

  <!-- overlayScrollbars -->
  <script src="<?= DIRPLUGINS . 'overlayScrollbars/js/jquery.overlayScrollbars.min.js' ?>"></script>

  <!-- AdminLTE for demo purposes (nao sei o que é) -->
  <script src="<?= DIRJS . 'demo.js' ?>"></script>

  <!-- JQuery validation -->
  <script src="<?= DIRPLUGINS . 'jquery-validation/jquery.validate.min.js' ?>"></script>
  <script src="<?= DIRPLUGINS . 'jquery-validation/additional-methods.min.js' ?>"></script>

  <!-- Alerta de cadastro - Toastr Examples -->
  <script src="<?= DIRPLUGINS . 'toastr/toastr.min.js' ?>"></script>
  <!-- Modal de confirmação -->
<script src="<?= DIRJS . 'global-functions/confirm-action.js' ?>"></script>
  @yield('script')

  <script>
    /* $(document).ready(function() {
      $(document).keypress(function(e) {
        if (e.wich == 67 || e.keyCode == 67) {
          //window.location.replace("/agenda/calendario");
          window.location.href = "/agenda/calendario";
        }
        if (e.wich == 69 || e.keyCode == 69) {
          window.location.href = "/agenda/eventos";
        }
      });
    });
    */

  </script>
  <!-- PADRÃO pace-progress (ao carregar a pagina faz o efeito na barra de favoritos)-->
  <script src="<?= DIRPLUGINS . 'pace-progress/pace.min.js' ?>"></script>

</body>

</html>