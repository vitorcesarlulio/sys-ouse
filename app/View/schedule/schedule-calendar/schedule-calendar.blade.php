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
                            <textarea class="form-control" id="observation" rows="2" disabled="" style="width: 70%;"> </textarea>
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
        <form id="formRegisterEvent" method="POST" autocomplete="off" enctype="multipart/form-data">
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

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Agendar Horario?</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionRegisterBasic" name="typeregister" onclick="selTypeRegister();" checked="">
                                        <label for="optionRegisterBasic" class="custom-control-label">Sim</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionRegisterComplete" name="typeregister" onclick="selTypeRegister();">
                                        <label for="optionRegisterComplete" class="custom-control-label">Não</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input type="text" name="name" class="form-control" autofocus placeholder="Entre com o Nome">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Sobrenome</label>
                                    <input type="text" name="surname" class="form-control" placeholder="Entre com o Sobrenome">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Celular</label>
                                    <input type="tel" inputmode="decimal" name="cellphone" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(99) 99999-9999&quot;" data-mask="" value="19" placeholder="Entre com o Celular">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Telefone</label>
                                    <input type="tel" inputmode="decimal" name="telephone" class="form-control" data-inputmask="&quot;mask&quot;: &quot;(99) 9999-9999&quot;" data-mask="" value="19" placeholder="Entre com o Telefone">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Entre com o Email">
                                </div>
                            </div>

                            <div class="col-sm-3">
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
                            <div class="col-sm-2">
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
                                </div>
                            </div>


                            <div id="number" class="col-sm-2" style="display:none">
                                <div class="form-group">
                                    <label>Número</label>
                                    <input type="text" name="number" class="form-control" placeholder="Entre com o Número">
                                </div>
                            </div>

                            <div id="edifice" class="col-sm-7" style="display:none">
                                <div class="form-group">
                                    <label>Edifício</label>
                                    <input type="text" name="edifice" class="form-control" placeholder="Entre com o Edifício">
                                </div>
                            </div>
                            <div id="block" class="col-sm-2" style="display:none">
                                <div class="form-group">
                                    <label>Bloco</label>
                                    <input type="text" name="block" class="form-control" placeholder="Entre com o Bloco">
                                </div>
                            </div>
                            <div id="apartment" class="col-sm-3" style="display:none">
                                <div class="form-group">
                                    <label>Apartamento</label>
                                    <input type="text" name="apartment" class="form-control" placeholder="Entre com o Apartamento">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Observações:</label>
                                    <textarea class="form-control" rows="3" style="height: 50px;">
                                    </textarea>
                                </div>
                            </div>





















                            <div class="col-sm-6" id="divTitleEvent">
                                <div class="form-group">
                                    <label>Titulo</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Titulo do Evento">
                                </div>
                            </div>
                            <div class="col-sm-6" id="divColorEvent">
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
                            <div class="col-sm-6" id="divStartEvent">
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
                            <div class="col-sm-6" id="divEndEvent">
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
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Hora</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" id="startTime" class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="hidden" class="btn toastrDefaultSuccess"></button>
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

<!-- InputMask (MASCARAS) -->
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>

<!-- Busca endereço pelo CEP -->
<script src="<?= DIRPLUGINS . 'search-zip/search-zip.js' ?>"></script>

<!-- jquery-validation (PRECISO PARA DAR A MENSAGEM e validar CPF, CPNJ EMAIL etc) -->
<script src="<?= DIRPLUGINS . 'jquery-validation/jquery.validate.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'jquery-validation/additional-methods.min.js' ?>"></script>


<!-- Bootstrap Switch -->
<script src="<?= DIRPLUGINS . 'bootstrap-switch/js/bootstrap-switch.min.js' ?>"></script>
<script>
    $(function() {
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
    });

    function selTypeRegister() {
        var optionRegisterBasic = document.getElementById("optionRegisterBasic").checked;
        if (optionRegisterBasic) {
            document.getElementById("divTitleEvent").style.display = "block";
            document.getElementById("divColorEvent").style.display = "block";
            document.getElementById("divStartEvent").style.display = "block";
            document.getElementById("divEndEvent").style.display = "block";
            document.getElementById("start").value = "";
            document.getElementById("end").value = "";
        } else {
            document.getElementById("divTitleEvent").style.display = "none";
            document.getElementById("divColorEvent").style.display = "none";
            document.getElementById("divStartEvent").style.display = "none";
            document.getElementById("divEndEvent").style.display = "none";
        }
    }

    function selTypeResidence() {
        var optionHome = document.getElementById("optionHome").checked;
        if (optionHome) {
            document.getElementById("edifice").style.display = "none";
            document.getElementById("block").style.display = "none";
            document.getElementById("apartment").style.display = "none";
            document.getElementById("number").style.display = "block";
        } else {
            document.getElementById("edifice").style.display = "block";
            document.getElementById("block").style.display = "block";
            document.getElementById("apartment").style.display = "block";
            document.getElementById("number").style.display = "none";
        }
    }

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