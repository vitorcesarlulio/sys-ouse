<?php
session_start();
require_once '../app/Model/connection-mysqli.php';
?>

@extends('templates.default')
@section('title', 'Calendário')
@section('head')
<!-- fullCalendar -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'fullcalendar/main.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'fullcalendar-daygrid/main.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'fullcalendar-timegrid/main.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'fullcalendar-bootstrap/main.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'toastr/toastr.min.css' ?>">
<!-- Select2 -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'select2/css/select2.min.css' ?>">
@endsection

@section('css')
<style>
    .fc-today {
        background: #228B22 !important;
        border: none !important;
        border-top: 1px solid #ddd !important;
        font-weight: bold;
        opacity: 0.5 !important;
    }
</style>
@endsection

@section('content')
<?php
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="sticky-top mb-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Draggable Events</h4>
                    </div>
                    <div class="card-body">
                        <div id="external-events">
                            <div class="external-event bg-success ui-draggable ui-draggable-handle" style="position: relative;">Lunch</div>
                            <div class="external-event bg-warning ui-draggable ui-draggable-handle" style="position: relative;">Go home</div>
                            <div class="external-event bg-info ui-draggable ui-draggable-handle" style="position: relative;">Do homework</div>
                            <div class="external-event bg-primary ui-draggable ui-draggable-handle" style="position: relative;">Work on UI design</div>
                            <div class="external-event bg-danger ui-draggable ui-draggable-handle" style="position: relative;">Sleep tight</div>
                            <div class="checkbox">
                                <label for="drop-remove">
                                    <input type="checkbox" id="drop-remove">
                                    remove after drop
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create Event</h3>
                    </div>
                    <div class="card-body">
                        <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                            <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                            <ul class="fc-color-picker" id="color-chooser">
                                <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                                <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                                <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                                <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                                <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                            </ul>
                        </div>
                        <div class="input-group">
                            <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                            <div class="input-group-append">
                                <button id="add-new-event" type="button" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card card-primary">
                <div class="card-body p-0">
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulário Visualizar -->
<div class="modal fade" id="modalViewEvent">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detalhes do Evento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="visevent">
                    <dl class="row">
                        <dt class="col-sm-4">ID:</dt>
                        <dd class="col-sm-8" id="id"></dd>

                        <dt class="col-sm-4">Evento:</dt>
                        <dd class="col-sm-8">A description list is perfect for defining terms.</dd>

                        <dt class="col-sm-4">Cliente:</dt>
                        <dd class="col-sm-8">Vitor Cesar</dd>

                        <dt class="col-sm-4">Endereço:</dt>
                        <dd class="col-sm-8">Rua maceio 670, cidade nova, sbo</dd>

                        <dt class="col-sm-4">Celular:</dt>
                        <dd class="col-sm-8"> <a href="tel:+55-19-99625-8494"> 19 99625-8494 </a></dd>

                        <dt class="col-sm-4">Inicío:</dt>
                        <dd class="col-sm-8" id="start"></dd>

                        <dt class="col-sm-4">Fim:</dt>
                        <dd class="col-sm-8" id="end"></dd>

                        <dt class="col-sm-4">Observação:</dt>
                        <dd class="col-sm-8" id="observation"></dd>
                    </dl>

                    <!--se mudar o botao vai caga tudo por causa desse btn-canc-vis -->
                    <!-- Botões Editar e Apagar -->
                    <div class="modal-footer" id="footer">
                        <button class="btn btn-warning btn-canc-vis">Editar</button>
                        <a href="" id="deleteEvent" class="btn btn-danger">Apagar</a>
                    </div>
                </div>
            </div>
 


        </div>
    </div>
</div>

<!-- Formulário Editar 
<div class="modal fade" id="modalEdit">
    <span id="msg-edit"></span>
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
</div>-->

<div class="modal fade" id="modalRegisterEvent">
    <div class="modal-dialog">
        <form id="formRegisterEvent" method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cadastrar Evento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="visevent">
                        <span id="msg-cad"></span>
                        <div class="row">
























                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Titulo</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Titulo do Evento">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Evento:</label>
                                    <select name="color" class="form-control" id="color">
                                        <option value="">Titulo do Evento</option>
                                        <option style="color:#FFD700;" value="#FFD700">Amarelo</option>
                                        <option style="color:#0071c5;" value="#0071c5">Azul</option>
                                        <option style="color:#FF4500;" value="#FF4500">Laranja</option>
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
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-success toastrDefaultSuccess">Cadastrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!--so para nao dar erro no Js do Modal -->
<div id="toast-container"> </div>
@endsection


@section('script')
<!-- fullCalendar 2.2.5 -->
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'fullcalendar/main.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'fullcalendar/locales/pt-br.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'fullcalendar-daygrid/main.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'fullcalendar-timegrid/main.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'fullcalendar-interaction/main.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'fullcalendar-bootstrap/main.min.js' ?>"></script>

<!-- Select2 -->
<script src="<?= DIRPLUGINS . 'select2/js/select2.full.min.js' ?>"></script>

<!-- Script do Calendario -->
<script src="<?= DIRPLUGINS . 'schedule/calendar.js' ?>"></script>

<!-- Alerta de cadastro - Toastr Examples -->
<script src="<?= DIRPLUGINS . 'toastr/toastr.min.js' ?>"></script>

@endsection