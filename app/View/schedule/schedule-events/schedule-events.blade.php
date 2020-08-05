@extends('templates.default')

@section('title', 'Eventos')

@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-bs4/css/dataTables.bootstrap4.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-responsive/css/responsive.bootstrap4.min.css' ?>">

<link rel="stylesheet" href="<?= DIRPLUGINS . 'toastr/toastr.min.css' ?>">
@endsection

@section('css')
<style>
    /* div.dt-buttons {
        position: relative;
        float: right;
    }

    div.dataTables_filter {
        padding-top: .5rem;
    }


    div.dropdown-menu {
        background-color: #FE5000;
        border: #FE5000;
    }
    .buttons-print,
    .buttons-excel {
        color: #FFF;
        background-color: #FE5000;
        border: #FE5000;
    }
    .buttons-print:hover,
    .buttons-excel:hover {
        background-color: #FE5000;
        border: #FE5000;
    } 

    .badge{
        border-color: #FFC107;
        color: #fff;
    }
    
    .dataTables_filter { //deixar a caixa de filtro no meio
	float: left;
	margin-top: 4px;
	margin-right: 2%;
	text-align: left;
    }
    */
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
<li class="breadcrumb-item">Agenda</li>
<li class="breadcrumb-item">Eventos</li>
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
        <form role="form" id="formFilters" autocomplete="off" enctype="multipart/form-data">
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
                </div>
                <div class="card-body">
                    <table id="listEvents" class="table table-hover">
                        <!--table table-bordered table-striped dataTable dtr-inline-->
                        <thead>
                            <tr>
                                <th>Evento</th>
                                <th>Pessoa</th>
                                <th>Data de início</th>
                                <th>Hora Inicial</th>
                                <th>Hora Final</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Evento </th>
                                <th>Pessoa </th>
                                <th>Data de início</th>
                                <th>Hora Inicial </th>
                                <th>Hora Final </th>
                                <th>Status </th>
                                <th>Ações </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Visualizar Evento -->
    <div class="modal fade" id="modalViewEvent" data-toggle="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detalhes do Evento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <dl class="row">
                        <dt class="col-sm-3">Evento:</dt>
                        <dd class="col-sm-8" id="title"></dd>

                        <dt class="col-sm-3">Inicío:</dt>
                        <dd class="col-sm-8" id="start"></dd>

                        <dt class="col-sm-3">Fim:</dt>
                        <dd class="col-sm-8" id="end"></dd>

                        <dt class="col-sm-3">Status:</dt>
                        <dd class="col-sm-8" id="status"></dd>
                        <div id="P" style="display:none"></div>
                        <div id="R" style="display:none"></div>

                        <dt class="col-sm-3">Pessoa:</dt>
                        <dd class="col-sm-8" id="name"></dd>

                        <dt class="col-sm-3">Endereço:</dt>
                        <dd class="col-sm-8"><a href="" target="_blank" id="address"></a></dd>

                        <dt class="col-sm-3" id="dtCellphone">Celular:</dt>
                        <dd class="col-sm-8" id="ddCellphone"><a href="" id="cellphone"></a></dd>

                        <dt class="col-sm-3" id="dtTelephone">Telefone:</dt>
                        <dd class="col-sm-8" id="ddTelephone"><a href="" id="telephone"></a></dd>

                        <dt class="col-sm-3" id="dtEmail">Email:</dt>
                        <dd class="col-sm-8" id="ddEmail"><a href="" id="email" target="_blank"></a></dd>

                        <dt class="col-sm-3" id="dtEdifice">Edificio:</dt>
                        <dd class="col-sm-8" id="edifice"></dd>

                        <dt class="col-sm-3" id="dtBlock">Bloco:</dt>
                        <dd class="col-sm-8" id="block"></dd>

                        <dt class="col-sm-3" id="dtApartment">Apartamento:</dt>
                        <dd class="col-sm-8" id="apartment"></dd>

                        <dt class="col-sm-3" id="dtStreetCondominium">Rua do Condomínio:</dt>
                        <dd class="col-sm-8" id="streetCondominium"></dd>

                        <dt class="col-sm-3" id="dtObservation"> Observação: </dt>
                        <div class="col-sm-9" id="divObservation"> <textarea class="form-control" id="observation" rows="2" style="width: 100%;"> </textarea></div>
                    </dl>
                </div>
                <div class="modal-footer" id="footer">
                    <a href="#" id="btnWpp" class="btn btn-success" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a href="#" class="btn btn-danger btn-delete-event">Apagar</a>
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

<script src="<?= DIRJS . 'schedule/schedule-events/events.js' ?>"></script>
<script src="<?= DIRJS . 'global-functions/confirm-action.js' ?>"></script>
<!-- Alerta de cadastro - Toastr Examples -->
<script src="<?= DIRPLUGINS . 'toastr/toastr.min.js' ?>"></script>

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