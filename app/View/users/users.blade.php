<?php
require_once '../app/View/login/check-login.php'; 

if ($_SESSION["permition"] === "admin") {
} else {
    echo " <script> alert('Você não tem permissão para acessar essa página, contate o Administrador do sistema!'); window.location.href='/home'; </script> ";
}

include_once '../app/Model/connection-pdo.php';

$querySelectUser = " SELECT usu_codigo, usu_login, usu_nome, usu_sobrenome FROM tb_usuarios ";
$searchUser = $connectionDataBase->prepare($querySelectUser);
$searchUser->execute();

?>
@extends('templates.default')

@section('title', 'Usuários')

@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-bs4/css/dataTables.bootstrap4.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-responsive/css/responsive.bootstrap4.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'select2/css/select2.min.css' ?>">
@endsection

@section('css')
<style>
    .dataTables_length {
        display: none;
    }

    .dt-buttons {
        margin-bottom: 10px;
    }

    .dt-buttons.btn-group {
        float: left;
        margin-right: 2%;
    }
</style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">Usuários</li>
@endsection

@section('content')

<div class="container-fluid">
    <div class="card card-primary collapsed-card">
        <div class="card-header">
            <h3 class="card-title">Filtros</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <form role="form" id="formFiltersUsers" autocomplete="off" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Data de:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" name="startDate" id="startDate">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Até:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" name="endDate" id="endDate">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Status:</label>
                            <select class="form-control" name="statusUser" id="statusUser">
                                <option value="">Todos</option>
                                <option value="A">Ativo</option>
                                <option value="I">Inativo</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Nível de Acesso:</label>
                            <select class="form-control" name="accessLevel" id="accessLevel">
                                <option value="">Todos</option>
                                <option value="user">Usuário</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Login:</label>
                            <select class="form-control select2" name="filterLogin" id="filterLogin" style="width: 100%;">
                                <option value="">Todos</option>
                                <?php foreach ($searchUser->fetchAll(\PDO::FETCH_ASSOC) as $row) { ?>
                                    <option value="<?php echo $row['usu_codigo'] ?>">
                                        <?php echo $row['usu_login'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Descrição do Relatório</label>
                            <input type="text" name="descriptionReport" id="descriptionReport" class="form-control">
                        </div>
                    </div>

                </div>
            </div>
        </form>
        <div class="card-footer">
            <button type="reset" class="btn btn-default" value="Reset"><i class="fas fa-times"></i></button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Resultado do Filtro</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal" data-target="#modalRegisterUser">Novo</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="listUsers" class="table table-hover">
                        <!--table table-bordered table-striped dataTable dtr-inline ou  table table-striped-->
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Login</th>
                                <th>Permissão</th>
                                <th>Status</th>
                                <th>Data de Cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Login</th>
                                <th>Permissão</th>
                                <th>Status</th>
                                <th>Data de Cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Cadastrar Usuario -->
    <div class="modal fade" id="modalRegisterUser" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formRegisterUser" method="POST" autocomplete="off" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Cadastrar Usuário</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nome:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <input type="text" name="nameUserRegister" id="nameUserRegister" class="form-control" placeholder="Entre com o Nome" autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Sobrenome:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <input type="text" name="surnameUserRegister" id="surnameUserRegister" class="form-control" placeholder="Entre com o Sobrenome">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Login:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <input type="text" autofocus name="loginUserRegister" id="loginUserRegister" class="form-control" placeholder="Entre com o Login" onblur="findLogin();">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Senha:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <div class="input-group">
                                        <input type="password" name="passwordUserRegister" id="passwordUserRegister" class="form-control" placeholder="Entre com a Senha" autocomplete="new-password">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" onclick="showPassword()" style="cursor: pointer;">
                                                <i class="far fa-eye" id="iconPasswordRegister"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Confirmar Senha:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <div class="input-group">
                                        <input type="password" name="confirmationPasswordRegister" id="confirmationPasswordRegister" class="form-control" placeholder="Confirmação da Senha" autocomplete="new-password">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" onclick="showPasswordConfirm()" style="cursor: pointer;">
                                                <i class="far fa-eye" id="iconPasswordRegisterConfirm"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--<div class="col-sm-6">
                                <div class="form-group">
                                    <label>Permissões:</label>
                                    <select name="permitionUserRegister" class="form-control" id="permitionUserRegister">
                                        <option value="user">Usuário</option>
                                        <option value="admin">Administrador</option>
                                    </select>
                                </div>
                            </div> -->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Permissões:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary active focus" id="divPermitionUserRegister">
                                            <input type="radio" name="permitionUserRegister" id="permitionUserRegister" checked value="user"> Usuário
                                        </label>
                                        <label class="btn btn-secondary" id="divPermitionAdminRegister">
                                            <input type="radio" name="permitionAdminRegister" id="permitionAdminRegister" value="admin"> Administrador
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Status:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary active focus" id="divStatusActiveUserRegister">
                                            <input type="radio" name="statusActiveUserRegister" id="statusActiveUserRegister" checked value="A"> Ativo
                                        </label>
                                        <label class="btn btn-secondary" id="divStatusInactiveUserRegister">
                                            <input type="radio" name="statusInactiveRegister" id="statusInactiveRegister" value="I"> Inativo
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-register-user">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Editar Usuario -->
    <div class="modal fade" id="modalEditUser">
        <div class="modal-dialog">
            <form id="formEditUser" autocomplete="off" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Usuário</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <input type="hidden" name="idUserEdit" id="idUserEdit" class="form-control">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nome:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <input type="text" autofocus name="nameUserEdit" id="nameUserEdit" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Sobrenome:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <input type="text" name="surnameUserEdit" id="surnameUserEdit" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Login:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <input type="text" name="loginUserEdit" id="loginUserEdit" class="form-control" disabled style="cursor: no-drop;">
                                </div>
                            </div>

                            <div class="col-sm-6" id="divPasswordUserEdit">
                                <div class="form-group">
                                    <label>Senha:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <div class="input-group">
                                        <input type="password" name="passwordUserEdit" id="passwordUserEdit" class="form-control" autocomplete="new-password">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" onclick="showPasswordEdit()" style="cursor: pointer;">
                                                <i class="far fa-eye" id="iconPasswordEdit"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" id="divConfirmationPasswordEdit">
                                <div class="form-group">
                                    <label>Confirmar Senha:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <div class="input-group">
                                        <input type="password" name="confirmationPasswordEdit" id="confirmationPasswordEdit" class="form-control" autocomplete="new-password">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" onclick="showPasswordConfirmEdit()" style="cursor: pointer;">
                                                <i class="far fa-eye" id="iconPasswordEditConfirm"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--<div class="col-sm-6">
                                <div class="form-group">
                                    <label>Permissões:</label>
                                    <select name="permitionUserEdit" class="form-control" id="permitionUserEdit">
                                        <option value="user">Usuário</option>
                                        <option value="admin">Administrador</option>
                                    </select>
                                </div>
                            </div> -->

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Permissões:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary" id="labelUserPermition">
                                            <input type="radio" name="permitionUserEdit" id="permitionUserEdit" value="user"> Usuário
                                        </label>
                                        <label class="btn btn-secondary" id="labelAdminPermition">
                                            <input type="radio" name="permitionAdminEdit" id="permitionAdminEdit" value="admin"> Administrador
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Status:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary" id="labelUserStatusActive">
                                            <input type="radio" name="statusActiveUserEdit" id="statusActiveUserEdit" value="A"> Ativo
                                        </label>
                                        <label class="btn btn-secondary" id="labelUserStatusInactive">
                                            <input type="radio" name="statusInactiveUserEdit" id="statusInactiveUserEdit" value="I"> Inativo
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('script')
<!-- DataTables -->
<script src="<?= DIRPLUGINS . 'datatables/jquery.dataTables.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-bs4/js/dataTables.bootstrap4.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-responsive/js/dataTables.responsive.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-responsive/js/responsive.bootstrap4.min.js' ?>"></script>

<script src="<?= DIRJS . 'users/users.min.js' ?>"></script>
<!-- Select2 -->
<script src="<?= DIRPLUGINS . 'select2/js/select2.full.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'select2/js/i18n/pt-BR.js' ?>"></script>
<script>
    //Initialize Select2 Elements
    $(".select2").select2({
        language: "pt-BR"
    });
</script>
<!-- Vaidação -->
<script src="<?= DIRJS . 'users/register-user-validation.min.js' ?>"></script>
<script src="<?= DIRJS . 'users/edit-user-validation.min.js' ?>"></script>

<!-- InputMask (MASCARAS) -->
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/b-1.6.2/b-colvis-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/cr-1.5.2/fh-3.1.7/kt-2.5.2/datatables.min.css" />

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/b-1.6.2/b-colvis-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/cr-1.5.2/fh-3.1.7/kt-2.5.2/datatables.min.js"></script>

<!-- Botões Data table -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

@endsection