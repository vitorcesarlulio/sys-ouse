

<?php $__env->startSection('title', 'Eventos'); ?>

<?php $__env->startSection('head'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-bs4/css/dataTables.bootstrap4.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-responsive/css/responsive.bootstrap4.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'toastr/toastr.min.css' ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">Agenda</li>
<li class="breadcrumb-item">Eventos</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div id="alertMessageDelete"></div>

<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Filtros</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <form role="form" id="" action="/agenda/eventos/listar" novalidate="novalidate" autocomplete="off" method="POST">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Data de:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="start_date" id="start_date" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Até:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="end_date" id="end_date" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false">
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-sm-3">
                            <div class="form-group">
                                <label>Status:</label>
                                <select name="status" class="form-control" id="color">
                                    <option value="">Todos</option>
                                    <option style="background-color:#008000;" value="R">Realizado</option>
                                    <option style="background-color:#ffff00;" value="A">A fazer</option>
                                </select>
                            </div>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>
        <div class="card-footer">
            <button type="reset" class="btn btn-default" value="Limpar formulário"><i class="fas fa-times"></i></button>
            <button type="button" class="btn btn-primary" name="search" id="search" value="Search"><i class="fas fa-check"></i></button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Resultado do Filtro</h3>
                </div>
                <div class="card-body">
                    <table id="listEvents" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Endereço</th>
                                <th>Celular</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Cliente</th>
                                <th>Endereço</th>
                                <th>Celular</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<!-- DataTables -->
<script src="<?= DIRPLUGINS . 'datatables/jquery.dataTables.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-bs4/js/dataTables.bootstrap4.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-responsive/js/dataTables.responsive.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-responsive/js/responsive.bootstrap4.min.js' ?>"></script>

<!-- Alerta de cadastro - Toastr Examples -->
<script src="<?= DIRPLUGINS . 'toastr/toastr.min.js' ?>"></script>

<!-- InputMask (MASCARAS) -->
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>

<!-- page script -->
<script>
    $(document).ready(function() {
        fetch_data();

        function fetch_data() {
            var dataTable = $("#listEvents").DataTable({
                "autoWidth": false,
                "responsive": true,
                "processing": true,
                "serverSide": true,
                //"paging": true,
                //"lengthChange": false,
                //"searching": false,
                //"ordering": true,
                //"info": true,

                "ajax": {
                    "url": "/agenda/eventos/listar",
                    "type": "POST",
                    //"data":
                },

                /*Tirar ordenação da coluna que não desejo*/
                "columnDefs": [{
                    "targets": [3],
                    "orderable": false
                }],

                "language": {
                    "lengthMenu": "Mostrando _MENU_ resgistros por página",
                    "zeroRecords": "Nenhum registro encontrado",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "Nenhum resgistro disponível",
                    "infoFiltered": "(Filtrado de _MAX_ registros no total)",
                    "search": "Pesquisar:",
                    "processing": "Processando...",
                    "loadingRecords": "Loading...",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Último",
                        "next": "Próximo",
                        "previous": "Anterior"
                    },

                    /* "decimal":        "",
                    "emptyTable":     "No data available in table",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "aria": {
                        "sortAscending":  ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }*/
                }
            });
        }

        /*Excluir Evnto */
        $(document).on('click', '.btn-danger', function() {
            var id = $(this).attr("id");
            if (confirm("Deseja mesmo excluir?")) {
                $.ajax({
                    url: "/agenda/eventos/apagar",
                    method: "POST",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('#alertMessageDelete').html('<div id="toast-container" class="toast-top-right"><div class="toast toast-success" aria-live="polite" style=""><div class="toast-message">Evento apagado com sucesso!</div></div></div>');
                        $("#listEvents").DataTable().destroy();
                        fetch_data();
                    }
                })
            }
        });
    });

    /*
     * Depois de um tempo ocultar o alerta de cadastro/apagado/editado
     */
    setTimeout(function() {
        var a = document.getElementById("alertMessageDelete");
        a.style.display = "none"
    }, 8000);

    $(function() {
        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })

        //Money Euro E AS MACARAS TAMBEM SAI SE VC TIRAR
        $('[data-mask]').inputmask()

    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sys-ouse\app\View/schedule/schedule-events/schedule-events.blade.php ENDPATH**/ ?>