<?php
require_once '../app/View/login/check-login.php';

if ($_SESSION["permition"] === "admin") {
} else {
    echo " <script> alert('Você nao tem permissão para acessar essa página, contate o Administrador do sistema!'); window.location.href='/home'; </script> ";
}
?>
@extends('templates.default')

@section('title', 'Usuários')

@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-bs4/css/dataTables.bootstrap4.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-responsive/css/responsive.bootstrap4.min.css' ?>">

<link rel="stylesheet" href="<?= DIRPLUGINS . 'toastr/toastr.min.css' ?>">
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
                            <label>Periodo:</label>
                            <select name="event" class="form-control" id="period">
                                <option value="">Todos</option>
                                <option value="today">Hoje</option>
                                <option value="afterToday">Depois de Hoje</option>
                                <option value="beforeToday">Antes de Hoje</option>
                            </select>
                        </div>
                    </div>

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
                            <select name="status" class="form-control" id="status">
                                <option value="">Todos</option>
                                <option style="background-color:#FFC107; color: #fff;" value="P">Pendente</option>
                                <option style="background-color:#28A745; color: #fff;" value="R">Realizado</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Evento:</label>
                            <select name="event" class="form-control" id="event">
                                <option value="">Todos</option>
                                <option value="Realizar Orçamento">Realizar Orçamento</option>
                                <option value="Voltar na Obra">Voltar na Obra</option>
                                <option value="Início de Obra">Início de Obra</option>
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
                        <button type="button" class="btn btn-block btn-success btn-sm btn-new-user">Novo</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="listUsers" class="table table-hover">
                        <!--table table-bordered table-striped dataTable dtr-inline-->
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Login</th>
                                <th>Data de Cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>Login</th>
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
    <div class="modal fade" id="modalRegisterUser">
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
                                    <label>Nome:</label>
                                    <input type="text" autofocus name="nameUserRegister" id="nameUserRegister" class="form-control" placeholder="Entre com o Nome">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Sobrenome:</label>
                                    <input type="text" name="surnameUserRegister" id="surnameUserRegister" class="form-control" placeholder="Entre com o Sobrenome">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Login:</label>
                                    <input type="text" autofocus name="loginUserRegister" id="loginUserRegister" class="form-control" placeholder="Entre com o Login" onblur="findLogin();">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Senha:</label>
                                    <div class="input-group">
                                        <input type="password" name="passwordUserRegister" id="passwordUserRegister" class="form-control" placeholder="Entre com a Senha">
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
                                    <label>Confirmar Senha:</label>
                                    <div class="input-group">
                                        <input type="password" name="confirmationPasswordRegister" id="confirmationPasswordRegister" class="form-control" placeholder="Confirmação da Senha">
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
                                    <label>Permissões:</label>
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
                                    <label>Nome:</label>
                                    <input type="text" autofocus name="nameUserEdit" id="nameUserEdit" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Sobrenome:</label>
                                    <input type="text" name="surnameUserEdit" id="surnameUserEdit" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Login:</label>
                                    <input type="text" name="loginUserEdit" id="loginUserEdit" class="form-control" disabled style="cursor: no-drop;">
                                </div>
                            </div>

                            <div class="col-sm-6" id="divPasswordUserEdit">
                                <div class="form-group">
                                    <label>Senha:</label>
                                    <div class="input-group">
                                        <input type="password" name="passwordUserEdit" id="passwordUserEdit" class="form-control">
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
                                    <label>Confirmar Senha:</label>
                                    <div class="input-group">
                                        <input type="password" name="confirmationPasswordEdit" id="confirmationPasswordEdit" class="form-control">
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
                                    <label>Permissões:</label>
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

<script src="<?= DIRJS . 'users/users.js' ?>"></script>

<!-- Vaidação -->
<script src="<?= DIRJS . 'users/register-user-validation.js' ?>"></script>
<script src="<?= DIRJS . 'users/edit-user-validation.js' ?>"></script>

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