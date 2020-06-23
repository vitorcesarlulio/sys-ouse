@extends('templates.default')

@section('title', 'Eventos')

@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-bs4/css/dataTables.bootstrap4.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-responsive/css/responsive.bootstrap4.min.css' ?>">
@endsection

@section('content')
<div class="container-fluid">
    <div class="card card-default">
        <div class="card-header" style="background-color:#FF4500">
            <h3 class="card-title">Select2 (Default Theme)</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <form role="form" id="quickForm" action="/cadastrar" novalidate="novalidate" autocomplete="off" method="post">

                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Data de:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false">
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
                                    <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false">
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Evento:</label>
                                <select name="color" class="form-control">
                                    <option value="">Todos</option>
                                    <option style="color:#FFD700;" value="#FFD700">Amarelo</option>
                                    <option style="color:#0071c5;" value="#0071c5">Azul</option>
                                    <option style="color:#FF4500;" value="#FF4500">Laranja</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Ralizado:</label>
                                <select name="color" class="form-control" id="color">
                                    <option value="">Todos</option>
                                    <option value="">Sim</option>
                                    <option value="">Não</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <!-- /.row -->


        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="reset" class="btn btn-default" value="Limpar formulário"><i class="fas fa-times"></i></button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i></button>
        </div>
    </div>
    <!-- /.card -->

    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">DataTable with minimal features & hover style</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="listar-usuario" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="background-color:#FF4500; color: #fff ;border: #FF4500">Cliente</th>
                                <th>Endereço</th>
                                <th>Celular</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
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

    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog">
            <form id="editEvent" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Evento</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label>Titulo</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Titulo do Evento">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Select</label>
                                <select name="color" class="form-control" id="color">
                                    <option value="">Selecione</option>
                                    <option style="color:#FFD700;" value="#FFD700">Amarelo</option>
                                    <option style="color:#0071c5;" value="#0071c5">Azul Turquesa</option>
                                    <option style="color:#FF4500;" value="#FF4500">Laranja</option>
                                    <option style="color:#8B4513;" value="#8B4513">Marrom</option>
                                    <option style="color:#1C1C1C;" value="#1C1C1C">Preto</option>
                                    <option style="color:#436EEE;" value="#436EEE">Royal Blue</option>
                                    <option style="color:#A020F0;" value="#A020F0">Roxo</option>
                                    <option style="color:#40E0D0;" value="#40E0D0">Turquesa</option>
                                    <option style="color:#228B22;" value="#228B22">Verde</option>
                                    <option style="color:#8B0000;" value="#8B0000">Vermelho</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Inicio do Evento</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="start" id="start" class="form-control" onkeypress="DataHora(event, this)">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Fim do Evento</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="end" id="end" class="form-control" onkeypress="DataHora(event, this)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="CadEvent" id="CadEvent" value="CadEvent" class="btn btn-warning">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal modal-warning fade" id="modal_edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Language</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="language_name">Language Name</label>
                        <input name="language_name" id="language_name" type="text" value="" class="form-control" placeholder="Language Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancel</button>
                    <button id="edit_action" type="button" class="btn btn-outline">Submit</button>
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

<!-- InputMask (MASCARAS) -->
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>

<!-- page script -->
<script>
    $(document).ready(function() {
        fetch_data();

        function fetch_data() {
            var dataTable = $("#listar-usuario").DataTable({
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
                    "type": "POST"
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
                        $('#alert_message').html('<div class="alert alert-success"> Evnto excluido </div>');
                        $("#listar-usuario").DataTable().destroy();
                        fetch_data();
                    }
                })
            }
        });

    });
</script>

<!-- Page script (mascaras) -->
<script>
    $(function() {
        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })

        //Money Euro E AS MACARAS TAMBEM SAI SE VC TIRAR
        $('[data-mask]').inputmask()

    })
</script>
@endsection