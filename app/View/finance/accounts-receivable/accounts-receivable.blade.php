<?php
require_once '../app/View/login/check-login.php';

include_once '../app/Model/connection-pdo.php';

$querySelectPeople = " SELECT pess_codigo, pess_nome, pess_sobrenome, pess_razao_social, pess_classificacao FROM tb_pessoas ORDER BY pess_codigo DESC";
$searchPeople = $connectionDataBase->prepare($querySelectPeople);
$searchPeople->execute();

$querySelectPaymentMethod = " SELECT tpg_codigo, tpg_descricao, tpg_parcelas FROM tb_tipo_pagamento ";
$searchPaymentMethod = $connectionDataBase->prepare($querySelectPaymentMethod);
$searchPaymentMethod->execute();
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
                        <h5><b>Data de vencimento</b></h5>
                        <div class="form-group">
                            <label>De:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" name="startDateExpiry" id="startDateExpiry" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                   <h5 style="visibility: hidden;">d</h5>
                        <div class="form-group">
                            <label>Até:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" name="endDateExpiry" id="endDateExpiry" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <h5><b>Data de emissão</b></h5>
                        <div class="form-group">
                            <label>De:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" name="startDateIssue" id="startDateIssue" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                   <h5 style="visibility: hidden;">d</h5>
                        <div class="form-group">
                            <label>Até:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control" name="endDateIssue" id="endDateIssue" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false" value="">
                            </div>
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
                    <h3 class="card-title">Resultado do Filtro &nbsp; <b>Status:</b></h3>
                    <span class="badge badge-danger" style="margin-left: 0.5rem">ABERTO</span>
                    <span class="badge badge-success" style="margin-left: 0.5rem">PAGO</span>
                    <span class="badge badge-success" style="margin-left: 0.5rem; background-color: #FE5000; color: #fff">CANCELADO</span>
                    <span class="badge badge-success" style="margin-left: 0.5rem; background-color: #286E80; color: #fff">NEGOCIADO</span>
                    <span class="badge badge-success" style="margin-left: 0.5rem; background-color: #000; color: #fff">PROTESTADO</span>
                    <div class="card-tools">
                        <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal" data-target="#modalRegisterAccountsReceivable">Novo</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="listAccountsReceivable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nº</th>
                                <th>Pessoa</th>
                                <th>Tipo Pagto.</th>
                                <th>Parcela</th>
                                <th>Valor (R$)</th>
                                <th>Emissão</th>
                                <th>Vencimento</th>
                                <th>Status</th>
                                <th>Classificação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th>Nº</th>
                                <th>Pessoa</th>
                                <th>Tipo Pagto.</th>
                                <th>Parcela</th>
                                <th>Valor (R$)</th>
                                <th>Emissão</th>
                                <th>Vencimento</th>
                                <th>Status</th>
                                <th>Classificação</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                        <P id="total_order"></P>
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
                                    <input type="text" name="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Pessoa:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <select class="form-control select2" name="peopleRegister" id="peopleRegister" style="width: 100%;">
                                        <option value="">Escolha...</option>
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
                                        <option value="">Escolha...</option>
                                        <?php foreach ($searchPaymentMethod->fetchAll(\PDO::FETCH_ASSOC) as $row) { ?>
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
                                    <input type="text" name="installmentRegister" id="installmentRegister" class="form-control" onblur="showSettledRegister();">
                                </div>
                            </div>
                            <div id="divApartmentEdit" class="col-sm-6">
                                <div class="form-group">
                                    <label>Valor Total:</label> <label style="color: red; font-size: 12px;"> * </label>
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
                                    <label>Status:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <select class="form-control" name="statusRegister" id="statusRegister" onchange="">
                                        <option value="Aberto" style="background-color: #b11800; color: #fff; font-weight: bold;">Aberto</option>
                                        <option value="Pago" style="background-color: #28a745; color: #fff; font-weight: bold;">Pago</option>
                                        <option value="Cancelado" style="background-color: #FE5000; color: #fff; font-weight: bold;">Cancelado</option>
                                        <option value="Negociado" style="background-color: #286E80; color: #fff; font-weight: bold;">Negociado</option>
                                        <option value="Protestado" style="background-color: #000; color: #fff; font-weight: bold;">Protestado</option>
                                        <!-- <option value="Outro">Outro</option> -->
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-sm-6" id="divOtherStatus" style="display: none;">
                                <div class="form-group">
                                    <label>Outro Status</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <input type="text" name="otherStatusRegister" id="otherStatusRegister" class="form-control">
                                </div>
                            </div> -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Classificação:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <select class="form-control" name="classificationRegister" id="classificationRegister" onchange="">
                                        <option value="">Dinheiro</option>
                                        <option value="">Boleto</option>
                                        <option value="">Crédito em conta</option>
                                        <option value="">Cartão</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Categoria:</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <select class="form-control" name="classificationRegister" id="classificationRegister" onchange="">
                                        <option value="">Produtos</option>
                                        <option value="">Serviços</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6" id="divSettledRegister" style="display: none;">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="settledRegister" name="settledRegister" value="settledRegisterYes" onchange="showDivPayday();">
                                    <label for="settledRegister">Quitado</label>
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

    <div class="modal fade" id="modalSettledAccounts" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formSettledAccounts" method="POST" novalidate="novalidate" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Quitar</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Cliente disabled</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>n titulo disabled</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Data pagto</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Data baixa</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Juros n sei</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Desconto</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Satus ou situaçao</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-settled-accounts" id="btnSettledAccounts">quitar</button>
                    </div>
                </div>
            </form>
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

<script src="<?= DIRPLUGINS . 'datatables/jquery.dataTables.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-bs4/js/dataTables.bootstrap4.min.js' ?>"></script>
<!-- <script src="<?= DIRPLUGINS . 'datatables-responsive/js/responsive.bootstrap4.min.js' ?>"></script> sai  -->
<script src="<?= DIRPLUGINS . 'datatables-responsive/js/dataTables.responsive.min.js' ?>"></script>

<script src="<?= DIRJS . 'finance/accounts-receivable/accounts-receivable.js' ?>"></script>
<script src="<?= DIRJS . 'finance/accounts-receivable/register-accounts-receivable.js' ?>"></script>
<!-- <script src="<?= DIRJS . 'finance/accounts-receivable/edit-accounts-receivable.js' ?>"></script>
<script src="<?= DIRJS . 'finance/accounts-receivable/-accounts-receivable.js' ?>"></script> -->
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
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/b-1.6.2/b-colvis-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/cr-1.5.2/fh-3.1.7/kt-2.5.2/datatables.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script> <!-- so muda versao  -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<!--<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>  sai  -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> <!-- sai  testar p ver se n caga pdf excel -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> <!-- sai, ver qual versao testar p ver se n caga pdf excel  -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> <!-- sai, testar p ver se n caga pdf excel   -->

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script> <!-- testar p ver se n caga pdf excel  -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script> <!-- testar p ver se n caga pdf excel  -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script> <!-- se tirar o btn fica com uma setinha -->



@endsection