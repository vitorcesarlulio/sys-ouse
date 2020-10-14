<?php
require_once '../app/View/login/check-login.php';
if ($_SESSION["permition"] === "admin") {
} else {
    echo " <script> alert('Você não tem permissão para acessar essa página, contate o Administrador do sistema!'); window.location.href='/home'; </script> ";
}

$querySelectPeople = " SELECT orca_nome, count(q.orca_numero) / t.total * 100 as perc, count(*) as Qtde from tb_orcamento q,
(SELECT count(*) as total from tb_orcamento) t
GROUP BY q.orca_nome ORDER BY Qtde DESC ";
$searchPeople = $connectionDataBase->prepare($querySelectPeople);
$searchPeople->execute();
?>
@extends('templates.default')

@section('title', 'Formas de Pagamento')

@section('head')
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-bs4/css/dataTables.bootstrap4.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-responsive/css/responsive.bootstrap4.min.css' ?>">
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
</style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">Financeiro</li>
<li class="breadcrumb-item">Formas de Pagamento</li>
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
        <form role="form" id="formFiltersPeople" autocomplete="off" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Descrição do Relatório</label>
                            <input type="text" name="descriptionReport" id="descriptionReport" class="form-control">
                        </div>
                    </div>

                    <div class="col-5">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Formas de Pagamento mais utilizadas</h3>
                            </div>
                            <div class="card-body table-responsive p-0" style="height: 200px;">
                                <table class="table table-head-fixed text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Descrição</th>
                                            <th>Quantidade</th>
                                            <th>Progesso</th>
                                            <th>Percentual</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($searchPeople->fetchAll(\PDO::FETCH_ASSOC) as $row) { ?>
                                            <tr>
                                                <td><?php echo $row['orca_nome']; ?></td>
                                                <td><?php echo $row['Qtde']; ?></td>
                                                <td>
                                                    <div class="progress progress-xs">
                                                        <div class="<?php //mais uma cor = azul
                                                                    if ($row['perc'] >= 30) {
                                                                        echo 'progress-bar progress-bar-danger';
                                                                    } else if ($row['perc'] >= 30 && $row['perc'] <= 60) {
                                                                        echo 'progress-bar progress-bar-warning';
                                                                    } else {
                                                                        echo 'progress-bar progress-bar-success';
                                                                    }
                                                                    ?>" style="width: <?php echo $row['perc'] . "%"; ?>"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="<?php
                                                                    if ($row['perc'] <= 30) {
                                                                        echo 'badge bg-danger';
                                                                    } else if ($row['perc'] >= 30 && $row['perc'] <= 60) {
                                                                        echo 'badge bg-warning';
                                                                    } else {
                                                                        echo 'badge bg-success';
                                                                    }
                                                                    ?>"> <?php echo number_format($row['perc'], 2, '.', '') . "%"; ?></span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
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
                        <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal" data-target="#modalRegisterPaymentMethod">Novo</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="listPaymentMethod" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descrição</th>
                                <th>Parcela(s)</th>
                                <th>Observações</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Código</th>
                                <th>Descrição</th>
                                <th>Parcela(s)</th>
                                <th>Observações</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRegisterPaymentMethod" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formRegisterPaymentMethod" method="POST" novalidate="novalidate" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Cadastrar Forma de Pagamento</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Descrição</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <select class="form-control" name="descriptionRegister" id="descriptionRegister" onchange="findPaymentMethod();">
                                        <option value="Dinheiro">Dinheiro</option>
                                        <option value="Cartão de Crédito">Cartão de Crédito</option>
                                        <option value="Cartão de Debito">Cartão de Debito</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Boleto bancário">Boleto bancário</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Parcelas</label> <label style="color: red; font-size: 12px;"> * </label>
                                    <input type="number" name="installmentRegister" id="installmentRegister" class="form-control" onblur="findPaymentMethod();">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Observações</label>
                                    <textarea class="form-control" rows="3" name="observationRegister" id="observationRegister" style="height: 60px;" onblur="findPaymentMethod();"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-register-payment-method" id="btnRegisterPaymentMethod" onclick="findPaymentMethod();">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="<?= DIRPLUGINS . 'datatables/jquery.dataTables.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-bs4/js/dataTables.bootstrap4.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-responsive/js/dataTables.responsive.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-responsive/js/responsive.bootstrap4.min.js' ?>"></script>
<script src="<?= DIRJS . 'finance/payment-method/payment-method.js' ?>"></script>
<script src="<?= DIRJS . 'finance/payment-method/register-payment-method.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>
<script>
    $(function() {
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        });
        $('[data-mask]').inputmask();
    });
</script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/b-1.6.2/b-colvis-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/cr-1.5.2/fh-3.1.7/kt-2.5.2/datatables.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/b-1.6.2/b-colvis-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/cr-1.5.2/fh-3.1.7/kt-2.5.2/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

@endsection