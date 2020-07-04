<?php
session_start();
require_once '../app/Model/connection-mysqli.php';
?>

<?php $__env->startSection('title', 'Calendário'); ?>
<?php $__env->startSection('head'); ?>
<!-- fullCalendar -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'fullcalendar/main.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'fullcalendar-daygrid/main.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'fullcalendar-timegrid/main.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'fullcalendar-bootstrap/main.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'toastr/toastr.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'list/main.css' ?>">

<!-- Select 2 -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'select2/css/select2.min.css' ?>">

<!-- Timer Picker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .fc-today {
        background: #dff7fa !important;
        border: none !important;
        border-top: 1px solid #ddd !important;
        font-weight: bold !important;
        /*opacity: 0.5 !important;*/
    }

    .fc-day-number {
        color: #212529 !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">Agenda</li>
<li class="breadcrumb-item">Calendário</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>

<div class="container-fluid">
    <div class="row">
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

<!-- Formulario Visualizar -->
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
                <div class="divViewEvent">
                <dl class="row">
                        <dt class="col-sm-3">ID:</dt>
                        <dd class="col-sm-8" id="id"></dd>

                        <dt class="col-sm-3">Titulo:</dt>
                        <dd class="col-sm-8" id="title"></dd>

                        <dt class="col-sm-3">Inicío:</dt>
                        <dd class="col-sm-8" id="start"></dd>

                        <dt class="col-sm-3">Fim:</dt>
                        <dd class="col-sm-8" id="end"></dd>



                        <dt class="col-sm-3">Cliente:</dt>
                        <dd class="col-sm-8" id="client"></dd>

                        <dt class="col-sm-3">Endereço:</dt>
                        <dd class="col-sm-8"><a href="" id="address"></a></dd>

                        <dt class="col-sm-3">Celular:</dt>
                        <dd class="col-sm-8"><a href="" id="phone"></a></dd>

                        <dt class="col-sm-3">Observação:</dt>
                        <dd class="col-sm-8" id="observation"> hdfhdfhdfhdfhdfhdfhdhdfhdfh</dd>

                        <dt class="col-sm-3"> Observação: </dt>
                        <div class="col-sm-9"> <textarea class="form-control" id="observation" rows="2" disabled="" style="width: 100%;"> </textarea></div>
                    </dl>
                    <!--se mudar o botao vai caga tudo por causa desse btn-canc-vis -->
                    <!-- Botões Editar e Apagar -->
                    <div class="modal-footer" id="footer">
                        <button class="btn btn-warning btn-edit-event">Editar</button>
                        <a href="" id="deleteEvent" class="btn btn-danger">Apagar</a>
                    </div>
                </div>

                <!-- Formulario Editar -->
                <div class="formedit">
                    <span id="msg-edit"></span>
                    <form id="formEditEvent" method="POST" enctype="multipart/form-data">
                        <div class="row">
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

                            <!-- Botões Cancelar e Salvar -->
                            <div class="modal-footer" id="footer">
                                <button type="button" class="btn btn-primary btn-cancel-edit" onclick="hideButtons();">Cancelar</button>
                                <button type="submit" name="CadEvent" id="CadEvent" value="CadEvent" class="btn btn-warning">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalRegisterEvent">
    <div class="modal-dialog">
        <form id="formRegisterEvent" method="POST" autocomplete="off" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cadastrar Evento e/ou Pessoa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="visevent">
                        <span id="msg-cad"></span>
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Agendar Horario?</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionScheduleTimeYes" name="scheduleTime" onclick="optionsScheduleTime();" checked="" value="timeYes">
                                        <label for="optionScheduleTimeYes" class="custom-control-label">Sim</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionScheduleTimeNo" name="scheduleTime" onclick="optionsScheduleTime();" value="timeNo">
                                        <label for="optionScheduleTimeNo" class="custom-control-label">Não</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" name="name" id="name" class="form-control" autofocus placeholder="Entre com o Nome">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Sobrenome</label>
                                    <input type="text" name="surname" id="surname" class="form-control" placeholder="Entre com o Sobrenome">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Celular</label>
                                    <input type="tel" name="cellphone" id="cellphone" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(99) 99999-9999&quot;" data-mask="" value="19" placeholder="Entre com o Celular">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Telefone</label>
                                    <input type="tel" class="form-control" name="telephone" id="telephone" data-inputmask="&quot;mask&quot;: &quot;(99) 9999-9999&quot;" data-mask="" value="19" placeholder="Entre com o Telefone">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Entre com o Email">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>CEP</label>
                                    <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/buscaCepEndereco.cfm" target="_blank"> <i class="fas fa-question-circle"></i> </a>
                                    <input type="tel" class="form-control" name="cep" id="cep" data-inputmask="'mask': ['99999-999']" data-mask="" placeholder="Entre com o CEP" value="13">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="logradouro">Logradouro</label>
                                    <input type="text" name="street" class="form-control" style="cursor: not-allowed;" id="logradouro" placeholder="Entre com o Logradouro" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" name="neighborhood" class="form-control" style="cursor: not-allowed;" id="bairro" placeholder="Entre com o Bairro" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="localidade">Cidade</label>
                                    <input type="text" name="city" class="form-control" style="cursor: not-allowed;" id="localidade" placeholder="Entre com a Cidade" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="uf">Estado</label>
                                    <input type="text" name="surname" class="form-control" style="cursor: not-allowed;" id="uf" placeholder="Entre com o Estado" disabled>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Tipo de Residencia</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionHome" name="typeresidence" onclick="selTypeResidence();">
                                        <label for="optionHome" class="custom-control-label">Casa</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionBuilding" name="typeresidence" onclick="selTypeResidence();">
                                        <label for="optionBuilding" class="custom-control-label">Apartamento</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionCondominium" name="typeresidence" onclick="selTypeResidence();">
                                        <label for="optionCondominium" class="custom-control-label">Condominio</label>
                                    </div>
                                </div>
                            </div>


                            <div id="number" class="col-sm-2" style="display:none">
                                <div class="form-group">
                                    <label>Número</label>
                                    <input type="text" name="number" id="number" class="form-control" placeholder="Entre com o Número">
                                </div>
                            </div>

                            <div id="streetCondominium" class="col-sm-5" style="display:none">
                                <div class="form-group">
                                    <label>Rua do Condominio</label>
                                    <input type="text" name="streetCondominium" id="streetCondominium" class="form-control" placeholder="Entre com o Número">
                                </div>
                            </div>


                            <div id="edifice" class="col-sm-7" style="display:none">
                                <div class="form-group">
                                    <label>Edifício</label>
                                    <input type="text" name="edifice" id="edifice" class="form-control" placeholder="Entre com o Edifício">
                                </div>
                            </div>
                            <div id="block" class="col-sm-2" style="display:none">
                                <div class="form-group">
                                    <label>Bloco</label>
                                    <input type="text" name="block" id="block" class="form-control" placeholder="Entre com o Bloco">
                                </div>
                            </div>
                            <div id="apartment" class="col-sm-3" style="display:none">
                                <div class="form-group">
                                    <label>Apartamento</label>
                                    <input type="text" name="apartment" id="apartment" class="form-control" placeholder="Entre com o Apartamento">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>Observações:</label>
                                    <textarea class="form-control" rows="3" placeholder="Enter ..." name="observation" id="observation" style="height: 50px;"></textarea>
                                </div>
                            </div>





















                            <!--<div class="col-sm-6" id="divTitleEvent">
                                <div class="form-group">
                                    <label>Titulo</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Titulo do Evento">
                                </div>
                            </div>-->

                            <div class="col-sm-12" id="divTitleEvent">
                                <div class="form-group">
                                    <label>Evento:</label>
                                    <select name="title" id="title" class="form-control">
                                        <option value="Realizar Orçamento">Realizar Orçamento</option>
                                        <option value="Voltar na Obra">Voltar na Obra</option>
                                        <option value="Início de Obra">Início de Obra</option>
                                    </select>
                                </div>
                            </div>

                            <!--<div class="col-sm-6" id="divColorEvent">
                                <div class="form-group">
                                    <label>Evento:</label>
                                    <select name="color" class="form-control" id="color">
                                        <option value="">Titulo do Evento</option>
                                        <option style="color:#FFD700;" value="#FFD700">Amarelo</option>
                                        <option style="color:#0071c5;" value="#0071c5">Azul</option>
                                        <option style="color:#FF4500;" value="#FF4500">Laranja</option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-sm-5" id="divStartEvent">
                                <div class="form-group">
                                    <label>Data Inicial</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="startDate" id="startDate" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3" id="divStartTimediv">
                                <div class="form-group">
                                    <label>Hora Fim</label>
                                    <div class="input-group date" id="divStartTime" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#divStartTime" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                            <input type="tel" class="form-control datetimepicker-input" data-target="#divStartTime" name="startTime" id="startTime" onkeyup="somenteNumeros(this);" maxlength="5" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3" id="divEndTimediv">
                                <div class="form-group">
                                    <label>Hora Fim</label>
                                    <div class="input-group date" id="divEndTime" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#divEndTime" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                            <input type="tel" class="form-control datetimepicker-input" data-target="#divEndTime" name="endTime" id="endTime" onkeyup="somenteNumeros(this);" maxlength="5" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--<div class="col-sm-3">
                                <div class="form-group">
                                    <label>Hora Fim</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="endTime" id="endTime" class="form-control">
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="col-sm-5" id="divEndEvent">
                                <div class="form-group">
                                    <label>Data final</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="endDate" id="endDate" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false">
                                    </div>
                                </div>
                            </div> -->
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<!-- fullCalendar 2.2.5 -->
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'fullcalendar/main.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'fullcalendar/locales/pt-br.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'fullcalendar-daygrid/main.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'list/main.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'fullcalendar-timegrid/main.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'fullcalendar-interaction/main.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'fullcalendar-bootstrap/main.min.js' ?>"></script>

<!-- Script do Calendário -->
<script src="<?= DIRPLUGINS . 'schedule/calendar.js' ?>"></script>

<!-- InputMask -->
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>

<!-- Busca endereço pelo CEP -->
<script src="<?= DIRPLUGINS . 'search-zip/search-zip.js' ?>"></script>

<!-- JQuery validation -->
<script src="<?= DIRPLUGINS . 'jquery-validation/jquery.validate.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'jquery-validation/additional-methods.min.js' ?>"></script>

<!-- Select2 -->
<script src="<?= DIRPLUGINS . 'select2/js/select2.full.min.js' ?>"></script>

<!-- Date Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />

<!-- Timer Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Alerta de cadastro - Toastr Examples -->
<script src="<?= DIRPLUGINS . 'toastr/toastr.min.js' ?>"></script>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        /* Datemask */
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        });
        /* Datemask */
        $('[data-mask]').inputmask();
    });

    /* Tradução Date Picker */
    $.fn.datepicker.dates['pt-BR'] = {
        days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
        daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
        daysMin: ["Do", "2ª", "3ª", "4ª", "5ª", "6ª", "Sá"],
        months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
        monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
        titleFormat: "MM yyyy",
        /* Leverages same syntax as 'format' */
        weekStart: 0
    };

    $(document).ready(function() {
        /*Bloquear horarios nao permitidos*/
        $(function() {
            $('#divEndTime').datetimepicker({
                format: 'HH:mm',
                enabledHours: [7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
            });

            $('#divStartTime').datetimepicker({
                format: 'HH:mm',
                enabledHours: [7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
            });
        });
    });


    function somenteNumeros(num) {
        var er = /[^0-9:]/;
        er.lastIndex = 0;
        var campo = num;
        if (er.test(campo.value)) {
            campo.value = "";
        }
    }

    /* Fechar form Visualizar com Shift+F */
    $(document).keyup(function(e) { //O evento Kyeup é acionado quando as teclas são soltas
        if (e.which == 16) pressedCtrl = false; //Quando qualuer tecla for solta é preciso informar que Crtl não está pressionada
    })
    $(document).keydown(function(e) { //Quando uma tecla é pressionada
        if (e.which == 67) pressedCtrl = true; //Informando que Crtl está acionado
        if ((e.which == 67 || e.keyCode == 67) && pressedCtrl == true) { //Reconhecendo tecla Enter
            $('#modalRegisterEvent').modal('show');
        }
    });

    $(document).keydown(function(e) { //Quando uma tecla é pressionada
        if (e.which == 27) pressedCtrl = true; //Informando que Crtl está acionado
        if ((e.which == 27 || e.keyCode == 27) && pressedCtrl == true) { //Reconhecendo tecla Enter
            $('#modalViewEvent').modal('hide');
            $('#modalRegisterEvent').modal('hide');
        }
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sys-ouse\app\View/schedule/schedule-calendar/schedule-calendar.blade.php ENDPATH**/ ?>