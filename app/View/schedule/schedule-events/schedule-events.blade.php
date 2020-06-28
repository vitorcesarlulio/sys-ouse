@extends('templates.default')

@section('title', 'Eventos')

@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-bs4/css/dataTables.bootstrap4.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-responsive/css/responsive.bootstrap4.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'toastr/toastr.min.css' ?>">
@endsection

@section('breadcrumb')
<li class="breadcrumb-item">Agenda</li>
<li class="breadcrumb-item">Eventos</li>
@endsection

@section('content')
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
                    <table id="listEvents" class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titulo</th>
                                <th>cor</th>
                                <th>start</th>
                                <th>end</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Titulo</th>
                                <th>cor</th>
                                <th>start</th>
                                <th>end</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
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

<!-- Alerta de cadastro - Toastr Examples -->
<script src="<?= DIRPLUGINS . 'toastr/toastr.min.js' ?>"></script>

<!-- InputMask (MASCARAS) -->
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>

<!-- page script -->
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        fetch_data('no');

        function fetch_data(is_date_search, start_date='', end_date='') {
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
                    "data": {
                        is_date_search:is_date_search, start_date:start_date, end_date:end_date
                    }
                },

                /* Tirar ordenação da coluna que não desejo 
                "columnDefs": [{
                    "targets": [3],
                    "orderable": false
                }],*/

                /* Tradução */
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

        /* Excluir Evnto */
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

        $('#search').click(function() {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if (start_date != '' && end_date != '') {
                $('#listEvents').DataTable().destroy();
                fetch_data('yes', start_date, end_date);
            } else {
                alert("Data é necessária!");
            }
        });

    });



    /* Depois de um tempo ocultar o alerta de cadastro/apagado/editado 
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

    })*/
</script>
@endsection