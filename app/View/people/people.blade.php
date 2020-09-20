<?php
require_once '../app/View/login/check-login.php';

include_once '../app/Model/connection-pdo.php';

/* $querySelectContact = " SELECT * FROM tb_contato ";
$searchContact = $connectionDataBase->prepare($querySelectContact);
$searchContact->execute(); */
?>
@extends('templates.default')

@section('title', 'Pessoas')

@section('head')
<!-- DataTables -->
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-bs4/css/dataTables.bootstrap4.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'datatables-responsive/css/responsive.bootstrap4.min.css' ?>">
<link rel="stylesheet" href="<?= DIRPLUGINS . 'select2/css/select2.min.css' ?>">
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
<li class="breadcrumb-item">Pessoas</li>
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
        <form role="form" id="formFiltersUsers" autocomplete="off" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
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
                        <button type="button" class="btn btn-block btn-success btn-sm" data-toggle="modal" data-target="#modalRegisterPeople">Novo</button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="listPeople" class="table table-hover">
                        <thead>
                            <tr>
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                                <th>4</th>
                                <th>5</th>
                                <th>6</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                                <th>4</th>
                                <th>5</th>
                                <th>6</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRegisterPeople" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form id="formRegisterPeople" method="POST" novalidate="novalidate" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Extra Large Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Tipo de Pessoa</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionPhysicalPerson" name="typePerson" onclick="selTypePerson();" checked="" value="F">
                                        <label for="optionPhysicalPerson" class="custom-control-label">Pessoa Física</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionPhysicalLegal" name="typePerson" onclick="selTypePerson();" value="J">
                                        <label for="optionPhysicalLegal" class="custom-control-label">Pessoa Jurídica</label>
                                    </div>
                                </div>
                            </div>
                            <div id="divPhysicalPerson" class="col-sm-2">
                                <div class="form-group">
                                    <label for="cpf">CPF</label>
                                    <input type="text" name="cpf" class="form-control" id="cpf" autofocus data-inputmask="'mask': ['999.999.999.99']" data-mask="" placeholder="Entre com CPF" onblur="findCPF();">
                                </div>
                            </div>
                            <div id="physicalLegal" class="col-sm-2" style="display: none;">
                                <div class="form-group">
                                    <label for="cnpj">CNPJ</label>
                                    <input type="text" name="cnpj" class="form-control" id="cnpj" data-inputmask="'mask': ['99.999.999/9999-99']" data-mask="" placeholder="Entre com CNPJ" onblur="ckeckCnpj(this.value);">
                                </div>
                            </div>
                            <div class="col-sm-2" id="divName">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Entre com o Nome">
                                </div>
                            </div>
                            <div class="col-sm-2" id="divSurname">
                                <div class="form-group">
                                    <label for="surname">Sobrenome</label>
                                    <input type="text" name="surname" class="form-control" id="surname" placeholder="Entre com o Sobrenome">
                                </div>
                            </div>
                            <div class="col-sm-2" style="display:none;" id="divCompanyName">
                                <div class="form-group">
                                    <label>Razão Social</label>
                                    <input type="text" name="companyName" class="form-control" id="companyName" placeholder="Entre com a Razão Social">
                                </div>
                            </div>
                            <div class="col-sm-2" style="display:none;" id="divFantasyName">
                                <div class="form-group">
                                    <label>Nome Fantasia</label>
                                    <input type="text" name="fantasyName" class="form-control" id="fantasyName" placeholder="Entre com o Nome Fantasia">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>CEP</label>
                                    <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/buscaCepEndereco.cfm" target="_blank"> <i class="fas fa-question-circle"></i> </a>
                                    <input type="text" class="form-control" name="cep" id="cep" data-inputmask="'mask': ['99999-999']" data-mask="" placeholder="Entre com o CEP" value="">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="logradouro">Logradouro</label>
                                    <input type="text" name="logradouro" class="form-control" style="cursor: not-allowed;" id="logradouro" placeholder="Entre com o Logradouro" readonly=“true”>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" name="bairro" class="form-control" style="cursor: not-allowed;" id="bairro" placeholder="Entre com o Bairro" readonly=“true”>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="localidade">Cidade</label>
                                    <input type="text" name="localidade" class="form-control" style="cursor: not-allowed;" id="localidade" placeholder="Entre com a Cidade" readonly=“true”>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="uf">Estado</label>
                                    <input type="text" name="uf" class="form-control" style="cursor: not-allowed;" id="uf" placeholder="Entre com o Estado" readonly=“true”>
                                </div>
                            </div>
                            <div class="col-sm-2" id="divTypeResidence">
                                <div class="form-group">
                                    <label>Tipo de Residência</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionHome" name="typeResidence" onclick="optionTypeResidence();" value="casa">
                                        <label for="optionHome" class="custom-control-label">Casa</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionBuilding" name="typeResidence" onclick="optionTypeResidence();" value="apartamento">
                                        <label for="optionBuilding" class="custom-control-label">Apartamento</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionCondominium" name="typeResidence" onclick="optionTypeResidence();" value="condominio">
                                        <label for="optionCondominium" class="custom-control-label">Condomínio</label>
                                    </div>
                                </div>
                            </div>
                            <div id="divStreetCondominium" class="col-sm-2" style="display:none">
                                <div class="form-group">
                                    <label>Rua do Condomínio</label>
                                    <input type="text" name="streetCondominium" id="streetCondominium" class="form-control">
                                </div>
                            </div>
                            <div id="divNumber" class="col-sm-2" style="display:none">
                                <div class="form-group">
                                    <label>Número</label>
                                    <input type="text" name="number" id="number" class="form-control">
                                </div>
                            </div>
                            <div id="divEdifice" class="col-sm-2" style="display:none">
                                <div class="form-group">
                                    <label>Edifício</label>
                                    <input type="text" name="edifice" id="edifice" class="form-control">
                                </div>
                            </div>
                            <div id="divBlock" class="col-sm-2" style="display:none">
                                <div class="form-group">
                                    <label>Bloco</label>
                                    <input type="text" name="block" id="block" class="form-control">
                                </div>
                            </div>
                            <div id="divApartment" class="col-sm-2" style="display:none">
                                <div class="form-group">
                                    <label>Apartamento</label>
                                    <input type="text" name="apartment" id="apartment" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Observações:</label>
                                    <textarea class="form-control" rows="3" name="observation" id="observation" style="height: 70px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-register-people" id="btnRegisterPeople">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalEditPeople" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form id="formEditPeople" method="POST" novalidate="novalidate" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Pessoa</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="idPeopleEdit" class="form-control" id="idPeopleEdit">
                            <div id="divPhysicalPersonEdit" class="col-sm-2">
                                <div class="form-group">
                                    <label for="cpfEdit">CPF</label>
                                    <input type="text" name="cpfEdit" class="form-control" id="cpfEdit" autofocus data-inputmask="'mask': ['999.999.999.99']" data-mask="" style="cursor: not-allowed;" disabled>
                                </div>
                            </div>
                            <div id="physicalLegalEdit" class="col-sm-2" style="display: none;">
                                <div class="form-group">
                                    <label for="cnpjEdit">CNPJ</label>
                                    <input type="text" name="cnpjEdit" class="form-control" id="cnpjEdit" data-inputmask="'mask': ['99.999.999/9999-99']" data-mask="" style="cursor: not-allowed;" disabled>
                                </div>
                            </div>
                            <div class="col-sm-2" id="divNameEdit">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" name="nameEdit" class="form-control" id="nameEdit" placeholder="Entre com o Nome">
                                </div>
                            </div>
                            <div class="col-sm-2" id="divSurnameEdit">
                                <div class="form-group">
                                    <label for="surnameEdit">Sobrenome</label>
                                    <input type="text" name="surnameEdit" class="form-control" id="surnameEdit" placeholder="Entre com o Sobrenome">
                                </div>
                            </div>
                            <div class="col-sm-2" style="display:none;" id="divCompanyNameEdit">
                                <div class="form-group">
                                    <label>Razão Social</label>
                                    <input type="text" name="companyNameEdit" class="form-control" id="companyNameEdit" placeholder="Entre com a Razão Social">
                                </div>
                            </div>
                            <div class="col-sm-2" style="display:none;" id="divFantasyNameEdit">
                                <div class="form-group">
                                    <label>Nome Fantasia</label>
                                    <input type="text" name="fantasyNameEdit" class="form-control" id="fantasyNameEdit" placeholder="Entre com o Nome Fantasia">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>CEP</label>
                                    <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/buscaCepEndereco.cfm" target="_blank"> <i class="fas fa-question-circle"></i> </a>
                                    <input type="text" class="form-control" name="cepEdit" id="cepEdit" data-inputmask="'mask': ['99999-999']" data-mask="" placeholder="Entre com o CEP" onblur="pesquisaCep(this.value);">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="logradouroEdit">Logradouro</label>
                                    <input type="text" name="logradouroEdit" class="form-control" style="cursor: not-allowed;" id="logradouroEdit" readonly=“true”>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="bairroEdit">Bairro</label>
                                    <input type="text" name="bairroEdit" class="form-control" style="cursor: not-allowed;" id="bairroEdit" readonly=“true”>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="localidadeEdit">Cidade</label>
                                    <input type="text" name="localidadeEdit" class="form-control" style="cursor: not-allowed;" id="localidadeEdit" readonly=“true”>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="ufEdit">Estado</label>
                                    <input type="text" name="ufEdit" class="form-control" style="cursor: not-allowed;" id="ufEdit" readonly=“true”>
                                </div>
                            </div>
                            <div class="col-sm-2" id="divTypeResidenceEdit">
                                <div class="form-group">
                                    <label>Tipo de Residência</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionHomeEdit" name="typeResidenceEdit" onclick="optionTypeResidenceEdit();" value="casa">
                                        <label for="optionHomeEdit" class="custom-control-label">Casa</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionBuildingEdit" name="typeResidenceEdit" onclick="optionTypeResidenceEdit();" value="apartamento">
                                        <label for="optionBuildingEdit" class="custom-control-label">Apartamento</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="optionCondominiumEdit" name="typeResidenceEdit" onclick="optionTypeResidenceEdit();" value="condominio">
                                        <label for="optionCondominiumEdit" class="custom-control-label">Condomínio</label>
                                    </div>
                                </div>
                            </div>
                            <div id="divStreetCondominiumEdit" class="col-sm-2" style="display:none">
                                <div class="form-group">
                                    <label>Rua do Condomínio</label>
                                    <input type="text" name="streetCondominiumEdit" id="streetCondominiumEdit" class="form-control">
                                </div>
                            </div>
                            <div id="divNumberEdit" class="col-sm-2" style="display:none">
                                <div class="form-group">
                                    <label>Número</label>
                                    <input type="text" name="numberEdit" id="numberEdit" class="form-control">
                                </div>
                            </div>
                            <div id="divEdificeEdit" class="col-sm-2" style="display:none">
                                <div class="form-group">
                                    <label>Edifício</label>
                                    <input type="text" name="edificeEdit" id="edificeEdit" class="form-control">
                                </div>
                            </div>
                            <div id="divBlockEdit" class="col-sm-2" style="display:none">
                                <div class="form-group">
                                    <label>Bloco</label>
                                    <input type="text" name="blockEdit" id="blockEdit" class="form-control">
                                </div>
                            </div>
                            <div id="divApartmentEdit" class="col-sm-2" style="display:none">
                                <div class="form-group">
                                    <label>Apartamento</label>
                                    <input type="text" name="apartmentEdit" id="apartmentEdit" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Observações:</label>
                                    <textarea class="form-control" rows="3" name="observationEdit" id="observationEdit" style="height: 70px;"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Data de Cadastro</label>
                                    <input type="text" name="dateInsertEdit" class="form-control" id="dateInsertEdit" style="cursor: not-allowed;" disabled>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Contato</h3>

                                    <div class="card-tools">
                                        <ul class="pagination pagination-sm float-right">
                                            <button type="button" class="btn btn-block btn-success btn-sm" id="btnNewContact">Novo</button>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tipo</th>
                                                <th>Responsavel</th>
                                                <th>Contato</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tBodyTableContact">
                                            

                                            <tr>
                                                <td>
                                                    <select class="form-control" name="selectTypeContact" id="selectTypeContact">
                                                        <option value="cellphone" id="optionCellphone">Celular</option>
                                                        <option value="telephone" id="optionTelephone">Telefone</option>
                                                        <option value="email" id="optionEmail">Email</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="responsibleContatec" class="form-control" id="responsibleContatec"></td>
                                                <td id="tdCellphone"><input type="tel" class="form-control contact" name="cellphoneRegister" id="cellphoneRegister" data-inputmask="&quot;mask&quot;: &quot;(99) 99999-9999&quot;" data-mask="" value=""></td>
                                                <td style="display: none;" id="tdEmail"><input type="email" class="form-control" name="emailRegister" id="emailRegister"></td>
                                                <td style="display: none;" id="tdTelephone"><input type="tel" class="form-control contact" name="telephoneRegister" id="telephoneRegister" data-inputmask="&quot;mask&quot;: &quot;(99) 9999-9999&quot;" data-mask="" value=""></td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" name="saveContact" class="btn btn-success btn-save-contact"><i class="fas fa-save"></i></button>
                                                        <button type="button" name="deleteLine" class="btn btn-danger btn-delete-line"><i class="fas fa-minus"></i> </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-success" id="btnEditPeople">Salvar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</div>
@endsection

@section('script')
<script src="<?= DIRPLUGINS . 'datatables/jquery.dataTables.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-bs4/js/dataTables.bootstrap4.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-responsive/js/dataTables.responsive.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'datatables-responsive/js/responsive.bootstrap4.min.js' ?>"></script>
<script src="<?= DIRJS . 'people/people.js' ?>"></script>
<script src="<?= DIRJS . 'people/edit-people-validation.js' ?>"></script>
<script src="<?= DIRJS . 'people/register-people-validation.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'moment/moment.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'inputmask/min/jquery.inputmask.bundle.min.js' ?>"></script>
<script src="<?= DIRPLUGINS . 'select2/js/select2.full.min.js' ?>"></script>
<script>
    $(function() { $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
    $('[data-mask]').inputmask()});
    $('.select2').select2();
</script>
<script src="<?= DIRJS . 'search-zip/search-zip.js' ?>"></script>

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