<?php
require_once '../app/View/login/check-login.php';

include_once '../app/Model/connection-pdo.php';

/* Pessoas */
$querySelectPeople = " SELECT pess_codigo, pess_nome, pess_sobrenome, pess_razao_social, pess_classificacao FROM tb_pessoas ORDER BY pess_codigo DESC";
$searchPeople = $connectionDataBase->prepare($querySelectPeople);
$searchPeople->execute();

/* Formas de pagametno */
$querySelectPaymentMethod = " SELECT tpg_codigo, tpg_descricao, tpg_parcelas FROM tb_tipo_pagamento ";
$searchPaymentMethod = $connectionDataBase->prepare($querySelectPaymentMethod);
$searchPaymentMethod->execute();
$searchPaymentMethod = $searchPaymentMethod->fetchAll(\PDO::FETCH_ASSOC);

/* Formas de pagametno somente 1x */
$querySelectPaymentMethod2 = " SELECT tpg_codigo, tpg_descricao, tpg_parcelas FROM tb_tipo_pagamento WHERE tpg_parcelas = 1 ";
$searchPaymentMethod2 = $connectionDataBase->prepare($querySelectPaymentMethod2);
$searchPaymentMethod2->execute();
$searchPaymentMethod2 = $searchPaymentMethod2->fetchAll(\PDO::FETCH_ASSOC);

/* Categorias */
$querySelectCategory = " SELECT * FROM tb_categoria ";
$searchCategory = $connectionDataBase->prepare($querySelectCategory);
$searchCategory->execute();
$searchCategory = $searchCategory->fetchAll(\PDO::FETCH_ASSOC);
?>
@extends('templates.default')

@section('title', 'Contas a Receber')

@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-bs4/css/dataTables.bootstrap4.min.css' ?>"> <!-- acho que fica  -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-responsive/css/responsive.bootstrap4.min.css' ?>"> <!-- acho que fica  -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'select2/css/select2.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'icheck-bootstrap/icheck-bootstrap.min.css' ?>">
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

    .card-title {
        margin-top: 0.3rem;
    }

    .badge-open {

        background-color: #d9a407 !important;
        color: #fff !important;
    }

    .badge-negotiated {
        background-color: #286E80 !important;
        color: #fff !important;
    }

    .badge-protested {
        background-color: #000 !important;
        color: #fff !important;
    }

    .label-not-bold {
        font-weight: normal !important;
    }
</style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">Financeiro</li>
<li class="breadcrumb-item">Contas a Receber</li>
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
        <form role="form" id="formFiltersAccountsReceivable" autocomplete="off" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Por Período</label>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="filterExpirationDate" name="notDefinedFilters" value="">
                                <label for="filterExpirationDate" class="custom-control-label label-not-bold">Data de Venciemento</label> <!-- abre uma caixa pra ele colocar quantos dias, se nao vai ser 10 dias padrao exemplo -->
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="filterDateIssue" name="notDefinedFilters" value="">
                                <label for="filterDateIssue" class="custom-control-label label-not-bold">Data de Emissão</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="filterPayday" name="notDefinedFilters" value="">
                                <label for="filterPayday" class="custom-control-label label-not-bold">Data de Pagamento</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2" style="display: none;" id="divDateStart">
                        <h5 id="h5DateStartDateAnd" style="font-weight: bold;"></h5>
                        <div class="form-group">
                            <label class="label-not-bold">De:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" name="filterStartDate" id="filterStartDate" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2" style="display: none;" id="divDateEnd">
                        <h5 style="visibility: hidden;">d</h5>
                        <div class="form-group">
                            <label class="label-not-bold">Até:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" name="filterEndDate" id="filterEndDate" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Pré-definidos</label>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="dateExperyNext" name="predefinedFilters" value="">
                                <label for="dateExperyNext" class="custom-control-label label-not-bold">Próximas ao vencimento</label>
                                <a href="#" title="Padrão: 7 dias"> <i class="fas fa-info-circle"></i> </a> <!-- abre uma caixa pra ele colocar quantos dias, se nao vai ser 10 dias padrao exemplo -->
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="overdueAccounts" name="predefinedFilters" value="">
                                <label for="overdueAccounts" class="custom-control-label label-not-bold">Contas vencidas</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Tipo de Pagamento</label>
                            <select class="form-control select2" name="filterAccountPayment" id="filterAccountPayment" style="width: 100%;">
                                <option value="">Todos</option>
                                <?php foreach ($searchPaymentMethod as $row) { ?>
                                    <option value="<?= $row['tpg_codigo'] ?>"> <?= $row['tpg_descricao'] ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="statusFilter" id="statusFilter" onchange="">
                                <option value="">Todos</option>
                                <option value="ABERTO" style="background-color: #ffc107; color: #fff; font-weight: bold;">ABERTO</option>
                                <option value="PAGO" style="background-color: #28a745; color: #fff; font-weight: bold;">PAGO</option>
                                <option value="CANCELADO" style="background-color: #b11800; color: #fff; font-weight: bold;">CANCELADO</option>
                                <option value="NEGOCIADO" style="background-color: #286E80; color: #fff; font-weight: bold;">NEGOCIADO</option>
                                <option value="PROTESTADO" style="background-color: #000; color: #fff; font-weight: bold;">PROTESTADO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Categoria</label>
                            <select class="form-control select2" name="filterCategory" id="filterCategory" style="width: 100%;">
                                <option value="">Todos</option>
                                <?php foreach ($searchCategory as $row) { ?>
                                    <option value="<?php echo $row['cat_codigo'] ?>"> <?= $row['cat_descricao'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Descrição do Relatório</label>
                            <textarea class="form-control" rows="3" name="descriptionReport" id="descriptionReport" style="height: 70px;"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card-footer">
            <button type="reset" class="btn btn-default" id="clearFilters">Limpar Filtros</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Resultado do Filtro &nbsp; <b>Status:</b></h3>
                    <span class="badge badge-warning badge-open" style="margin-left: 0.5rem;">ABERTO</span>
                    <span class="badge badge-success badge-pay" style="margin-left: 0.5rem;">PAGO</span>
                    <span class="badge badge-danger badge-pay" style="margin-left: 0.5rem;">CANCELADO</span>
                    <span class="badge badge-negotiated" style="margin-left: 0.5rem;">NEGOCIADO</span>
                    <span class="badge badge-protested" style="margin-left: 0.5rem;">PROTESTADO</span>
                    <div class="card-tools">
                        <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal" data-target="#modalRegisterAccountsReceivable">Novo</button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- <div id="total_order" style="background-color: #286E80; font-size: large; align-content: center;"></div> -->
                    <table id="listAccountsReceivable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nº Doc.</th>
                                <th>Nº Reg.</th>
                                <th>Pessoa</th>
                                <th>Tipo Pagto.</th>
                                <th>Parcela</th>
                                <th>Valor (R$)</th>
                                <th>Emissão</th>
                                <th>Vencimento</th>
                                <th>Pagamento</th>
                                <th>Categoria</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th>Nº Doc.</th>
                                <th>Nº Reg.</th>
                                <th>Pessoa</th>
                                <th>Tipo Pagto.</th>
                                <th>Parcela</th>
                                <th>Valor (R$)</th>
                                <th>Emissão</th>
                                <th>Vencimento</th>
                                <th>Pagamento</th>
                                <th>Categoria</th>
                                <th>Status</th>
                                <th id="total_order" style="background-color: #286E80; font-size: large; color: #fff;">Ações</th>
                            </tr>
                        </tfoot>
                        <!-- <P id="total_order"></P> -->
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRegisterAccountsReceivable" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formRegisterAccountsReceivable" method="POST" novalidate="novalidate" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Cadastrar Contas a Receber</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nº doc.</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <input type="text" name="numberDocumentRegister" id="numberDocumentRegister" class="form-control" placeholder="Ex.: NF, Boleto, Nº Orçamento"> 
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Pessoa</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <select class="form-control select2" name="peopleRegister" id="peopleRegister" style="width: 100%;">
                                        <option value="">Pessoa</option>
                                        <?php foreach ($searchPeople->fetchAll(\PDO::FETCH_ASSOC) as $row) { ?>
                                            <option value="<?php echo $row['pess_codigo'] ?>">
                                                <?= $row['pess_nome'] . " " . $row['pess_sobrenome'] . $row['pess_razao_social'] . " - " . $row['pess_classificacao'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tipo de Pagamento</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <select class="form-control select2" name="paymentMethodRegister" id="paymentMethodRegister" style="width: 100%;" onchange="showSettledRegister();">
                                        <option value="">Tipo de Pagamento</option>
                                        <?php foreach ($searchPaymentMethod as $row) { ?>
                                            <option data-valor="<?php echo $row['tpg_parcelas']; ?>" value="<?php echo $row['tpg_codigo'] ?>">
                                                <?php echo $row['tpg_descricao'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Parcela(s)</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <input type="text" name="installmentRegister" id="installmentRegister" class="form-control" onblur="showSettledRegister();" readonly>
                                </div>
                            </div>
                            <div id="divApartmentEdit" class="col-sm-6">
                                <div class="form-group">
                                    <label>Valor Total</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <input type="text" name="amountRegister" id="amountRegister" class="form-control" autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Emissão</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" name="dateIssueRegister" id="dateIssueRegister" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="{{date('Y-m-d')}}" min="{{date('Y-m-d')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Vencimento</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" name="dateExpiryRegister" id="dateExpiryRegister" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="" min="{{date('Y-m-d')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Status</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <select class="form-control" name="statusRegister" id="statusRegister" onchange="">
                                        <option value="ABERTO" style="background-color: #ffc107; color: #fff; font-weight: bold;">ABERTO</option>
                                        <option value="PAGO" style="background-color: #28a745; color: #fff; font-weight: bold;">PAGO</option>
                                        <option value="CANCELADO" style="background-color: #b11800; color: #fff; font-weight: bold;">CANCELADO</option>
                                        <option value="NEGOCIADO" style="background-color: #286E80; color: #fff; font-weight: bold;">NEGOCIADO</option>
                                        <option value="PROTESTADO" style="background-color: #000; color: #fff; font-weight: bold;">PROTESTADO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Categoria</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <select class="form-control select2" name="categoryRegister" id="categoryRegister" style="width: 100%;">
                                        <option value="">Categoria</option>
                                        <?php foreach ($searchCategory as $row) { ?>
                                            <option value="<?php echo $row['cat_codigo'] ?>">
                                                <?= $row['cat_descricao'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6" id="divSettledRegister" style="display: none;">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="settledRegister" name="settledRegister" value="settledRegisterYes" onchange="showDivPayday('settledRegister', 'divPaydayRegister', 'statusRegister');">
                                    <label for="settledRegister">Pago?</label>
                                </div>
                            </div>
                            <div class="col-sm-6" id="divPaydayRegister" style="display: none;">
                                <div class="form-group">
                                    <label>Pagamento</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" id="payDayRegister" name="payDayRegister" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="{{date('Y-m-d')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Observações</label>
                                    <textarea class="form-control" rows="3" name="observationRegister" id="observationRegister" style="height: 60px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-register-people" id="btnRegisterPeople">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalUpDateAccountReceivable" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formUpDateAccountReceivable" method="POST" novalidate="novalidate" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Parcela</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="idUpDate" id="idUpDate" class="form-control">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nº doc.</label>
                                    <input type="text" name="numberDocumentUpDate" id="numberDocumentUpDate" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Pessoa</label>
                                    <input type="text" name="peopleUpDate" id="peopleUpDate" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tipo de Pagamento</label>
                                    <select class="form-control select2" name="paymentMethodUpDate" id="paymentMethodUpDate" style="width: 100%;">
                                        <option value="">Tipo de Pagamento</option>
                                        <?php foreach ($searchPaymentMethod as $row) { ?>
                                            <option value="<?= $row['tpg_codigo']?>"><?= $row['tpg_descricao'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Parcela</label> <a href="#" title="Número referente a parcela a ser editada!"> <i class="fas fa-info-circle"></i> </a>
                                    <input type="text" name="installmentUpDate" id="installmentUpDate" class="form-control" onblur="showSettledRegister();" readonly>
                                </div>
                            </div>
                            <div id="divApartmentEdit" class="col-sm-6">
                                <div class="form-group">
                                    <label>Valor</label>
                                    <input type="text" name="valueInstallmentUpDate" id="valueInstallmentUpDate" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Emissão</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="dateIssueUpDate" id="dateIssueUpDate" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Vencimento</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" name="dateExpiryUpDate" id="dateExpiryUpDate" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="statusUpDate" id="statusUpDate">
                                        <option value="ABERTO" style="background-color: #ffc107; color: #fff; font-weight: bold;">ABERTO</option>
                                        <option value="PAGO" style="background-color: #28a745; color: #fff; font-weight: bold;">PAGO</option>
                                        <option value="CANCELADO" style="background-color: #b11800; color: #fff; font-weight: bold;">CANCELADO</option>
                                        <option value="NEGOCIADO" style="background-color: #286E80; color: #fff; font-weight: bold;">NEGOCIADO</option>
                                        <option value="PROTESTADO" style="background-color: #000; color: #fff; font-weight: bold;">PROTESTADO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Categoria</label>
                                    <select class="form-control select2" name="categoryUpDate" id="categoryUpDate" style="width: 100%;">
                                        <option value="">Categoria</option>
                                        <?php foreach ($searchCategory as $row) { ?>
                                            <option value="<?php echo $row['cat_codigo'] ?>">
                                                <?= $row['cat_descricao'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6" id="divSettledUpDate">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="settledUpDate" name="settledUpDate" value="settledUpDateYes" onchange="showDivPayday('settledUpDate', 'divPaydayUpDate', 'statusUpDate');">
                                    <label for="settledUpDate">Pago?</label>
                                </div>
                            </div>
                            <div class="col-sm-6" id="divPaydayUpDate" style="display: none;">
                                <div class="form-group">
                                    <label>Pagamento</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" class="form-control" id="payDayUpDate" name="payDayUpDate" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="{{date('Y-m-d')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Observações</label>
                                    <textarea class="form-control" rows="3" name="observationUpDate" id="observationUpDate" style="height: 60px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-settled-accounts" id="btnSettledAccounts">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalViewAccountReceivable" data-toggle="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detalhes da Parcela</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <dl class="row">

                        <dt class="col-sm-3">Nº do Doc.:</dt>
                        <dd class="col-sm-8" id="idBudgetView"></dd>

                        <dt class="col-sm-3">Nº do Registro:</dt>
                        <dd class="col-sm-8" id="idView"></dd>

                        <dt class="col-sm-3">Pessoa:</dt>
                        <dd class="col-sm-8" id="peopleView"></dd>

                        <dt class="col-sm-3">Tipo Pagto.:</dt>
                        <dd class="col-sm-8" id="paymentMethodView"></dd>

                        <dt class="col-sm-3">Parcela:</dt>
                        <dd class="col-sm-8" id="installmentView"></dd>

                        <dt class="col-sm-3">Valor (R$):</dt>
                        <dd class="col-sm-8" id="valueInstallmentView"></dd>

                        <dt class="col-sm-3">Emissão:</dt>
                        <dd class="col-sm-8" id="dateIssueView"></dd>

                        <dt class="col-sm-3">Vencimento:</dt>
                        <dd class="col-sm-8" id="dateExpiryView"></dd>

                        <dt class="col-sm-3" id="dtPayDayView" style="display: none;">Data Pagto.:</dt>
                        <dd class="col-sm-8" id="payDayView" style="display: none;"></dd>

                        <dt class="col-sm-3">Status:</dt>
                        <div class="col-sm-8" id="statusView"> </div>

                        <dt class="col-sm-3">Categoria:</dt>
                        <dd class="col-sm-8" id="categoryView"></dd>

                        <dt class="col-sm-3" id="dtObservationView"> Observação: </dt>
                        <div class="col-sm-9" id="divObservationView"> <textarea class="form-control" id="observationView" rows="2" style="width: 100%;"> </textarea></div>
                    </dl>
                </div>
                <div class="modal-footer" id="footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#paymentMethodRegister').change(function() {
            $('#installmentRegister').val(($(this).find(':selected').data('valor')));
        });
    });

    //$("#listAccountsReceivable_wrapper").append('<span class="badge badge-success">Shipped</span>');
</script>

<!-- DataTables -->
<script src="<?= DIRPLUGINS . 'datatables/jquery.dataTables.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-bs4/js/dataTables.bootstrap4.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-responsive/js/dataTables.responsive.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-responsive/js/responsive.bootstrap4.min.js' ?>"></script>

<script src="<?= DIRJS . 'finance/accounts-receivable/accounts-receivable.min.js' ?>"></script>
<script src="<?= DIRJS . 'finance/accounts-receivable/register-accounts-receivable.min.js' ?>"></script>
<script src="<?= DIRJS . 'finance/accounts-receivable/edit-accounts-receivable.min.js' ?>"></script>
<!-- <script src="<?= DIRJS . 'finance/accounts-receivable/-accounts-receivable.min.js' ?>"></script> -->
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'select2/js/select2.full.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'select2/js/i18n/pt-BR.js' ?>"></script>

<script>
    $(function() {
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        });
        $('[data-mask]').inputmask();
    });

    $(".select2").select2({
        language: "pt-BR"
    });
</script>
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