<?php
require_once '../app/View/login/check-login.php';

include_once '../app/Model/connection-pdo.php';
$querySelectClientBudget = " SELECT orca_numero, orca_nome, orca_sobrenome FROM tb_orcamento ORDER BY orca_numero DESC";
$searchClientBudget = $connectionDataBase->prepare($querySelectClientBudget);
$searchClientBudget->execute();
?>


<?php $__env->startSection('title', 'Calendário'); ?>
<?php $__env->startSection('head'); ?>
<!-- fullCalendar -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'fullcalendar/main.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'fullcalendar-daygrid/main.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'fullcalendar-timegrid/main.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'fullcalendar-bootstrap/main.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'list/main.css' ?>">
<!-- Date Picker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />
<!-- Select 2 -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'select2/css/select2.min.css' ?>">
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
    /* .col-md-9{
        align-items: center !important;
    } */
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item">Agenda</li>
<li class="breadcrumb-item">Calendário</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-body p-0">
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
                        <dd class="col-sm-8" id="idEventView" style="display: none;"></dd>

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

                        <!--se usar a outra forma de ocultar tem que criar uma div que englobe os 2 campos abaixo-->
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
                    <div class="modal-footer" id="footer">
                        <a href="#" id="btnWpp" class="btn btn-success" target="_blank"><i class="fab fa-whatsapp"></i></a>
                        <button class="btn btn-warning btn-edit-event">Editar</button>
                        <button class="btn btn-danger btn-delete-event" onclick="confirmDeleteEvent();" id="deleteEvent">Apagar</button>                       
                    </div>
                </div>

                <!-- Formulario Editar -->
                <div class="formedit">
                    <span id="msg-edit"></span>
                    <form id="formEditEvent" method="POST" enctype="multipart/form-data" autocomplete="off">
                        <div class="col-sm-12">
                            <div class="row">
                                <input type="hidden" name="idEvent" id="idEvent">
                                <input type="hidden" name="idBudget" id="idBudget">
                                <div class="col-sm-12" id="divTitleEdit">
                                    <div class="form-group">
                                        <label>Evento:</label>
                                        <select name="selectionTitleEdit" id="selectionTitleEdit" class="form-control" disabled style="cursor: not-allowed;">
                                            <option value="Realizar Orçamento" id="optionRealizarOrcamento">Realizar Orçamento</option>
                                            <option value="Voltar na Obra" id="optionVoltarObra">Voltar na Obra</option>
                                            <option value="Início de Obra" id="optionInicioObra">Início de Obra</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6" id="divStartDateEdit">
                                    <div class="form-group">
                                        <label>Data Inicial</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" name="startDateEdit" id="startDateEdit" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3" id="divStartTimeEdit">
                                    <div class="form-group">
                                        <label>Hora Inicial</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <div class="input-group">
                                            <input type="time" name="startTimeEdit" id="startTimeEdit" class="form-control" min="08:00" max="17:00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3" id="divEndTimeEdit">
                                    <div class="form-group">
                                        <label>Hora Final</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <div class="input-group">
                                            <input type="time" name="endTimeEdit" id="endTimeEdit" class="form-control" min="08:00" max="17:00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6" id="divNameEdit">
                                    <div class="form-group">
                                        <label>Nome</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <input type="text" name="nameEdit" id="nameEdit" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6" id="divSurnameEdit">
                                    <div class="form-group">
                                        <label>Sobrenome</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <input type="text" name="surnameEdit" id="surnameEdit" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6" id="divCellphoneEdit">
                                    <div class="form-group">
                                        <label>Celular</label>
                                        <input type="tel" class="form-control contact" name="cellphoneEdit" id="cellphoneEdit" data-inputmask="&quot;mask&quot;: &quot;(99) 99999-9999&quot;" data-mask="" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6" id="divTelephoneEdit">
                                    <div class="form-group">
                                        <label>Telefone</label>
                                        <input type="tel" class="form-control contact" name="telephoneEdit" id="telephoneEdit" data-inputmask="&quot;mask&quot;: &quot;(99) 9999-9999&quot;" data-mask="" value="">
                                    </div>
                                </div>
                                <div class="col-sm-6" id="divEmaileEdit">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="emailEdit" id="emailEdit">
                                    </div>
                                </div>
                                <div class="col-sm-6" id="divCepEdit">
                                    <div class="form-group">
                                        <label>CEP</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/buscaCepEndereco.cfm" target="_blank"> <i class="fas fa-question-circle"></i> </a>
                                        <input type="tel" class="form-control" name="cepEdit" id="cepEdit" data-inputmask="'mask': ['99999-999']" data-mask="" value="13" onblur="pesquisaCep(this.value);">
                                    </div>
                                </div>
                                <div class="col-sm-6" id="divStreetEdit">
                                    <div class="form-group">
                                        <label>Logradouro</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <input type="text" class="form-control" name="logradouroEdit" id="logradouroEdit" style="cursor: not-allowed;" readonly=“true” readonly=“true”>
                                    </div>
                                </div>
                                <div class="col-sm-6" id="divNeighBorhoodEdit">
                                    <div class="form-group">
                                        <label>Bairro</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <input type="text" name="bairroEdit" id="bairroEdit" class="form-control" style="cursor: not-allowed;" readonly=“true” readonly=“true”>
                                    </div>
                                </div>
                                <div class="col-sm-6" id="divCityEdit">
                                    <div class="form-group">
                                        <label>Cidade</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <input type="text" name="localidadeEdit" id="localidadeEdit" class="form-control" style="cursor: not-allowed;" readonly=“true”>
                                    </div>
                                </div>
                                <div class="col-sm-6" id="divStateEdit">
                                    <div class="form-group">
                                        <label>Estado</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <input type="text" name="ufEdit" id="ufEdit" class="form-control" style="cursor: not-allowed;" readonly=“true”>
                                    </div>
                                </div>
                                <div class="col-sm-12" id="divTypeResidenceEdit">
                                    <div class="form-group">
                                        <label>Tipo de Residência</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="optionHomeEdit" name="typeResidence" onclick="optionTypeResidenceEdit();">
                                            <label for="optionHomeEdit" class="custom-control-label">Casa</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="optionBuildingEdit" name="typeResidence" onclick="optionTypeResidenceEdit();">
                                            <label for="optionBuildingEdit" class="custom-control-label">Apartamento</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="optionCondominiumEdit" name="typeResidence" onclick="optionTypeResidenceEdit();">
                                            <label for="optionCondominiumEdit" class="custom-control-label">Condomínio</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3" id="divNumberEdit" style="display:none">
                                    <div class="form-group">
                                        <label>Número</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <input type="text" name="numberEdit" id="numberEdit" class="form-control">
                                    </div>
                                </div>
                                <div id="divEdificeEdit" class="col-sm-7" style="display:none">
                                    <div class="form-group">
                                        <label>Edifício</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <input type="text" name="edificeEdit" id="edificeEdit" class="form-control">
                                    </div>
                                </div>
                                <div id="divBlockEdit" class="col-sm-2" style="display:none">
                                    <div class="form-group">
                                        <label>Bloco</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <input type="text" name="blockEdit" id="blockEdit" class="form-control">
                                    </div>
                                </div>
                                <div id="divApartmentEdit" class="col-sm-3" style="display:none">
                                    <div class="form-group">
                                        <label>Apto.</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <input type="text" name="apartmentEdit" id="apartmentEdit" class="form-control">
                                    </div>
                                </div>
                                <div id="divStreetCondominiumEdit" class="col-sm-5" style="display:none">
                                    <div class="form-group">
                                        <label>Rua do Condomínio</label> <label style="color: red; font-size: 12px;"> * </label>
                                        <input type="text" name="streetCondominiumEdit" id="streetCondominiumEdit" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12" id="divObservationEdit">
                                    <div class="form-group">
                                        <label>Observações:</label>
                                        <textarea class="form-control" rows="3" name="observationEdit" id="observationEdit" style="height: 50px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" id="footer">
                            <button type="button" class="btn btn-default btn-cancel-edit">Cancelar</button>
                            <button type="submit" name="upDateEvent" id="btnUpDateEvent" class="btn btn-success">Salvar</button>
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
                    <span id="msg-cad"></span>
                    <div class="row">
                        <div class="col-sm-12" id="divScheduleTimeRegister">
                            <div class="form-group">
                                <label>Agendar Horário?</label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="optionScheduleTimeYes" name="scheduleTime" onclick="optionsScheduleTime();" checked="" value="scheduleTimeYes">
                                    <label for="optionScheduleTimeYes" class="custom-control-label">Sim</label>
                                </div>
                                <div class="custom-control custom-radio" id="divScheduleTimeNo">
                                    <input class="custom-control-input" type="radio" id="optionScheduleTimeNo" name="scheduleTime" onclick="optionsScheduleTime();" value="scheduleTimeNo">
                                    <label for="optionScheduleTimeNo" class="custom-control-label">Não</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" id="divTitleRegister">
                            <div class="form-group">
                                <label>Evento:</label>
                                <select name="selectionTitleRegister" id="selectionTitleRegister" class="form-control">
                                    <option value="Realizar Orçamento">Realizar Orçamento</option>
                                    <option value="Voltar na Obra">Voltar na Obra</option>
                                    <option value="Início de Obra">Início de Obra</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6" id="divStartDateRegister">
                            <div class="form-group">
                                <label>Data Inicial</label> <label style="color: red; font-size: 12px;"> * </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="startDateRegister" id="startDateRegister" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask="" im-insert="false">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3" id="divStartTimeRegister">
                            <div class="form-group">
                                <label>Hora Inicial</label> <label style="color: red; font-size: 12px;"> * </label>
                                <div class="input-group">
                                    <input type="time" name="startTimeRegister" id="startTimeRegister" class="form-control" min="08:00" max="17:00">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3" id="divEndTimeRegister">
                            <div class="form-group">
                                <label>Hora Final</label> <label style="color: red; font-size: 12px;"> * </label>
                                <div class="input-group">
                                    <input type="time" name="endTimeRegister" id="endTimeRegister" class="form-control" min="08:00" max="17:00">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" id="divNameRegister">
                            <div class="form-group">
                                <label>Nome</label> <label style="color: red; font-size: 12px;"> * </label>
                                <input type="text" autofocus name="nameRegister" id="nameRegister" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6" id="divSurnameRegister">
                            <div class="form-group">
                                <label>Sobrenome</label> <label style="color: red; font-size: 12px;"> * </label>
                                <input type="text" name="surnameRegister" id="surnameRegister" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6" id="divCellphoneRegister">
                            <div class="form-group">
                                <label>Celular</label>
                                <input type="tel" class="form-control contact" name="cellphoneRegister" id="cellphoneRegister" data-inputmask="&quot;mask&quot;: &quot;(99) 99999-9999&quot;" data-mask="" placeholder="Ex.: (xx) xxxxx-xxxx"> 
                            </div>
                        </div>
                        <div class="col-sm-6" id="divTelephoneRegister">
                            <div class="form-group">
                                <label>Telefone</label> 
                                <input type="tel" class="form-control contact" name="telephoneRegister" id="telephoneRegister" data-inputmask="&quot;mask&quot;: &quot;(99) 9999-9999&quot;" data-mask="" placeholder="Ex.: (xx) xxxx-xxxx">
                            </div>
                        </div>
                        <div class="col-sm-6" id="divEmaileRegister">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="emailRegister" id="emailRegister" placeholder="Ex.: email@email.com">
                            </div>
                        </div>
                        <div class="col-sm-6" id="divCepRegister">
                            <div class="form-group">
                                <label>CEP</label> <label style="color: red; font-size: 12px;"> * </label>
                                <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/buscaCepEndereco.cfm" target="_blank"> <i class="fas fa-question-circle"></i> </a>
                                <input type="tel" class="form-control" name="cep" id="cep" data-inputmask="'mask': ['99999-999']" data-mask="" value="13">
                            </div>
                        </div>
                        <div class="col-sm-6" id="divStreetRegister">
                            <div class="form-group">
                                <label>Logradouro</label> <label style="color: red; font-size: 12px;"> * </label>
                                <input type="text" class="form-control" name="logradouro" id="logradouro" style="cursor: not-allowed;" readonly=“true” readonly=“true”> <!-- ou readonly="readonly"-->
                            </div>
                        </div>
                        <div class="col-sm-6" id="divNeighBorhoodRegister">
                            <div class="form-group">
                                <label>Bairro</label> <label style="color: red; font-size: 12px;"> * </label>
                                <input type="text" name="bairro" id="bairro" class="form-control" style="cursor: not-allowed;" readonly=“true” readonly=“true”>
                            </div>
                        </div>
                        <div class="col-sm-6" id="divCityRegister">
                            <div class="form-group">
                                <label>Cidade</label> <label style="color: red; font-size: 12px;"> * </label>
                                <input type="text" name="localidade" id="localidade" class="form-control" style="cursor: not-allowed;" readonly=“true”>
                            </div>
                        </div>
                        <div class="col-sm-6" id="divStateRegister">
                            <div class="form-group">
                                <label>Estado</label> <label style="color: red; font-size: 12px;"> * </label>
                                <input type="text" name="uf" id="uf" class="form-control" style="cursor: not-allowed;" readonly=“true”>
                            </div>
                        </div>
                        <div class="col-sm-12" id="divTypeResidenceRegister">
                            <div class="form-group">
                                <label>Tipo de Residência</label> <label style="color: red; font-size: 12px;"> * </label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="optionHomeRegister" name="typeResidence" onclick="optionTypeResidenceRegister();">
                                    <label for="optionHomeRegister" class="custom-control-label">Casa</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="optionBuildingRegister" name="typeResidence" onclick="optionTypeResidenceRegister();">
                                    <label for="optionBuildingRegister" class="custom-control-label">Apartamento</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="optionCondominiumRegister" name="typeResidence" onclick="optionTypeResidenceRegister();">
                                    <label for="optionCondominiumRegister" class="custom-control-label">Condomínio</label>
                                </div>
                            </div>
                        </div>
                        <div id="divStreetCondominiumRegister" class="col-sm-5" style="display:none">
                            <div class="form-group">
                                <label>Rua do Condomínio</label> <label style="color: red; font-size: 12px;"> * </label>
                                <input type="text" name="streetCondominiumRegister" id="streetCondominiumRegister" class="form-control">
                            </div>
                        </div>
                        <div id="divNumberRegister" class="col-sm-3" style="display:none">
                            <div class="form-group">
                                <label>Número</label> <label style="color: red; font-size: 12px;"> * </label>
                                <input type="text" name="numberRegister" id="numberRegister" class="form-control">
                            </div>
                        </div>
                        <div id="divEdificeRegister" class="col-sm-7" style="display:none">
                            <div class="form-group">
                                <label>Edifício</label> <label style="color: red; font-size: 12px;"> * </label>
                                <input type="text" name="edificeRegister" id="edificeRegister" class="form-control">
                            </div>
                        </div>
                        <div id="divBlockRegister" class="col-sm-2" style="display:none">
                            <div class="form-group">
                                <label>Bloco</label> <label style="color: red; font-size: 12px;"> * </label>
                                <input type="text" name="blockRegister" id="blockRegister" class="form-control">
                            </div>
                        </div>
                        <div id="divApartmentRegister" class="col-sm-3" style="display:none">
                            <div class="form-group">
                                <label>Apto.</label> <label style="color: red; font-size: 12px;"> * </label>
                                <input type="text" name="apartmentRegister" id="apartmentRegister" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-12" id="divClientRegister" style="display:none;">
                            <div class="form-group">
                                <label>Cliente:</label> <label style="color: red; font-size: 12px;"> * </label>
                                <select class="form-control select2" name="clientRegister" id="clientRegister" style="width: 100%;">
                                    <?php foreach ($searchClientBudget->fetchAll(\PDO::FETCH_ASSOC) as $row) { ?>
                                        <option value="<?= $row['orca_numero'] ?>">
                                            <?= $row['orca_nome'] . " " . $row['orca_sobrenome'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Observações:</label>
                                <textarea class="form-control" rows="3" name="observationRegister" id="observationRegister" style="height: 50px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </div>
            </div>
        </form>
    </div>
</div>
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
<script src="<?= DIRJS . 'schedule/schedule-calendar/calendar.min.js' ?>"></script>
<!-- JQuery validation -->
<script src="<?= DIRJS . 'schedule/schedule-calendar/register-event-validation.min.js' ?>"></script>
<script src="<?= DIRJS . 'schedule/schedule-calendar/edit-event-validation.min.js' ?>"></script>
<!-- InputMask -->
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>
<!-- Busca endereço pelo CEP -->
<script src="<?= DIRJS . 'search-zip/search-zip.min.js' ?>"></script>
<!-- Date Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<!-- Select2 -->
<script src="<?= DIRPLUGINS . 'select2/js/select2.full.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'select2/js/i18n/pt-BR.js' ?>"></script>
<!-- Mensagem de crud -->
<?php if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
} ?>
<script type="text/javascript" language="javascript">
    /* Date Picker */
    $(document).ready(function() {
        var inputStartDateRegister = $('input[name="startDateRegister"]'); //our date input has the name "date"
        var container = $('.form-group form').length > 0 ? $('.form-group form').parent() : "body";
        inputStartDateRegister.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
            startDate: 'd',
            language: 'pt-BR',
            daysOfWeekDisabled: [0, 6],
        });
    });

    $(document).ready(function() {
        var inputStartDateRegister = $('input[name="startDateEdit"]'); //our date input has the name "date"
        var container = $('.form-group form').length > 0 ? $('.form-group form').parent() : "body";
        inputStartDateRegister.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
            startDate: 'd',
            language: 'pt-BR',
            daysOfWeekDisabled: [0, 6],
        });
    });

    /* Ao clicar nos campos, esconder teclado mobile */
    $(document).ready(function() {
        (function($) {
            // Criar plug-in que impede a exibição do teclado
            $.fn.preventKeyboard = function() {
                return this
                    .filter('input')
                    .on('focus', function() {
                        $(this)
                            .attr('readonly', 'readonly')
                            .blur()
                            .removeAttr('readonly');
                    });
            };
            $(document).ready(function($) {
                // Impedir a exibição do teclado para o campo de data.
                $('input[name=startDateRegister]').preventKeyboard();
            });
            $(document).ready(function($) {
                // Impedir a exibição do teclado para o campo de data.
                $('input[name=startDateEdit]').preventKeyboard();
            });
        }(jQuery));
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
        /* Datemask */
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        });
        /* Datemask */
        $('[data-mask]').inputmask();
    });
    //Initialize Select2 Elements
    $(".select2").select2({
        language: "pt-BR"
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/sys-ouse/app/View/schedule/schedule-calendar/schedule-calendar.blade.php ENDPATH**/ ?>